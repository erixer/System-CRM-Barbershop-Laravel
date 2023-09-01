<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produk;
use App\Models\User;
use App\Models\categoryProdukk;
use App\Models\Payment;
use App\Models\order_produk;
use App\Models\cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use File;

class cartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        return view('cartProduk.cart', compact('cart', 'totalHarga'));
    
        
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

        if(!$cart) {
            return redirect()->route('listCart');
        }

        return view('cartProduk.detail', compact('cart', 'totalHarga'),
                    [
                        'payments' => Payment::all()
                    ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = new cart();
        $cart->id_users = Auth::user()->id;
        $cart->id_produk = $request->id_produk;
        $cart->qty = $request->qty;
        $cart->save();

        return redirect()->back()->with('succes', 'Berhasil di-tambahkan ke Keranjang');

        /*
        $id_user = Auth::user()->id;
        $id_produk = $request->id_produk;
        $qty = $request->qty;
        
        //memeriksa apakah dalam keranjang ada item
        $cartItem = cart::where('id_users', $id_user)->where('id_produk', $id_produk)->first();
        if ($cartItem) {
            // Jika item sudah ada, tambahkan quantity-nya
            $cartItem->update([
                'qty' => $cartItem->qty + $qty,
            ]);
        } else {
            // Jika item belum ada, tambahkan sebagai item baru ke keranjang
            cart::create([
                'id_users' => $id_user,
                'id_produk' => $id_produk,
                'qty' => $qty,
            ]);
        }

        return redirect()->back()->with(['success' => 'Produk Successfully Added']);
        */
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

    public function delete($id){
        
    }

    public function destroy($id_produk)
    {
        $id_user = Auth::user()->id;
        
        $cart = cart::where('id_users', $id_user)
            ->where('id_produk', $id_produk)
            ->first();

        if ($cart) {
            $cart->delete();
            return redirect()->back()->with('success', 'Menu item deleted from cart successfully.');
        } else {
            return redirect()->back()->with('error', 'Menu item not found in cart.');
        }
    }

    public function addPayment(Request $request)
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
            'customer' => Auth::user()->id,
            'payment_id' => $request->payment,
            'tanggal' => date('Y-m-d'),
            'net' => $totalHarga,
            'note' => $request->note,
            'alamat' => $request->alamat,
            //'images' => $cart['images'],
        ]);
        
            $customer = User::where('hp', $request->no_hp)->first();
            $discount = User::find($request->users_id);

            if($customer) {
                $customer->kunjungan += 1;
                $customer->save();
            }

            if ($discount) {
                $discount->point -= $request->discount;
                if ($discount->point < 0) {
                    $discount->point = 0; // Prevent negative points
                }
                $discount->save();
            }

        foreach($cart as $item) {
            DB::table('orders_produks')->insert([
                'order_id' => $order->id,
                'produk_id' => $item->id_produk,
                'qty' => $item->qty,
                'total' => $totalHarga,
                'tanggal' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        cart::where('id_users', $request->users_id)->delete();

        return redirect()->route('detail_payments', $kode);
    }

    public function detail_payment($kode)
    {
        $orders = order_produk::where('code', $kode)->first();
        if(!$orders) {
            return redirect()->route('/');
        }
        return view('cartProduk.detailPayment', [
            'orders' => $orders,
            'wa' => User::find(1),
        ]);
    }



    public function uploadBukti(Request $request, $id)
    {
        // dd($request->all());
        $order = order_produk::find($id);

        if($request->hasFile('filefoto') == true)
        {
            $file = $request->file('filefoto');
            $filefoto = time()."".$file->getClientOriginalName();
            $file_ext  = $file->getClientOriginalExtension();
            
            $local_gambar = "img/bukti_transfer/".$order->images;
            if(File::exists($local_gambar))
            {
                File::delete($local_gambar);
            }

            $tujuan_upload = 'img/bukti_transfer/';
            $file->move($tujuan_upload,$filefoto);
            $order->images = $filefoto;
        }

        if($order->lunas == 'Approved') {
            $order->lunas = 'Approved';
        } else {
            $order->lunas = 'Payment';
        }

        $order->save();

        return redirect()->back();
    }





}
