<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Card;
use Illuminate\Validation\Rule;
use App\Rules\FileTypeValidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubCategoryController extends Controller
{



   public function subCategory(Request $request) {
    try {
        $pageTitle = 'Manage Sub Category';

        // Obter todas as categorias ativas
        $categories = Category::where('status', 1)->latest()->get();

        // Se categoryId não estiver definido na requisição, usar o ID da primeira categoria
        $categoryId = $request->categoryId;
        if (empty($categoryId) && $categories->isNotEmpty()) {
            $categoryId = $categories->first()->id;
        }

        // Filtrar subcategorias baseado na categoria selecionada
        $subCategoriesQuery = SubCategory::with('category', 'card');
        if ($categoryId) {
            $subCategoriesQuery->where('category_id', $categoryId);
        }
        
        $subCategories = $subCategoriesQuery->orderBy('order', 'asc')->get();
        
        foreach ($subCategories as $subCategory) {
            $subCategory->totalAvailableCards = DB::table('cards')
                ->where('sub_category_id', $subCategory->id)
                ->where(function($query) {
                    $query->where(function($q) {
                        $q->where('user_id', 0)
                          ->where('revender', 0);
                    })
                    ->orWhere(function($q) {
                        $q->where('revender', 1);
                    });
                })
                ->sum(DB::raw('CASE WHEN revender = 1 THEN disponivel ELSE 1 END'));
        }
        
        $emptyMessage = 'Data Not Found';
        
        return view('admin.card.sub_category', compact('pageTitle', 'subCategories', 'emptyMessage', 'categories', 'categoryId'));
    } catch (\Exception $exception) {
        Log::error($exception->getMessage());
        return back()->with(['error' => 'Erro interno no servidor. Por favor, tente novamente.']);
    }
}

    
    
    



    public function delete(Request $request){
        $request->validate([
            'id' => 'required|exists:sub_categories,id',
        ]);

        $findSubCategory = SubCategory::findOrFail($request->id);

        if (!$findSubCategory) {
            $notify[] = ['error', 'Desculpe, esta subcategoria já foi retirada'];
            return back()->withNotify($notify);
        }

        // Exclua todos os cartões associados a esta subcategoria
        foreach ($findSubCategory->card as $card) {
            // Aqui você pode adicionar qualquer outra lógica necessária antes de excluir o cartão
            $card->delete();
        }

        // Agora, você pode excluir a subcategoria
        $findSubCategory->delete();

        $notify[] = ['success', 'Subcategoria e todos os cartões associados excluídos com sucesso'];
        return back()->withNotify($notify);
    }

    public function add(Request $request){
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'price' => 'numeric|gt:0|required',
        'image' => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        'name' => [
            'required',
            Rule::unique('sub_categories')->where(function ($query) use ($request) {
                return $query->where('category_id', $request->category_id)
                    ->where('name', $request->name);
            }),
        ],
        'detalhes' => 'nullable|string', // Ajuste o nome do campo para 'detalhes'
        'sku' => 'nullable|string|unique:sub_categories,sku',

    ]);

    $newSubCategory = new SubCategory();
    $newSubCategory->category_id = $request->category_id;
    $newSubCategory->name = $request->name;
    $newSubCategory->price = $request->price;
    $newSubCategory->detalhes = $request->detalhes; // Ajuste o nome do campo para 'detalhes'
    $newSubCategory->sku = $request->sku;

    
    // Adiciona o upload da imagem
    $newSubCategory->image = uploadImage($request->image, imagePath()['sub_category']['path'], imagePath()['sub_category']['size']);
    
    $newSubCategory->save();

    $notify[] = ['success', 'Subcategoria Adicionada com sucesso'];
    return back()->withNotify($notify);
}


public function clone(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'price' => 'numeric|gt:0|required',
        'name' => [
            'required',
            Rule::unique('sub_categories')->where(function ($query) use ($request) {
                return $query->where('category_id', $request->category_id)
                    ->where('name', $request->name);
            }),
        ],
        'detalhes' => 'nullable|string',
    ]);

    $findSubCategory = SubCategory::find($request->id);

    $newSubCategory = $findSubCategory->replicate();
    $newSubCategory->category_id = $request->category_id;
    $newSubCategory->name = $request->name;
    $newSubCategory->price = $request->price;
    $newSubCategory->detalhes = $request->detalhes;

    if ($request->hasFile('image')) {
        $newSubCategory->image = uploadImage(
            $request->image,
            imagePath()['sub_category']['path'],
            imagePath()['sub_category']['size']
        );
    }

    $newSubCategory->save();

    $notify[] = ['success', 'Suncategoria Clonada com sucesso !'];
    return back()->withNotify($notify);
}




    public function edit(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'price' => 'numeric|gt:0|required',
        'id' => 'required|exists:sub_categories,id',
        'image' => ['sometimes', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        'name' => [
            'required',
            Rule::unique('sub_categories')->ignore($request->id)->where(function ($query) use ($request) {
                return $query->where('category_id', $request->category_id)
                    ->where('name', $request->name);
            }),
        ],
        'detalhes' => 'nullable|string',
        'sku' => 'nullable|string|unique:sub_categories,sku,' . $request->id,

    ]);

    $findSubCategory = SubCategory::find($request->id);
    $findSubCategory->category_id = $request->category_id;
    $findSubCategory->sku = $request->sku;
    $findSubCategory->name = $request->name;
    $findSubCategory->price = $request->price;
    $findSubCategory->detalhes = $request->detalhes;
    


    if ($request->hasFile('image')) {
        $findSubCategory->image = uploadImage(
            $request->image,
            imagePath()['sub_category']['path'],
            imagePath()['sub_category']['size'],
            $findSubCategory->image
        );
    }

    $findSubCategory->save();

    $notify[] = ['success', 'Subcategoria editada com sucesso'];
    return back()->withNotify($notify);
}

public function moveUp(Request $request)
{
    DB::transaction(function () use ($request) {
        $subCategory = SubCategory::findOrFail($request->id);
        // Encontra a subcategoria imediatamente acima na mesma categoria
        $aboveSubCategory = SubCategory::where('category_id', $subCategory->category_id)
                                       ->where('order', '<', $subCategory->order)
                                       ->orderBy('order', 'desc')
                                       ->first();

        if ($aboveSubCategory) {
            // Troca os valores de 'order'
            $currentOrder = $subCategory->order;
            $subCategory->order = $aboveSubCategory->order;
            $aboveSubCategory->order = $currentOrder;

            $aboveSubCategory->save();
            $subCategory->save();
        } else {
            // Se não houver subcategoria acima, significa que já está na ordem mais alta
            return back()->with('error', 'Esta subcategoria já está na ordem mais alta.');
        }
    });

    return back()->with('success', 'Subcategoria movida para cima com sucesso.');
}



public function moveDown(Request $request)
{
    DB::transaction(function () use ($request) {
        $subCategory = SubCategory::findOrFail($request->id);
        // Encontra a subcategoria imediatamente abaixo na mesma categoria
        $belowSubCategory = SubCategory::where('category_id', $subCategory->category_id)
                                       ->where('order', '>', $subCategory->order)
                                       ->orderBy('order', 'asc')
                                       ->first();

        if ($belowSubCategory) {
            // Troca os valores de 'order'
            $currentOrder = $subCategory->order;
            $subCategory->order = $belowSubCategory->order;
            $belowSubCategory->order = $currentOrder;

            $belowSubCategory->save();
            $subCategory->save();
        }
    });

    return back()->with('success', 'Subcategoria movida para baixo com sucesso.');
}


}
