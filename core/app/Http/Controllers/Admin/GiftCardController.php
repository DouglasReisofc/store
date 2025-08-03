<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftCard;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\User;

class GiftCardController extends Controller
{
    public function index()
{
    $pageTitle = 'Gerenciar Gift Cards';
    $giftcards = GiftCard::with('user')->get();
    $emptyMessage = 'Nenhum gift card encontrado';
    return view('admin.giftcards.index', compact('pageTitle', 'giftcards', 'emptyMessage'));
}


    public function create()
    {
        $pageTitle = 'Novo Gift Card';
        return view('admin.giftcards.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:gift_cards,code',
            'amount' => 'required|numeric',
        ]);

        GiftCard::create([
            'code' => $request->code,
            'amount' => $request->amount,
            // 'user_id' é null por padrão ao criar um novo gift card
        ]);

        return redirect()->route('admin.giftcards.index')
                         ->with('success', 'Gift card adicionado com sucesso.');
    }

    public function edit(GiftCard $giftcard)
    {
        $pageTitle = 'Editar Gift Card';
        return view('admin.giftcards.edit', compact('pageTitle', 'giftcard'));
    }

    public function update(Request $request, GiftCard $giftcard)
    {
        $request->validate([
            'code' => 'required|unique:gift_cards,code,' . $giftcard->id,
            'amount' => 'required|numeric',
        ]);

        $giftcard->update([
            'code' => $request->code,
            'amount' => $request->amount,
            // Não atualize 'user_id' aqui, ele é definido quando o gift card é resgatado
        ]);

        return redirect()->route('admin.giftcards.index')
                         ->with('success', 'Gift card atualizado com sucesso.');
    }

    public function destroy(GiftCard $giftcard)
    {
        $giftcard->delete();
        return redirect()->route('admin.giftcards.index')
                         ->with('success', 'Gift card excluído com sucesso.');
    }
}
