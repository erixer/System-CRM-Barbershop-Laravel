<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\produk;
use App\Models\User;
use App\Models\Payment;
class order_produk extends Model
{
    use HasFactory;

    protected $table = 'order_produks';
    //protected $guarded = [];

    protected $guarded = [];
    public function produk()
    {
        return $this->belongsToMany(produk::class, 'orders_produks', 'order_id')->withPivot('qty')->withPivot('total');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'customer');
    }


    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
