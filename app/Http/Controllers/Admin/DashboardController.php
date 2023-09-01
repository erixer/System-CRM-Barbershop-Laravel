<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\keluhan;
use App\Models\testimoni;
use App\Models\Location;
use App\Models\produk;
use App\Models\order_produk;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('staff')) {
            return redirect()->route('order.index');
        }

        $today = Carbon::today('Asia/Jakarta');
        //$keluhan = order_produk::where('tanggal', $today)->where('customer', Auth::user()->id ?? '')->get();
        $totalPendapatan = DB::table('order_produks')->where('tanggal', $today)
                            ->select(DB::raw('SUM(COALESCE(gross, net)) as total'))
                            ->union(DB::table('orders')->where('tanggal', $today)
                            ->select(DB::raw('SUM(COALESCE(gross, net)) as total')))
                            ->get()
                            ->sum('total');

        
        $orderProduks = order_produk::where('tanggal', $today)->get();
        $orderServices = Order::where('tanggal', $today)->get();

        $topCustomers = User::where('kunjungan', '>=', 5)->orderBy('kunjungan', 'desc')->limit(10)->get();

        $topProduk = produk::select('produks.id', 'produks.name', 'produks.price', 'produks.images', 'produks.slug', DB::raw('SUM(orders_produks.qty) as total_quantity'))
                            ->join('orders_produks', 'produks.id', '=', 'orders_produks.produk_id')
                            ->groupBy('produks.id', 'produks.category_id', 'produks.name', 'produks.price', 'produks.images', 'produks.slug', 'produks.category_id')
                            ->havingRaw('total_quantity >= 2')
                            ->orderByDesc('total_quantity')
                            ->take(10) // Ubah sesuai kebutuhan Anda
                            ->get();

        /*
        $topProduk = DB::table('produks')
                            ->join('orders_produks', 'produks.id', '=', 'orders_produks.produk_id')
                            ->select('produks.name as nama',
                                    'produks.images as gambar',
                                    'produks.price as harga',
                                    'produks.slug as slug',
                                    DB::raw('SUM(orders_produks.qty) as total_quantity'))
                            ->groupBy('produks.name', 'produks.images', 'produks.price', 'produks.slug', 'orders_produks.qty')
                            ->havingRaw('SUM(orders_produks.qty) >= ? ', [1])
                            ->orderByDesc('total_quantity')
                            ->limit(10)
                            ->get();
            */
    
        return view('admin.dashboard.index', compact('totalPendapatan', 'orderProduks', 'orderServices', 'topCustomers', 'topProduk'), [
            'visitors' => User::all(),
            'produk' => produk::all(),
            'produk' => produk::all(),
            'staff' => User::whereRoleIs('staff')->get(),
            'members' => User::whereRoleIs('customer')->get(),
            'orders' => Order::all(),
            'orderProduk' => order_produk::all(),
            'keluhan' => keluhan::all(),
            'testimoni' => testimoni::all(),
            'locations' => Location::all(),
            'services' => Service::all(),
        ]);
    }
}
