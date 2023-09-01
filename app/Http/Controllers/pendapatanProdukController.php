<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\order_produk;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class pendapatanProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $order_produk = order_produk::all();
        
        /*
        $order_produk = DB::table('users')
                        ->join('order_produks', 'users.id', 'order_produks.customer')
                        ->join('orders_produks', 'order_produks.id', 'orders_produks.order_id')
                        ->join('produks', 'produks.id', 'orders_produks.produk_id')


                        ->select(
                            'order_produks.id as produk_id',
                            'users.first_name as nama_user',
                            'order_produks.net as harga_normal',
                            'order_produks.gross as harga_discount',
                            'order_produks.discount as discount',
                            'order_produks.tanggal as tanggal',
                            'orders_produks.qty as qty',
                            'produks.name as produk',
                        )->get();

        $order = DB::table('order_produks')
            ->select(DB::raw('SUM(COALESCE(gross, net)) as harga_discount'));
        */
        $order = DB::table('order_produks')
            ->select(DB::raw('SUM(COALESCE(gross, net)) as total_harga'));

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
            $order = $order->whereBetween('order_produks.tanggal', [$start_date, $end_date]);
            $order_produk = order_produk::whereBetween('tanggal', [$start_date, $end_date])->get();
        }

        //$order_produk = $order_produk->get();
        $order = $order->get();

        return view('admin.laporan.produk', compact('start_date', 'end_date', 'order_produk', 'order'),
        
        );
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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



    public function exportPDF(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        
        
        //order_produks
        $order_produk = order_produk::all();

        $order = DB::table('order_produks')
            ->select(DB::raw('SUM(COALESCE(gross, net)) as total_harga'));

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
            $order = $order->whereBetween('order_produks.tanggal', [$start_date, $end_date]);
            $order_produk = order_produk::whereBetween('tanggal', [$start_date, $end_date])->get();
        }

        $order = $order->get();
        $pdf = PDF::loadView('admin.laporan.PDFPendapatanProduk', compact('start_date', 'end_date', 'order_produk', 'order'));
        return $pdf->download('laporan Pendapatan Produk.pdf');
    }
}
