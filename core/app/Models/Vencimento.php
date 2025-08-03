<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vencimento extends Model
{
    use HasFactory;

    protected $table = 'vencimento';

    protected $fillable = [
        'user_id', 'sub_category_id', 'details', 'trx',
        'purchase_at', 'created_at', 'updated_at',
        'card_validity', 'notificar', 'card_id', 'card_quantity',
    ];

    protected $casts = [
        'purchase_at' => 'datetime', // Garante que purchase_at seja uma instância de Carbon
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relação com SubCategory.
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Adicione mais relações conforme necessário.
}
