<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Adicionando o novo campo 'order' à lista de atributos que podem ser atribuídos em massa
    protected $fillable = ['name', 'image', 'featured', 'status', 'order'];

    /**
     * Este método define um relacionamento de "um para muitos" com o modelo SubCategory.
     * A utilização do nome 'subCategory' aqui é uma escolha de design; você poderia usar 'subCategories'
     * para tornar mais claro que espera-se mais de um resultado.
     */
    public function subCategory(){
        return $this->hasMany(SubCategory::class);
    }
}
