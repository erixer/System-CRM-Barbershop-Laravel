<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\produk;

class cart extends Model
{
    use HasFactory;

    protected $fillable = ['id_users', 'id_produk', 'qty'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produkss()
    {
        return $this->belongsTo(produk::class, 'id_produk');
    }
}
