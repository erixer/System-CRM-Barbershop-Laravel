<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\order_produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class customersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $customer_find = User::where('id', $id)->first();
        $order = DB::table('users')
        ->join('orders', 'users.id', '=', 'orders.customer')
        ->join('order_service', 'orders.id', '=', 'order_service.order_id')
        ->join('services', 'services.id', '=', 'order_service.service_id')
        ->select(
            'orders.id as service_order_id',
            'services.name',
            'order_service.qty as service_qty',
            DB::raw('SUM(order_service.qty) as qty')
        )->groupBy('users.first_name', 'users.id', 'order_service.qty', 'orders.id', 'services.name')
        ->where('users.id', $id)
        ->get();

        return view('admin.pelanggan.show', compact('order', 'customer_find'));
        

        /*
        $customer_find = User::where('id', $id)->first();
        $orderServices = Order::where('customer', $id)
                                ->get();

        $orderProduks = order_produk::where('customer', $id)
                                ->get();
        dd($orderServices);
        
        return view('admin.pelanggan.show', compact('orderServices', 'orderProduks', 'customer_find'));

        */



        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer_find = User::where('id', $id)->first();
        $order = DB::table('users')->select(
            'order_produks.id as service_order_id',
            'produks.name',
            DB::raw('SUM(orders_produks.qty) as qty')
            )
        ->join('order_produks', 'users.id', '=', 'order_produks.customer')
        ->join('orders_produks', 'order_produks.id', '=', 'orders_produks.order_id')
        ->join('produks', 'produks.id', '=', 'orders_produks.produk_id')
        ->where('users.id', $id)
        ->groupBy('users.first_name', 'users.id', 'orders_produks.qty', 'order_produks.id', 'produks.name')
        ->get();

        return view('admin.pelanggan.produk', compact('order', 'customer_find'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function exportPDFCustomer(Request $request)
    {
        

        $customer = User::whereRoleIs('customer')->get();   


        $pdf = PDF::loadView('admin.laporan.PDFCustomer', compact('customer'));

        return $pdf->download('laporan Customer.pdf');
    }       
}
