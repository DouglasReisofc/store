<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id',
        'details',
        'user_id',
        'trx',
        'purchase_at',
        'revender',
        'card_validity',
        'disponivel', // Adicionado 'disponivel' à lista de preenchíveis
    ];

    public function subCategory()
    {
        return $this->belongsTo('App\Models\SubCategory');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
