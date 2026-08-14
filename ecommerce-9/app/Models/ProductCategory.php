<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // Relasi One-to-Many: Satu kategori memiliki banyak produk
    public function products(): HasMany
    {
        return $this->hasMany(Products::class, 'product_category_id');
    }
}