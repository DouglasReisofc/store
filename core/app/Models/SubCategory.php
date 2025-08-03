<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    /**
     * Relação com Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relação com Card.
     */
    public function card()
    {
        return $this->hasMany(Card::class, 'sub_category_id', 'id');
    }

    // Adicione mais relações conforme necessário.
}