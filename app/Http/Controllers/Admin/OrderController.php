<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Location;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Service;
use App\Models\Time;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;


class OrderController extends Controller
{
    public function __construct()
    {
        // $this->unsetCart();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $orders = Order::query();

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
            $orders = $orders->whereBetween('orders.tanggal', [$start_date, $end_date]);
        }

        $orders = $orders->get();

        $this->unsetCart();
        $orderss = Order::orderBy('date', 'ASC')->get();
        
        return view('admin.order.index', compact('orders', 'start_date', 'end_date'), [
            'orderss' => $orderss,
        ]);


        $this->unsetCart();

        

        if(Auth::user()->hasRole('staff')) {
            $orders = Order::orderBy('date', 'ASC')->where('staff', Auth::user()->id)->get();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(session('cart'));
        return view('admin.order.create', [
            'staffs' => User::whereRoleIs('staff')->get(),
            'locations' => Location::all(),
            'payments' => Payment::all(),
            'categories' => Category::all(),
            'times' => Time::orderBy('jam','asc')->get(),
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
        $cart = session()->get('cart');

        $total = 0;
        $total_duration = 0;
        foreach($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
            $total_duration += $details['duration'] * $details['quantity'];
        }

        $kode = 'KODE'.time();

        $order = Order::create([
            'code' => $kode,
            'customer' => $request->users_id,
            'staff' => $request->staff,
            'location_id' => $request->location,
            'payment_id' => $request->payment,
            'tanggal' => date('Y-m-d'),
            'date' => $request->date,
            'time_id' => $request->time,
            'net' => $total,
            'gross' => $request->harga_discount,
            'discount' => $request->discount,
            'total_duration' => $total_duration,
            'note' => $request->note,
            'lunas' => 'Approved',
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

        

        if(!$request->harga_discount){
            foreach($cart as $id => $details) {
                DB::table('order_service')->insert([
                    'order_id' => $order->id,
                    'service_id' => $id,
                    'qty' => $details['quantity'],
                    'total' => $total,
                    'tanggal' => date('Y-m-d'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        
        else{
            foreach($cart as $id => $details) {
                DB::table('order_service')->insert([
                    'order_id' => $order->id,
                    'service_id' => $id,
                    'qty' => $details['quantity'],
                    'total' => $request->harga_discount,
                    'tanggal' => date('Y-m-d'),
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
            }

        $this->unsetCart();

        return redirect()->route('order.index')->with(['success' => 'Order Successfully Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.order.show', [
            'order' => Order::find($id),
            'services' => Service::all(),
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
        // $cart = session()->get('cart');

        $order = Order::find($id);

        if(!$order) {
            abort(404);
        }

        //query bulider ambil qty
        
        // dd($order_service->total);
        
        // foreach ($order->service as $service) {
        //     $order_service = DB::table('order_service')->where('order_id', $id)->where('service_id', $service->id)->first();
            
        //     $cart[$service->id] = [
        //         'name' => $service->name,
        //         'quantity' => $order_service->qty,
        //         'price' => $service->price,
        //         'duration' => $service->duration,
        //         'time' => $service->time,
        //     ];
        //     session()->put('cart', $cart);
        // }

        // dd(session('cart'));  

        return view('admin.order.edit', [
            'order' => $order,
            'staffs' => User::whereRoleIs('staff')->get(),
            'locations' => Location::all(),
            'payments' => Payment::all(),
            'categories' => Category::all(),
            'times' => Time::orderBy('jam','asc')->get(),
            'tanggal' => new \DateTime($order->date),
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
        $order = Order::find($id);

        
        if($request->date != null) {
            $order->date = $request->date;
        }

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

        $order->staff = $request->staff;
        $order->location_id = $request->location;
        $order->payment_id = $request->payment;
        $order->time_id = $request->time;
        $order->note = $request->note;

        $order->save();

        return redirect()->route('order.index')->with(['success' => 'Order Successfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('order.index')->with(['success' => 'Order Successfully Deleted']);
    }

    public function approve($id)
    {
        // dd($id);
        $order = Order::find($id);
        $order->lunas = 'Approved';
        $order->save();
        return redirect()->route('order.index')->with(['success' => 'Order Successfully Approved']);
    }

    public function add_service(Request $request)
    {
        // dd($request->all());
        $order = Order::find($request->order_id);
        $service = Service::find($request->service);
        $order->service()->attach($request->service, ['qty' => $request->qty, 'total' => $request->qty * $service->price]);
        // Auth::user()->subjects()->attach($id, ['grade'=>$request->ENGL101]);
        return redirect()->back()->with(['success' => 'Service Successfully Added']);
    }

    public function update_service(Request $request)
    {
        $service = Service::find($request->service);
        DB::table('order_service')->where('order_id', $request->order_id)->where('service_id', $request->service)
        ->update(['qty' => $request->qty , 'total' => $request->qty * $service->price]);
        // $order->service()->sync($request->service, ['qty' => $request->qty, 'total' => $request->qty * $service->price]);
        return redirect()->back()->with(['success' => 'Service Successfully Updated']);
    }

    public function hapus_service(Request $request, $id)
    {
        // dd($request->all());
        $order = Order::find($request->order);
        // $service = Service::find($id);
        $order->service()->detach($id);
        return redirect()->back()->with(['success' => 'Service Successfully Deleted']);
    }


    public function exportPDFOrderBooking(Request $request)
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
        $pdf = PDF::loadView('admin.laporan.PDFOrderService', compact('start_date', 'end_date', 'order_service', 'order'));
        return $pdf->download('laporan Order Booking.pdf');
    }
}
