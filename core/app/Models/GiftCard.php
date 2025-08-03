<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User; // Importe o modelo User

class GiftCard extends Model
{
    protected $fillable = ['code', 'amount', 'user_id'];

    // Definindo o relacionamento com o modelo User
    public function user(){
    return $this->belongsTo('App\Models\User');
}

}
