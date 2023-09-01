<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\produk;

class categoryProduk extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function produks()
    {
        return $this->hasMany(produk::class, 'category_id');
    }
}
