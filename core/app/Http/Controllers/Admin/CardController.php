<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Card;
use App\Rules\FileTypeValidate;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\Vencimento;
use Carbon\Carbon;

class CardController extends Controller
{

    public function card(Request $request){
        $pageTitle = 'Manage Card';
    
        // Verifique se foi fornecido um subcategoryId no request
        $subcategoryId = $request->input('subcategoryId');
        $trx = $request->trx;
    
        // Busque as subcategorias
        $subCategories = SubCategory::whereHas('category', function($query){
                            $query->where('status', 1);
                        })->latest()->get();
    
        // Busque os cartões com base no subcategoryId, se fornecido, e aplique paginação
        $cardsQuery = Card::with(['subCategory.category', 'user'])
                          ->when($subcategoryId, function ($query) use ($subcategoryId) {
                              return $query->where('sub_category_id', $subcategoryId);
                          })
                          ->when($trx, function ($query) use ($trx) {
                              return $query->where('trx', 'like', "%{$trx}%");
                          })
                          ->latest();
    
        $cards = $cardsQuery->paginate(50); // Altere 50 para qualquer número de itens que você deseja por página
    
        $emptyMessage  = 'Nada por aqui ainda';
        
        // Retorne a visualização com as subcategorias, cartões e dados da paginação
        return view('admin.card.card', compact('pageTitle', 'cards', 'emptyMessage', 'subCategories'));
    }
    


public function vendidos(Request $request){
    $pageTitle = 'Produtos Vendidos';

    // Busca todas as subcategorias para o seletor
    $subCategories = SubCategory::whereHas('category', function($query){
                        $query->where('status', 1);
                    })->latest()->get();

    $subcategoryId = $request->input('subcategoryId');

    // Busca os produtos vendidos com base no subcategoryId, se fornecido
    $vencimentosQuery = Vencimento::with(['subCategory', 'user'])
                        ->when($subcategoryId, function ($query) use ($subcategoryId) {
                            return $query->where('sub_category_id', $subcategoryId);
                        })
                        ->orderBy('purchase_at', 'desc');

    $vencimentos = $vencimentosQuery->get();
    $emptyMessage  = 'Nenhum produto vendido encontrado';
    
    // Retorne a visualização com os produtos vendidos e subcategorias
    return view('admin.card.vendidos', compact('pageTitle', 'vencimentos', 'emptyMessage', 'subCategories'));
}




    public function addPage(){
        $pageTitle = 'Add New Card';
        $subCategories = SubCategory::whereHas('category', function($query){
                            $query->where('status', 1);
                        })->latest()->get();
        return view('admin.card.add_card', compact('pageTitle', 'subCategories'));
    }

    public function add(Request $request)
{
    $request->validate([
        'details.*' => 'required|string|max:65000',
        'sub_category' => 'required|exists:sub_categories,id',
        'image.*' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        'revender.*' => 'required|in:0,1',
        'card_validity.*' => 'required|integer|min:1', // Validando a validade do cartão
        // Removendo a validação específica de 'disponivel.*' aqui, pois será tratada no loop
    ]);

    for ($i = 0; $i < count($request->details); $i++) {
        $newCard = new Card();
        $newCard->sub_category_id = $request->sub_category;
        $newCard->details = $request->details[$i];
        $newCard->revender = $request->revender[$i];
        $newCard->card_validity = $request->card_validity[$i]; // Salvando a validade do cartão

        // Define 'disponivel' como 1 por padrão se revender for 0, ou usa o valor fornecido se revender for 1
        $newCard->disponivel = ($newCard->revender == 1) ? ($request->disponivel[$i] ?? 1) : 1;

        if (!empty($request->image[$i])) {
            $newCard->image = uploadImage(
                $request->image[$i],
                imagePath()['card']['path'],
                imagePath()['card']['size']
            );
        }

        $newCard->save();
    }

    $notify[] = ['success', 'Card Added Successfully'];
    return redirect()->route('admin.card.index')->withNotify($notify);
}



    public function editPage($id){
        $card = Card::findOrFail($id);
        $pageTitle = 'Edit Card';
        $subCategories = SubCategory::latest()->get();
        return view('admin.card.edit_card', compact('pageTitle', 'subCategories', 'card'));
    }


    public function edit(Request $request) {
        $request->validate([
            'details' => 'required|string|max:65000',
            'sub_category' => 'required|exists:sub_categories,id',
            'id' => 'required|exists:cards,id',
            'image' => ['sometimes', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'revender' => 'required|in:0,1',
            'disponivel' => 'nullable|integer|min:1',
            'card_validity' => 'required|integer|min:1',
        ]);
    
        $findCard = Card::findOrFail($request->id);
        $findCard->sub_category_id = $request->sub_category;
        $findCard->details = $request->details;
        $findCard->revender = $request->revender;
        $findCard->disponivel = $request->disponivel ?? $findCard->disponivel;
        $findCard->card_validity = $request->card_validity;
    
        if ($request->hasFile('image')) {
            $findCard->image = uploadImage(
                $request->image, 
                imagePath()['card']['path'], 
                imagePath()['card']['size'], 
                $findCard->image
            );
        }
    
        $findCard->save();
    
        // Obtenha o usuário associado ao cartão
        $userDirectlyNotified = false;
        $user = $findCard->user;
        if ($user) {
            notify($user, 'CARD_EDIT', [
                'text' => "{$findCard->details}",
            ]);
            $userDirectlyNotified = true;
        }
    
        // Atualiza e notifica os usuários relacionados, exceto se já foram notificados diretamente
        $relatedVencimentos = Vencimento::where('trx', $findCard->trx)
                                         ->where('sub_category_id', $findCard->sub_category_id)
                                         ->where('card_validity', '>', Carbon::now())
                                         ->get();
    
        foreach ($relatedVencimentos as $vencimento) {
            $vencimento->details = $request->details;
            $vencimento->save();
            
            if (!$userDirectlyNotified || $vencimento->user_id !== $user->id) {
                $user = User::find($vencimento->user_id);
                if ($user) {
                    notify($user, 'CARD_EDIT', [
                        'text' => "Detalhes do cartão atualizados: {$request->details}",
                    ]);
                }
            }
        }
    
        $notify[] = ['success', 'Cartão e registros relacionados atualizados com sucesso, notificações enviadas.'];
        return back()->withNotify($notify);
    }
    
    










    public function delete(Request $request){

        $request->validate([
            'id'=> 'required|exists:cards,id',
        ]);

        $findCard = Card::findOrFail($request->id);

        if(!$findCard){
            $notify[] = ['error', 'Desculpe, este cartão já foi retirado'];
            return back()->withNotify($notify);
        }

        removeFile(imagePath()['card']['path'].'/'.$findCard->image);

        $findCard->delete();

        $notify[] = ['success', 'Cartão excluído com sucesso'];
        return back()->withNotify($notify);
    }


}
