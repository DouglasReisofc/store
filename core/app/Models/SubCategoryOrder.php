<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryOrder extends Model
{
    use HasFactory;

    protected $fillable = ['sub_category_id', 'order'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
