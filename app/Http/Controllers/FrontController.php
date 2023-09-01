<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Category;
use App\Models\User;
use App\Models\Service;
use App\Models\Payment;
use App\Models\Order;
use App\Models\order_produk;
use App\Models\Time;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use File;
use Carbon\Carbon;


class FrontController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $order = Order::find(1);
        // if($order->date->addHour(5) < now()) {
        //     return "hapus " . $order->date . " " . $order->date->addHour(5) . " " . now();
        // } else {
        //     return "masih " . $order->date . " " . $order->date->addHour(5) . " " . now();
        // }
        // echo now()->format('d F Y H:i');
        // echo "<br>";
        // echo now();
        // echo "<br>";
        // echo now()->addHour(5);
        // echo "<br>";
        // echo now()->addMinutes(5);
        // die();

        // $jam9    = Carbon::createFromTime(9, 00, 00, 'Asia/Jakarta');

        // echo $jam9->addMinutes(30); die();

        return view('front',[
            'locations' => Location::all(),
        ]);
    }

    public function locationToService($id)
    
    {
        $location = Location::find($id);
        if(!$location) {
            abort(404);
        }

        $cart_location = session()->get('cart_location');

        //jika tidak ada cart maka tambahkan
        if(!$cart_location) {
            $cart_location = [
                    "lokasi" => [
                        "id" => $location->id,
                        "name" => $location->name,
                    ]
            ];
            session()->put('cart_location', $cart_location);
        } else {
            // jika ada cart
            $cart_location = session()->get('cart_location');

            unset($cart_location);
            session()->put('cart_location');

            $cart_location = [
                "lokasi" => [
                    "id" => $location->id,
                    "name" => $location->name,
                ]
            ];
            session()->put('cart_location', $cart_location);
        }

        // $cart_location = session()->get('cart_location');

        //     unset($cart_location);
        //     session()->put('cart_location');

        return view('service', [
            'categories' => Category::all(),
        ]);
    }

    public function addToCart($id)
    {
        //sumber cart
        // https://webmobtuts.com/backend-development/creating-a-shopping-cart-with-laravel/

        // $cart = session()->get('cart');

        // unset($cart);
        // session()->put('cart');
        // dd(session('cart'));
        $service = Service::find($id);
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
            return redirect()->back()->with(['success' => 'Service Successfully Added']);
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $service->name,
            "quantity" => 1,
            "price" => $service->price,
            "duration" => $service->duration,
            "time" => $service->time,
        ];
        session()->put('cart', $cart);
        return redirect()->back()->with(['success' => 'Service Successfully Added']);
    }

    public function cart()
    {
        $cart = session()->get('cart');
        $cart_location = session()->get('cart_location');
        if(!$cart) {
            if(!$cart_location) {
                return redirect()->route('front');
            }
            return redirect()->route('locationToService', $cart_location['lokasi']['id']);
        }
        return view('cart', [
            'categories' => Category::all(),
        ]);
    }

    public function deleteService($id)
    {
        // dd($id);
        $cart = session()->get('cart');
            if(isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
            return redirect()->back();
    }

    public function update(Request $request)
    {
        // dd($request->all());
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
        }
    }

    public function tanggal()
    {
        $cart = session()->get('cart');
        $cart_location = session()->get('cart_location');

        if(!$cart) {
            if(!$cart_location) {
                return redirect()->route('front');
            }
            return redirect()->route('locationToService', $cart_location['lokasi']['id']);
        }

        return view('tanggal');
    }

    public function addTanggal(Request $request)
    {
        $cart_tanggal = session()->get('cart_tanggal');

        //jika tidak ada cart maka tambahkan
        if(!$cart_tanggal) {
            $cart_tanggal = [
                    'tanggal1' => new \DateTime($request->date),
                    'tanggal2' => $request->date,
            ];
            session()->put('cart_tanggal', $cart_tanggal);
        } else {
            // jika ada cart
            $cart_tanggal = session()->get('cart_tanggal');

            unset($cart_tanggal);
            session()->put('cart_tanggal');

            $cart_tanggal = [
                'tanggal1' => new \DateTime($request->date),
                'tanggal2' => $request->date,
            ];
            session()->put('cart_tanggal', $cart_tanggal);
        }

        return redirect()->route('staff');
    }

    public function staff()
    {
        $cart = session()->get('cart');
        $cart_location = session()->get('cart_location');
        $cart_tanggal = session()->get('cart_tanggal');
        // $cart_staff = session()->get('cart_staff');
        // dd($cart_staff['date_time']);
        // return $cart_location['lokasi']['id'];
        // $staf = User::whereRoleIs('staff')->where('location_id', $cart_location['lokasi']['id'])->get();
        // return $staf;
        if(!$cart) {
            if(!$cart_location) {
                return redirect()->route('front');
            }
            return redirect()->route('locationToService', $cart_location['lokasi']['id']);
        }

        return view('staff', [
            'staffs' => User::whereRoleIs('staff')->where('location_id', $cart_location['lokasi']['id'])->get(),
            'times' => Time::orderBy('jam','asc')->get(),
            'antrian' => Order::where('date', $cart_tanggal['tanggal2'])->where('lunas', '!=', 'Approved')->orderBy('time_id', 'ASC')->get(),
            'order' => Order::where('lunas', '!=', 'Approved')->orderBy('date', 'ASC')->orderBy('time_id', 'ASC')->get(),
        ]);
    }

    public function addStaff(Request $request)
    {
        //definisi jam
        $jam9    = Carbon::createFromTime(9, 00, 00, 'Asia/Jakarta');
        $jam9_30 = Carbon::createFromTime(9, 30, 00, 'Asia/Jakarta');
        $jam10    = Carbon::createFromTime(10, 00, 00, 'Asia/Jakarta');
        $jam10_30 = Carbon::createFromTime(10, 30, 00, 'Asia/Jakarta');
        $jam11    = Carbon::createFromTime(11, 00, 00, 'Asia/Jakarta');
        $jam11_30 = Carbon::createFromTime(11, 30, 00, 'Asia/Jakarta');
        $jam12    = Carbon::createFromTime(12, 00, 00, 'Asia/Jakarta');
        $jam12_30 = Carbon::createFromTime(12, 30, 00, 'Asia/Jakarta');
        $jam13    = Carbon::createFromTime(13, 00, 00, 'Asia/Jakarta');
        $jam13_30 = Carbon::createFromTime(13, 30, 00, 'Asia/Jakarta');
        $jam14    = Carbon::createFromTime(14, 00, 00, 'Asia/Jakarta');
        $jam14_30 = Carbon::createFromTime(14, 30, 00, 'Asia/Jakarta');
        $jam15    = Carbon::createFromTime(15, 00, 00, 'Asia/Jakarta');
        $jam15_30 = Carbon::createFromTime(15, 30, 00, 'Asia/Jakarta');
        $jam16    = Carbon::createFromTime(16, 00, 00, 'Asia/Jakarta');
        $jam16_30 = Carbon::createFromTime(16, 30, 00, 'Asia/Jakarta');
        $jam17    = Carbon::createFromTime(17, 00, 00, 'Asia/Jakarta');
        $jam17_30 = Carbon::createFromTime(17, 30, 00, 'Asia/Jakarta');
        $jam18    = Carbon::createFromTime(18, 00, 00, 'Asia/Jakarta');
        $jam18_30 = Carbon::createFromTime(18, 30, 00, 'Asia/Jakarta');
        $jam19    = Carbon::createFromTime(19, 00, 00, 'Asia/Jakarta');
        $jam19_30 = Carbon::createFromTime(19, 30, 00, 'Asia/Jakarta');
        $jam20    = Carbon::createFromTime(20, 00, 00, 'Asia/Jakarta');
        $jam20_30 = Carbon::createFromTime(20, 30, 00, 'Asia/Jakarta');
        $jam21    = Carbon::createFromTime(21, 00, 00, 'Asia/Jakarta');

        // addMinutes(30)

        $sekarang = Carbon::now();

        if(date('Y-m-d') == $request->date) {
            switch ($request->time) {
                case 1:
                    if($jam9 < $sekarang || $jam9 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 2:
                    if($jam9_30 < $sekarang || $jam9_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 3:
                    if($jam10 < $sekarang || $jam10 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 4:
                    if($jam10_30 < $sekarang || $jam10_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 5:
                    if($jam11 < $sekarang || $jam11 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 6:
                    if($jam11_30 < $sekarang || $jam11_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 7:
                    if($jam12 < $sekarang || $jam12 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 8:
                    if($jam12_30 < $sekarang || $jam12_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 9:
                    if($jam13 < $sekarang || $jam13 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 10:
                    if($jam13_30 < $sekarang || $jam13_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 11:
                    if($jam14 < $sekarang || $jam14 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 12:
                    if($jam14_30 < $sekarang || $jam14_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 13:
                    if($jam15 < $sekarang || $jam15 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 14:
                    if($jam15_30 < $sekarang || $jam15_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 15:
                    if($jam16 < $sekarang || $jam16 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 16:
                    if($jam16_30 < $sekarang || $jam16_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 17:
                    if($jam17 < $sekarang || $jam17 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 18:
                    if($jam17_30 < $sekarang || $jam17_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 19:
                    if($jam18 < $sekarang || $jam18 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 20:
                    if($jam18_30 < $sekarang || $jam18_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 21:
                    if($jam19 < $sekarang || $jam19 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 22:
                    if($jam19_30 < $sekarang || $jam19_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 23:
                    if($jam20 < $sekarang || $jam20 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 24:
                    if($jam20_30 < $sekarang || $jam20_30 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
                case 25:
                    if($jam21 < $sekarang || $jam21 < $sekarang->addMinutes(30) ) {
                        return redirect()->back()->with(['warning' => 'Silahkan Pilih waktu yang lain']);
                    }
                    break;
            }
        }

        // return "bisa";
        

        // if($jam_delapan_malam > $sekarang && $jam_delapan_malam > $sekarang->addHours(1) ) {
        //     return "bisa";
        // } else {
        //     return "ga bisa";
        // }


        // get the current time
        // $current = Carbon::now();
        // $sekarang = Carbon::now();

        // add 30 days to the current time
        // $trialExpires = $current->addHours(5);

        // echo $sekarang ."=". $trialExpires; die();

        // if(date('Y-m-d') == $request->date) {
        //     return "sama";
        // } else {
        //     return "ga sama";
        // }

        $waktu;
        $waktu_pemesan;
        $orders = Order::where('lunas', '!=', 'Approved')->get();
        if($request->date) {

            foreach($orders as $order) {
                $cek_date = new \DateTime($request->date);

                //definisi jam telah order
                switch ($order->time_id) {
                  case 1:
                    $waktu = $jam9;
                      break;
                  case 2:
                    $waktu = $jam9_30;
                      break;
                  case 3:
                    $waktu = $jam10;
                      break;
                  case 4:
                    $waktu = $jam10_30;
                      break;
                  case 5:
                    $waktu = $jam11;
                      break;
                  case 6:
                    $waktu = $jam11_30;
                      break;
                  case 7:
                    $waktu = $jam12;
                      break;
                  case 8:
                    $waktu = $jam12_30;
                      break;
                  case 9:
                    $waktu = $jam13;
                      break;
                  case 10:
                    $waktu = $jam13_30;
                      break;
                  case 11:
                    $waktu = $jam14;
                      break;
                  case 12:
                    $waktu = $jam14_30;
                      break;
                  case 13:
                    $waktu = $jam15;
                      break;
                  case 14:
                    $waktu = $jam15_30;
                      break;
                  case 15:
                    $waktu = $jam16;
                      break;
                  case 16:
                    $waktu = $jam16_30;
                      break;
                  case 17:
                    $waktu = $jam17;
                      break;
                  case 18:
                    $waktu = $jam17_30;
                      break;
                  case 19:
                    $waktu = $jam18;
                      break;
                  case 20:
                    $waktu = $jam18_30;
                      break;
                  case 21:
                    $waktu = $jam19;
                      break;
                  case 22:
                    $waktu = $jam19_30;
                      break;
                  case 23:
                    $waktu = $jam20;
                      break;
                  case 24:
                    $waktu = $jam20_30;
                      break;
                  case 25:
                    $waktu = $jam21;
                      break;
                }

                //definisi jam request
                switch ($request->time) {
                  case 1:
                    $waktu_pemesan = $jam9;
                      break;
                  case 2:
                    $waktu_pemesan = $jam9_30;
                      break;
                  case 3:
                    $waktu_pemesan = $jam10;
                      break;
                  case 4:
                    $waktu_pemesan = $jam10_30;
                      break;
                  case 5:
                    $waktu_pemesan = $jam11;
                      break;
                  case 6:
                    $waktu_pemesan = $jam11_30;
                      break;
                  case 7:
                    $waktu_pemesan = $jam12;
                      break;
                  case 8:
                    $waktu_pemesan = $jam12_30;
                      break;
                  case 9:
                    $waktu_pemesan = $jam13;
                      break;
                  case 10:
                    $waktu_pemesan = $jam13_30;
                      break;
                  case 11:
                    $waktu_pemesan = $jam14;
                      break;
                  case 12:
                    $waktu_pemesan = $jam14_30;
                      break;
                  case 13:
                    $waktu_pemesan = $jam15;
                      break;
                  case 14:
                    $waktu_pemesan = $jam15_30;
                      break;
                  case 15:
                    $waktu_pemesan = $jam16;
                      break;
                  case 16:
                    $waktu_pemesan = $jam16_30;
                      break;
                  case 17:
                    $waktu_pemesan = $jam17;
                      break;
                  case 18:
                    $waktu_pemesan = $jam17_30;
                      break;
                  case 19:
                    $waktu_pemesan = $jam18;
                      break;
                  case 20:
                    $waktu_pemesan = $jam18_30;
                      break;
                  case 21:
                    $waktu_pemesan = $jam19;
                      break;
                  case 22:
                    $waktu_pemesan = $jam19_30;
                      break;
                  case 23:
                    $waktu_pemesan = $jam20;
                      break;
                  case 24:
                    $waktu_pemesan = $jam20_30;
                      break;
                  case 25:
                    $waktu_pemesan = $jam21;
                      break;
                }

                if($cek_date == $order->date && $request->staff == $order->staff && $waktu_pemesan >= $waktu && $waktu_pemesan <= $waktu->addMinutes($order->total_duration)) {
                    // dd($request->date);
                    return redirect()->back()->with(['warning' => 'Mohon Maaf! staff dan waktu yang anda pilih telah dibooking orang lain, silahkan pilih staff / waktu yang berbeda.']);
                }
            }
        }
        // $tanggal = new \DateTime($request->date);
        // echo $tanggal->format('Y-m-d');
        $namaStaff = User::find($request->staff);
        $time_id = Time::find($request->time);
        $jam = $time_id->jam;
        // dd($namaStaff);
        $cart_staff = session()->get('cart_staff');

        //jika tidak ada cart maka tambahkan
        if(!$cart_staff) {
            $cart_staff = [
                    'staf_id' => $request->staff,
                    'name' => $namaStaff->first_name,
                    'date_time' => new \DateTime($request->date),
                    'date' => $request->date,
                    'time' => $request->time,
                    'jam' => $jam,
            ];
            session()->put('cart_staff', $cart_staff);
        } else {
            // jika ada cart
            $cart_staff = session()->get('cart_staff');

            unset($cart_staff);
            session()->put('cart_staff');

            $cart_staff = [
                'staf_id' => $request->staff,
                'name' => $namaStaff->first_name,
                'date_time' => new \DateTime($request->date),
                'date' => $request->date,
                'time' => $request->time,
                'jam' => $jam,
            ];
            session()->put('cart_staff', $cart_staff);
        }

        return redirect()->route('detail');

        // dd(session('cart_staff'));
    }
/*
    public function customer()
    {
        $cart = session()->get('cart');
        $cart_location = session()->get('cart_location');
        if(!$cart) {
            if(!$cart_location) {
                return redirect()->route('front');
            }
            return redirect()->route('locationToService', $cart_location['lokasi']['id']);
        }

        return view('customer');
    }

    public function addCustomer(Request $request)
    {
        $cart_customer = session()->get('cart_customer');

        //jika tidak ada cart maka tambahkan
        if(!$cart_customer) {
            $cart_customer = [
                    'first' => $request->first,
                    'last' => $request->last,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'note' => $request->note,
            ];
            session()->put('cart_customer', $cart_customer);
        } else {
            // jika ada cart
            $cart_customer = session()->get('cart_customer');

            unset($cart_customer);
            session()->put('cart_customer');

            $cart_customer = [
                'first' => $request->first,
                    'last' => $request->last,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'note' => $request->note,
            ];
            session()->put('cart_customer', $cart_customer);
        }

        return redirect()->route('detail');
        // dd(session('cart_customer'));
    }
*/
    public function detail()
    {
        $cart = session()->get('cart');
        $cart_location = session()->get('cart_location');
        if(!$cart) {
            if(!$cart_location) {
                return redirect()->route('front');
            }
            return redirect()->route('locationToService', $cart_location['lokasi']['id']);
        }
        
        return view('detail', [
            'payments' => Payment::all(),
        ]);
    }

    public function addPayment(Request $request)
    {
        $cart_staff = session()->get('cart_staff');
        //$cart_customer = session()->get('cart_customer');
        $cart_location = session()->get('cart_location');
        $cart = session()->get('cart');

        $total = 0;
        $total_duration = 0;
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
            $total_duration += $details['duration'] * $details['quantity'];
        }

        // dd($cart);

        //$customer = User::where('email', $cart_customer['email'])->first();
/*
        if($customer) {
            //jika customer sudah pesan dan belum bayar
            $order_customer = Order::where('customer', $customer->id)->first();
            if($order_customer && $order_customer->lunas == 'Order') {
                $order_customer->delete();
            }
        }

        //jika customer ada
        if($customer) {
            $customer->order++;
            $user_id = $customer->id;
            $customer->save();                  
        }else {
            $user = User::create([
                'location_id' => 1,
                'first_name' => $cart_customer['first'],
                'last_name' => $cart_customer['last'],
                'email' => $cart_customer['email'],
                'hp' => $cart_customer['phone'],
                'address' => $cart_customer['address'],
                'password' => bcrypt('password'),
            ]);

            $user->attachRole('customer');

            $user_id = $user->id;
        }
*/
        $kode = 'KODE'.time();

        $order = Order::create([
            'code' => $kode,
            'customer' => Auth::user()->id,
            'tanggal' => date('Y-m-d'),
            'staff' => $cart_staff['staf_id'],
            'location_id' => $cart_location['lokasi']['id'],
            'payment_id' => $request->payment,
            'date' => $cart_staff['date_time'],
            'time_id' => $cart_staff['time'],
            'net' => $total,
            'total_duration' => $total_duration,
            'note' => $request->note,
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

        foreach($cart as $id => $details) {
            DB::table('order_service')->insert([
                'order_id' => $order->id,
                'service_id' => $id,
                'qty' => $details['quantity'],
                'total' => $details['quantity'] * $details['price'],
                'tanggal' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $this->_unsetCart();

        return redirect()->route('detail_payment', $kode);
    }
    
    public function detail_payment($kode)
    {
        $order = Order::where('code', $kode)->first();
        if(!$order) {
            return redirect()->route('front');
        }
        return view('detail_payment', [
            'order' => $order,
            'wa' => User::find(1),
        ]);
    }

    public function uploadBukti(Request $request, $id)
    {
        // dd($request->all());
        $order = Order::find($id);

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

    public function antrian()
    {
        return view('antrian', [
            'order' => Order::where('lunas', '!=', 'Approved')->orderBy('date', 'ASC')->orderBy('time_id', 'ASC')->get(),
        ]);
    }

    public function search_code()
    {
        $search = false;
        if(request('search')) {
            $order = Order::where('code', request('search'))->first();
            $orders = order_produk::where('code', request('search'))->first();
            if($order) {
                return view('detail_payment', [
                    'order' => $order,
                    'wa' => User::find(1),
                ]);
            }
            if($orders) {
                return view('cartProduk.detailPayment', [
                    'orders' => $orders,
                    'wa' => User::find(1),
                ]);
            }
            $search = true;
        }
        
        return view('search_code', [
            'search' => $search,
        ]);
    }

    private function _unsetCart()
    {
        $cart = session()->get('cart');
        $cart_location = session()->get('cart_location');
        $cart_staff = session()->get('cart_staff');
        $cart_customer = session()->get('cart_customer');
        $cart_tanggal = session()->get('cart_tanggal');

        unset($cart);
        unset($cart_location);
        unset($cart_staff);
        unset($cart_customer);
        unset($cart_tanggal);

        session()->put('cart');
        session()->put('cart_location');
        session()->put('cart_staff');
        session()->put('cart_customer');
        session()->put('cart_tanggal');
    }
}
