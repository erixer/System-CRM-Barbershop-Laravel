<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\categoryProduk;
use App\Models\order_produk;
class produk extends Model
{
    use HasFactory;
    public $table = "produks";
    
    
    public function category()
    {
        return $this->belongsTo(categoryProduk::class);
    }

    public function order_produk()
    {
        return $this->belongsToMany(order_produk::class, 'id')->withPivot('qty')->withPivot('total');
    }
}
