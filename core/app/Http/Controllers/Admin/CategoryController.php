<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Card;
use App\Rules\FileTypeValidate;

class CategoryController extends Controller
{

    public function category()
    {
        try {
            $pageTitle = 'Manage Category';
            $categories = Category::orderBy('order', 'asc')->get(); // Alterado aqui
            $emptyMessage = 'Data Not Found';
            return view('admin.card.category', compact('pageTitle', 'categories', 'emptyMessage'));
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    


public function deleteCategory(Request $request)
{
    $request->validate([
        'id' => 'required|exists:categories,id',
    ]);

    $findCategory = Category::findOrFail($request->id);

    if (!$findCategory) {
        $notify[] = ['error', 'Desculpe, esta categoria já foi retirada'];
        return back()->withNotify($notify);
    }

    // Verifica se há subcategorias associadas
    if ($findCategory->subCategory) {
        // Exclua todos os cartões associados às subcategorias desta categoria
        foreach ($findCategory->subCategory->card as $card) {
            $card->delete();
        }

        // Exclua todas as subcategorias associadas a esta categoria
        $findCategory->subCategory->delete();
    }

    // Agora, você pode excluir a categoria
    $findCategory->delete();

    $notify[] = ['success', 'Categoria, subcategorias e todos os cartões associados excluídos com sucesso'];
    return back()->withNotify($notify);
}


    public function add(Request $request){

        $request->validate([
            'name'=> 'string|max:191|required|unique:categories,name',
            'image' => ['required','image',new FileTypeValidate(['jpg','jpeg','png'])],
            'status' => 'sometimes|in:on'
        ]);

        $newCategory = new Category();
        $newCategory->name = $request->name;
        $newCategory->status = isset($request->status) ? 1 : 0;
        $newCategory->image = uploadImage(
                                $request->image,
                                imagePath()['category']['path'],
                                imagePath()['category']['size']
                            );
        $newCategory->save();

        $notify[] = ['success', 'Categoria adicionada com sucesso'];
        return back()->withNotify($notify);
    }

    public function edit(Request $request){

        $request->validate([
            'name'=> 'string|max:191|required|unique:categories,name,'.$request->id,
            'id'=> 'required|exists:categories,id',
            'image' => ['sometimes','image',new FileTypeValidate(['jpg','jpeg','png'])],
            'status' => 'sometimes|in:on'
        ]);

        $findCategory = Category::find($request->id);
        $findCategory->name = $request->name;
        $findCategory->status = isset($request->status) ? 1 : 0;

        if($request->hasFile('image')){
            $findCategory->image = uploadImage(
                $request->image,
                imagePath()['category']['path'],
                imagePath()['category']['size'],
                $findCategory->image
            );
        }

        $findCategory->save();

        $notify[] = ['success', 'Categoria editada com sucesso'];
        return back()->withNotify($notify);
    }

    public function featured(Request $request){

        $request->validate([
            'id'=> 'required|exists:categories,id',
        ]);

        $findCategory = Category::find($request->id);

        if($findCategory->featured == 1){
            $findCategory->featured = 0;
            $findCategory->save();
            $notify[] = ['success', 'Categoria não apresentada com sucesso'];
        }else{
            $findCategory->featured = 1;
            $findCategory->save();
            $notify[] = ['success', 'Categoria apresentada com sucesso'];
        }

        return back()->withNotify($notify);


    }

    public function moveUp(Request $request)
    {
        $category = Category::find($request->id);
        // Supondo que 'order' é um campo que define a posição das categorias
        if ($category && $category->order > 1) {
            // Trocar posição com a categoria imediatamente anterior
            $previousCategory = Category::where('order', '<', $category->order)->orderBy('order', 'desc')->first();
            if ($previousCategory) {
                $tempOrder = $previousCategory->order;
                $previousCategory->order = $category->order;
                $category->order = $tempOrder;
                $previousCategory->save();
                $category->save();
            }
        }
        return back()->with('success', 'Categoria movida para cima.');
    }
    
    public function moveDown(Request $request)
    {
        $category = Category::find($request->id);
        // Similar ao moveUp, mas troca com a próxima categoria
        if ($category) {
            $nextCategory = Category::where('order', '>', $category->order)->orderBy('order')->first();
            if ($nextCategory) {
                $tempOrder = $nextCategory->order;
                $nextCategory->order = $category->order;
                $category->order = $tempOrder;
                $nextCategory->save();
                $category->save();
            }
        }
        return back()->with('success', 'Categoria movida para baixo.');
    }
    


}
