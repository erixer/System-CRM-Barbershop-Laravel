<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use PDF;


class pendapatanBookingController extends Controller
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


        $order_service = Order::all();
        /*
        $order_service = DB::table('users')
                        ->join('orders', 'users.id', 'orders.customer')
                        ->join('order_service', 'orders.id', 'order_service.order_id')
                        ->join('services', 'services.id', 'order_service.service_id')


                        ->select(
                            'orders.id as service_id',
                            'users.first_name as nama_user',
                            'orders.net as harga_normal',
                            'orders.gross as harga_discount',
                            'orders.discount as discount',
                            'orders.tanggal as tanggal',
                            'services.name',
                            'order_service.qty as qty',
                            'services.name as service',
                        )->get();
        */
        $order = DB::table('orders')
            ->select(DB::raw('SUM(COALESCE(gross, net)) as total_harga'));

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
            $oder = $order->whereBetween('orders.tanggal', [$start_date, $end_date]);
            $order_service = Order::whereBetween('tanggal', [$start_date, $end_date])->get();
        }
        
        
        $order = $order->get();

        return view('admin.laporan.booking', compact('start_date', 'end_date', 'order_service', 'order'));
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
        
        
        //order_service
        $order_service = Order::all();

        $order = DB::table('orders')
            ->select(DB::raw('SUM(COALESCE(gross, net)) as total_harga'));

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
            $order = $order->whereBetween('orders.tanggal', [$start_date, $end_date]);
            $order_service = Order::whereBetween('tanggal', [$start_date, $end_date])->get();
        }

        $order = $order->get();
        $pdf = PDF::loadView('admin.laporan.PDFPendapatanBooking', compact('start_date', 'end_date', 'order_service', 'order'));
        return $pdf->download('laporan Pendapatan Booking.pdf');
    }
}
