<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Categories extends Model
{
    protected $fillable = ['nama_kategori', 'description',];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
