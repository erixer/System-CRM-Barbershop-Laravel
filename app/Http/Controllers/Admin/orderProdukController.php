<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order_produk;
use App\Models\Payment;
use App\Models\produk;
use App\Models\categoryProduk;
use App\Models\User;
use App\Models\cart;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class orderProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderProduk = order_produk::query();

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
            $orderProduk = $orderProduk->whereBetween('order_produks.tanggal', [$start_date, $end_date]);
        }

        $orderProduk = $orderProduk->get();

        $this->unsetCart();
        $orders = order_produk::orderBy('id', 'ASC')->get();
        
        return view('admin.orderProduk.index', compact('orderProduk', 'start_date', 'end_date'), [
            'orderProduk' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $cart = cart::leftJoin('users', 'carts.id_users', '=', 'users.id')
            ->leftJoin('produks', 'carts.id_produk', '=', 'produks.id')
            ->select('produks.name', 'carts.id_produk', 'produks.images', 'produks.price', DB::raw('COUNT(carts.qty) AS qty'), DB::raw('SUM(carts.qty * produks.price) AS total_harga'))
            ->where('id_users', Auth::user()->id)
            ->groupBy('produks.name', 'produks.images', 'produks.price', 'carts.id_produk')
            ->get();

        $totalHarga = DB::table('produks')
            ->leftJoin('carts', 'produks.id', '=', 'carts.id_produk')
            ->where('carts.id_users', Auth::user()->id)
            ->sum('produks.price');

        return view('admin.orderProduk.create', compact('cart', 'totalHarga'), [
            'payments' => Payment::all(),
            'categories' => categoryProduk::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $cart = cart::leftJoin('users', 'carts.id_users', '=', 'users.id')
            ->leftJoin('produks', 'carts.id_produk', '=', 'produks.id')
            ->select('produks.name', 'carts.id_produk', 'produks.images', 'produks.price', DB::raw('COUNT(carts.qty) AS qty'), DB::raw('SUM(carts.qty * produks.price) AS total_harga'))
            ->where('id_users', Auth::user()->id)
            ->groupBy('produks.name', 'produks.images', 'produks.price', 'carts.id_produk')
            ->get();

        $totalHarga = DB::table('produks')
            ->leftJoin('carts', 'produks.id', '=', 'carts.id_produk')
            ->where('carts.id_users', Auth::user()->id)
            ->sum('produks.price');

        $kode = 'KDBRG'.time();

        $order = order_produk::create([
            'code' => $kode,
            'customer' => $request->users_id,
            'payment_id' => $request->payment,
            'tanggal' => date('Y-m-d'),
            'net' => $request->harga,
            'gross' => $request->harga_discount,
            'discount' => $request->discount,
            'note' => $request->note,
            'alamat' => $request->address,
        ]);

        $customers = User::where('hp', $request->no_hp)->first();
        $discount = User::find($request->users_id);

        if($customers) {
            $customers->kunjungan += 1;
            $customers->save();
        }

        if ($discount) {
            $discount->point -= $request->discount;
            if ($discount->point < 0) {
                $discount->point = 0; // Prevent negative points
            }
            $discount->save();
        }
        
        if(!$request->harga_discount){
            foreach($cart as $item) {
                DB::table('orders_produks')->insert([
                    'order_id' => $order->id,
                    'produk_id' => $item->id_produk,
                    'qty' => $item->qty,
                    'total' => $request->harga,
                    'tanggal' => date('Y-m-d'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        
        else{
            foreach($cart as $item) {
                DB::table('orders_produks')->insert([
                    'order_id' => $order->id,
                    'produk_id' => $item->id_produk,
                    'qty' => $item->qty,
                    'total' => $request->harga_discount,
                    'tanggal' => date('Y-m-d'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        
        
        

        cart::where('id_users', Auth::user()->id)->delete();

        return redirect()->route('orderProduk.index')->with(['success' => 'Order Successfully Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.orderProduk.show', [
            'order' => order_produk::find($id),
            'produk' => produk::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = order_produk::find($id);

        if(!$order) {
            abort(404);
        }

        return view('admin.orderProduk.edit', [
            'order' => $order,
            'payments' => Payment::all(),
            'categories' => categoryProduk::all(),
        ]);
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
        $order = order_produk::find($id);

        
        if($order->client->email != $request->email) {
            $user = User::create([
                'location_id' => 1,
                'first_name' => $request->first,
                'last_name' => $request->last,
                'email' => $request->email,
                'hp' => $request->no,
                'address' => $request->address,
                'password' => bcrypt('user'),
            ]);

            $user->attachRole('customer');

            $order->customer = $user->id;
        }

        $order->payment_id = $request->payment;

        $order->save();

        return redirect()->route('orderProduk.index')->with(['success' => 'Order Successfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = order_produk::find($id);
        $order->delete();
        return redirect()->route('orderProduk.index')->with(['success' => 'Order Successfully Deleted']);
    }

    public function approve($id)
    {
        // dd($id);
        $order = order_produk::find($id);
        $order->lunas = 'Approved';
        $order->save();
        return redirect()->route('orderProduk.index')->with(['success' => 'Order Successfully Approved']);
    }

    public function add_produk(Request $request)
    {
        // dd($request->all());
        $order = order_produk::find($request->order_id);
        $produk = produk::find($request->produk);
        $order->produk()->attach($request->produk, ['qty' => $request->qty, 'total' => $request->qty * $produk->price]);
        // Auth::user()->subjects()->attach($id, ['grade'=>$request->ENGL101]);
        return redirect()->back()->with(['success' => 'Produk Successfully Added']);
    }

    public function update_produk(Request $request)
    {
        $produk = produk::find($request->produk);
        $total = $request->qty * $produk->price;
        DB::table('orders_produks')
        ->where('order_id', $request->order_id)
        ->where('produk_id', $request->produk_id)
        ->update([
            'qty' => $request->qty,
            'total' => $total
        ]);
        return redirect()->back()->with(['success' => 'Produk Successfully Updated']);
        /*
        $produk = produk::find($request->produk);
        DB::table('orders_produks')->where('order_id', $request->order_id)->where('produk_id', $request->produk)
        ->update(['qty' => $request->qty , 'total' => $request->qty * $produk->price]);
        // $order->service()->sync($request->service, ['qty' => $request->qty, 'total' => $request->qty * $service->price]);
        return redirect()->back()->with(['success' => 'Produk Successfully Updated']);*/
    }

    public function hapus_produk(Request $request, $id)
    {
        // dd($request->all());
        $order = order_produk::find($request->order);
        // $service = Service::find($id);
        $order->produk()->detach($id);
        return redirect()->back()->with(['success' => 'produk Successfully Deleted']);
    }


    public function addProduks(Request $request){
        $cart = new cart();
        $cart->id_users = Auth::user()->id;
        $cart->id_produk = $request->id_produk;
        $cart->qty = $request->qty;
        $cart->save();

        return redirect()->back()->with('succes', 'Berhasil di-tambahkan ke Keranjang');

    }


    public function deleteProduks($id_produk)
    {
        $id_user = Auth::user()->id;
        
        $cart = cart::where('id_users', $id_user)
            ->where('id_produk', $id_produk)
            ->first();

        if ($cart) {
            $cart->delete();
            return redirect()->back();
        } else {
            return redirect()->back()->with('error', 'Menu item not found in cart.');
        }
    }

    public function exportPDFOrderProduk(Request $request)
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
        $pdf = PDF::loadView('admin.laporan.PDFOrderProduk', compact('start_date', 'end_date', 'order_produk', 'order'));
        return $pdf->download('laporan Order Produk.pdf');
    }
}
