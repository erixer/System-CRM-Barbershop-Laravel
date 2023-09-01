<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;
use App\Models\User;
use App\Models\testimoni;
use App\Models\display_discount;


class cardController extends Controller
{
    public function index()
    {      
        $cart = json_decode(request()->cookie('dw-carts'), true);
        return view('template.template', compact('cart'),[
            'produk' => produk::all(),
            'testimonie' => testimoni::take(3)->inRandomOrder()->get(),
            'discount' => display_discount::all(),
            'wa' => User::find(1),
        ]);
    }

    public function show($id)
    {
        $cart = json_decode(request()->cookie('dw-carts'), true);
        return view('template.shoppingCart', compact('cart'), [
            'produk' => produk::find($id),
            'produks' => produk::all(),
        ]);
    }

    
}
