<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PelangganController extends Controller
{
    public function index()
    {
        return view('admin.pelanggan.index', [
            'pelanggan' => User::whereRoleIs('customer')->get(),
        ]);
    }

    public function show($id){
        $customer_find = User::where('id', $id)->first();

        $customer = DB::table('users')
        ->select('users.first_name', 'users.hp', 'order_services.service_id', DB::raw('SUM(order_services.qty) as qty'))
        ->leftJoin('orders', 'users.id', '=', 'orders.customer')
        ->leftJoin('order_services', 'orders.id', '=', 'order_services.order_id')
        ->where('users.id', '=', $id)
        ->groupBy('users.first_name', 'users.id', 'order_service.service_id')
        ->get();

        return view('admin.pelanggan.show', compact('customer', 'customer_find'));
    }
}
