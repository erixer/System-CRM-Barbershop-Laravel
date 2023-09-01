<?php

namespace App\Http\Controllers;
use App\Models\produk;
use App\Models\User;
use App\Models\categoryProdukk;
use App\Models\Payment;
use App\Models\order_produk;
use App\Models\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use File;

class cartController extends Controller
{
    public function addCarts(Request $request){

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

    }
    
    
    
    /*
    public function addCart(Request $request, $id)
    {
       
        $service = produk::find($id);
        if(!$service) {
            abort(404);
        }

        $cart = session()->get('cart');

        // if cart is empty then this the first product
        if(!$cart) {
            $cart = [
                    $id => [
                        "name" => $service->name,
                        "quantity" => 1,
                        "price" => $service->price,
                        "duration" => $service->duration,
                        "time" => $service->time,
                    ]
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with(['success' => 'Service Successfully Added']);
        }

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            return redirect()->back()->with(['success' => 'Produk Successfully Added']);
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            'qty' => $request->qty,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->images
        ];
        session()->put('cart', $cart);
        return redirect()->back()->with(['success' => 'Produk Successfully Added']);
    }

    public function cart()
    {
        $cart = session()->get('cart');
        return view('cart', [
            'category' => categoryProduk::all(),
        ]);
    }
*/






    /*
    public function addCart(Request $request, $id)
    {

    $produk = produk::find($id);
    //VALIDASI DATA YANG DIKIRIM
    $this->validate($request, [
        'qty' => 'required|integer' //PASTIKAN QTY YANG DIKIRIM INTEGER
    ]);

    //AMBIL DATA CART DARI COOKIE, KARENA BENTUKNYA JSON MAKA KITA GUNAKAN JSON_DECODE UNTUK MENGUBAHNYA MENJADI ARRAY
    //$cart = json_decode($request->cookie('dw-carts'), true); 
    $cart = session()->get('carts');
    /*
    //CEK JIKA CARTS TIDAK NULL DAN PRODUCT_ID ADA DIDALAM ARRAY CARTS
    if ($carts && array_key_exists($request->produk_id, $carts)) {
        //MAKA UPDATE QTY-NYA BERDASARKAN PRODUCT_ID YANG DIJADIKAN KEY ARRAY
        $carts[$request->produk_id]['qty'] += $request->qty;
    }
*/
/*
    if(isset($cart[$id])) {
        $cart[$id]['qty']++;
        //$cookie = cookie('dw-carts', json_encode($cart), 2880);
        //STORE KE BROWSER UNTUK DISIMPAN
        //return redirect()->back()->cookie($cookie);
        session()->put('carts', $cart);
        return redirect()->back()->with(['success' => 'Produk Successfully Added']);
    }

    if(!$cart) {
        $cart[$id] = [
            'qty' => $request->qty,
            'name' => $produk->name,
            'price' => $produk->price,
            'images' => $produk->images
        ];
        session()->put('carts', $cart);
        return redirect()->back()->with(['success' => 'Produk Successfully Added']);
    }

    $cart[$id] = [
        "qty" => 1,
        "name" => $produk->name,
        "price" => $produk->price,
        'images' => $produk->images
    ];
    session()->put('carts', $cart);
    return redirect()->back()->with(['success' => 'Service Successfully Added']);
    
    //$cookie = cookie('dw-carts', json_encode($cart), 2880);
    //STORE KE BROWSER UNTUK DISIMPAN
    //return redirect()->back()->cookie($cookie)->with(['success' => 'Produk Successfully Added']);;
    


    


    //BUAT COOKIE-NYA DENGAN NAME DW-CARTS
    //JANGAN LUPA UNTUK DI-ENCODE KEMBALI, DAN LIMITNYA 2800 MENIT ATAU 48 JAM
    //$cookie = cookie('dw-carts', json_encode($carts), 2880);
    //STORE KE BROWSER UNTUK DISIMPAN
    //return redirect()->back()->cookie($cookie);
} */


public function listKeranjang(){
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


public function destroy($id_produk)
    {
        $user_id = Auth::user()->id;

        $cart = Cart::where('id_users', $user_id)
            ->where('id_produk', $id_produk)
            ->first();

        if ($cart) {
            $cart->delete();
            return redirect()->back()->with('success', 'Menu item deleted from cart successfully.');
        } else {
            return redirect()->back()->with('error', 'Menu item not found in cart.');
        }
    }


    public function deleteCartss($id)
    {
        $user_id = Auth::user()->id;

        $cart = cart::where('id', $id)->first();

        if ($cart) {
            $cart->delete();
            return redirect()->back()->with('success', 'Menu item deleted from cart successfully.');
        } else {
            return redirect()->back()->with('error', 'Menu item not found in cart.');
        }
    }

/*
public function listCart()
{
    //MENGAMBIL DATA DARI COOKIE
    //$cart = json_decode(request()->cookie('dw-carts'), true);
    $cart = session()->get('carts');
    //UBAH ARRAY MENJADI COLLECTION, KEMUDIAN GUNAKAN METHOD SUM UNTUK MENGHITUNG SUBTOTAL
    $subtotal = collect($cart)->sum(function($q) {
        return $q['qty'] * $q['price']; //SUBTOTAL TERDIRI DARI QTY * PRICE
    });
    //LOAD VIEW CART.BLADE.PHP DAN PASSING DATA CARTS DAN SUBTOTAL
    return view('cartProduk.cart', compact('cart', 'subtotal'));
}

*/
    public function deleteCart($id)
        {
            // dd($id);
            //$cart = json_decode(request()->cookie('dw-carts'), true);
            $cart = session()->get('carts');   
                if(isset($cart[$id])) {
                    cart::where('id_users', $request->users_id)->delete();
                }
                //$cookie = cookie('dw-carts', json_encode($cart), 2880);
                //DAN STORE KE BROWSER.
                //return redirect()->back()->cookie($cookie);
                session()->put('cart', $cart);
                return redirect()->back()->with(['success' => 'Produk Successfully Deleted']);
        }

    public function update(Request $request)
    {
        // dd($request->all());
        //$cart = json_decode(request()->cookie('dw-carts'), true);
        
        if($request->id and $request->qty)
        {
            $cart = session()->get('carts'); 
            $cart[$request->id]["qty"] = $request->qty;  
            //$cookie = cookie('dw-carts', json_encode($cart), 2880);
            //DAN STORE KE BROWSER.
            //return response('Jumlah produk berhasil diupdate')->withCookie($cookie);    
            session()->put('cart', $cart);
        }
    }

    //menampilkan detail pesanan
    public function detail()
    {
        //$cart = json_decode(request()->cookie('dw-carts'), true);
        $cart = session()->get('carts'); 
        if(!$cart) {
            return redirect()->route('listCart');
        }

        return view('cartProduk.detail', compact('cart'), [
            'payments' => Payment::all(),
        ]);
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
            'gross' => $totalHarga,
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
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        cart::where('id_users', $request->users_id)->delete();

        return redirect()->route('detail_payments', $kode);
    }

    public function detail_payment($kode)
    {
        $order = order_produk::where('code', $kode)->first();
        if(!$order) {
            return redirect()->route('/');
        }
        return view('cartProduk.detailPayment', [
            'order' => $order,
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

    public function unsetCart()
    {
        $this->_unsetCart();

        return redirect()->back();
    }


    private function _unsetCart()
    {
        $cart = session()->get('carts');

        unset($cart);

        session()->put('carts');
        
    }
}
