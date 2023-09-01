<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\cartsController;
use App\Http\Controllers\cardController;
use App\Http\Controllers\customersController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\produkController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\displayDiscountController;
use App\Http\Controllers\Admin\categoryProdukController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\pendapatanBookingController;
use App\Http\Controllers\pendapatanProdukController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\orderProdukController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\TimeController;
use App\Http\Controllers\testimoniController;
use App\Http\Controllers\profilesController;
use App\Http\Controllers\keluhanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\order_produk;
use App\Models\Order;
use App\Models\testimoni;
use App\Models\keluhan;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('carts', cartsController::class);
//Route::view('/', 'template.template');
Route::get('/testimoni', function () {
  $today = Carbon::today('Asia/Jakarta');
  $testimoni = order_produk::where('tanggal', $today)->where('customer', Auth::user()->id ?? '')->get();
  $testimonis = Order::where('tanggal', $today)->where('customer', Auth::user()->id ?? '')->get();
  return view('review.testimoni', compact('testimoni', 'testimonis'));
});

Route::get('/profile', function () {
  $testimoni = testimoni::where('nama_user', Auth::user()->name ?? '')->get();
  $keluhan = keluhan::where('nama', Auth::user()->name ?? '')->get();
  dd($testimoni);
  //return view('profile.index', compact('testimoni', 'keluhan'));
});

Route::get('/keluhans', function () {
  $keluhan = keluhan::where('nama', Auth::user()->first_name ?? '')->get();
  
  return view('profile.keluhan', compact('keluhan'));
});

Route::get('/keluhan', function () {
  $today = Carbon::today('Asia/Jakarta');
  $keluhan = order_produk::where('tanggal', $today)->where('customer', Auth::user()->id ?? '')->get();
  $keluhans = Order::where('tanggal', $today)->where('customer', Auth::user()->id ?? '')->get();
  return view('review.keluhan', compact('keluhan', 'keluhans'));
});

Auth::routes();

// Route::get('home', 'HomeController@index')->name('home');


Route::get('/password/email', function() {
  return redirect()->route('fronts');
});

Route::get('/password/reset', function() {
  return redirect()->route('fronts');
});

Route::patch('update-service', [FrontController::class, 'update']);
Route::get('/addCartt/{id}', [cartController::class, 'addCart'])->name('addCartt');
Auth::routes(['register' => true, 'reset' => true, 'verify' => true]);
Route::resource('carts', cartsController::class);
Route::resource('profiles', profilesController::class);

Route::group(['prefix' => '/', 'middleware' => ['auth']], function() {

  Route::middleware(['role:customer'])->group(function () {


    Route::get('/orderss', [FrontController::class, 'index'])->name('front');
    Route::get('/locationToService/{id}', [FrontController::class, 'locationToService'])->name('locationToService');
    
    Route::get('/add-to-cart/{id}', [FrontController::class, 'addToCart'])->name('addToCartSevice');
    Route::get('/cart', [FrontController::class, 'cart'])->name('cart');
    Route::get('/delete-service/{id}', [FrontController::class, 'deleteService'])->name('deleteServices');
    Route::patch('updateCarts', [FrontController::class, 'update']);


    //Review
    Route::resource('keluhanss', keluhanController::class);
    Route::resource('testimonis', testimoniController::class);
    
    //produk
   
    Route::post('/paymentProduk', [cartsController::class, 'addPayment'])->name('paymentProduk');
    Route::get('/detail-payments/{kode}', [cartsController::class, 'detail_payment'])->name('detail_payments');
    Route::put('/upload-buktis/{id}', [cartsController::class, 'uploadBukti'])->name('uploadBuktiOrder');

    Route::get('/tanggal', [FrontController::class, 'tanggal'])->name('tanggal');
    Route::post('/tanggal', [FrontController::class, 'addTanggal'])->name('addTanggal');
    
    Route::get('/staff', [FrontController::class, 'staff'])->name('staff');
    Route::post('/staff', [FrontController::class, 'addStaff'])->name('addStaff');
    
    Route::get('/customer', [FrontController::class, 'customer'])->name('customer');
    Route::post('/customer', [FrontController::class, 'addCustomer'])->name('addCustomer');
    
    Route::get('/detail', [FrontController::class, 'detail'])->name('detail');
    
    Route::post('/payment', [FrontController::class, 'addPayment'])->name('addPayment');
    Route::get('/detail-payment/{kode}', [FrontController::class, 'detail_payment'])->name('detail_payment');
    Route::put('/upload-bukti/{id}', [FrontController::class, 'uploadBukti'])->name('uploadBukti');
    
    Route::get('/antrian', [FrontController::class, 'antrian'])->name('antrian');
    Route::get('/search-code', [FrontController::class, 'search_code'])->name('search.code');
    
    Route::get('/unset-cart', [FrontController::class, 'unsetCart'])->name('unsetCart');
  
  });

  
      
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {

  Route::middleware(['role:superadmin|owner|staff'])->group(function () {

    

    //
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile/{id}', [ProfileController::class, 'update'])->name('profile.update');

    //Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    

    //staff
    Route::resource('order', OrderController::class);
    Route::resource('orderProduk', orderProdukController::class);

    //Route::get('order/show/{id}', [OrderController::class, 'show'])->name('order.show');

    //addCart
    Route::get('/add-to-cart/{id}', [FrontController::class, 'addToCart'])->name('addToCart');
    Route::get('/delete-service/{id}', [FrontController::class, 'deleteService'])->name('deleteService');

    //addCart Produk
    Route::get('/addCart/{id}', [cartController::class, 'addCart'])->name('addCart');
    Route::get('/deleteCart/{id}', [cartController::class, 'deleteCart'])->name('deleteCart');
    Route::patch('update-cart', [cartController::class, 'update']);
    
    Route::get('order/approve/{id}', [OrderController::class, 'approve'])->name('order.approve');
    Route::get('orderProduk/approve/{id}', [orderProdukController::class, 'approve'])->name('orderProduk.approve');
  
    Route::post('add-service', [OrderController::class, 'add_service'])->name('add_service');
    Route::delete('hapus-service/{id}', [OrderController::class, 'hapus_service'])->name('service.hapus');
    Route::put('update-service/{id}', [OrderController::class, 'update_service'])->name('update_service');

    Route::post('add-produk', [orderProdukController::class, 'add_produk'])->name('add_produk');
    Route::post('addProduks', [orderProdukController::class, 'addProduks'])->name('addProduks');
    Route::delete('deleteProduks/{id_produk}', [orderProdukController::class, 'deleteProduks'])->name('deleteProduks');
    Route::delete('hapus-produk/{id}', [orderProdukController::class, 'hapus_produk'])->name('produk.hapus');
    Route::put('update-produk/{id}', [orderProdukController::class, 'update_produk'])->name('update_produk');
  });

  Route::middleware(['role:superadmin|owner'])->group(function () {
  
    Route::resources([
      'location' => LocationController::class,
      'service' => ServiceController::class,
      'category' => CategoryController::class,
      'categoryProduk' => categoryProdukController::class,
      'produk' => produkController::class,
      'payment' => PaymentController::class,
      'staff' => StaffController::class,
      'time' => TimeController::class,
    ]);


    //display discount
    Route::resource('displayDiscount', displayDiscountController::class);

    //Laporan
    //pelayanan
    Route::post('laporan-pelayanan', [LaporanController::class, 'pelayanan'])->name('laporan.pelayanan');
    Route::resource('pendapatanBooking', pendapatanBookingController::class);
    Route::resource('pendapatanProduk', pendapatanProdukController::class);

    //laporan PDF
    Route::get('laporan/exportPDFPendapatanProduk', [pendapatanProdukController::class, 'exportPDF'])->name('laporan.exportPDFPendapatanProduk');
    Route::get('laporan/exportPDFPendapatanBooking', [pendapatanBookingController::class, 'exportPDF'])->name('laporan.exportPDFPendapatanBooking');
    Route::get('laporan/exportPDFTestimoni', [testimoniController::class, 'exportPDFTestimoni'])->name('laporan.exportPDFTestimoni');
    Route::get('laporan/exportPDFKeluhan', [keluhanController::class, 'exportPDFKeluhan'])->name('laporan.exportPDFKeluhan');
    Route::get('laporan/exportPDFCustomer', [customersController::class, 'exportPDFCustomer'])->name('laporan.exportPDFCustomer');
    Route::get('laporan/exportPDFOrderProduk', [orderProdukController::class, 'exportPDFOrderProduk'])->name('laporan.exportPDFOrderProduk');
    Route::get('laporan/exportPDFOrderBooking', [OrderController::class, 'exportPDFOrderBooking'])->name('laporan.exportPDFOrderBooking');






    //staff
    Route::post('laporan-staff', [LaporanController::class, 'staff'])->name('laporan.staff');

    //pelanggan
    Route::get('pelanggan', [PelangganController::class, 'index'])->name('pelanggan');
    Route::get('pelanggan/data/{id}', [PelangganController::class, 'show'])->name('pelanggans');
    Route::resource('customers', customersController::class);

    //Testimoni
    Route::get('admin/laporan/testimoni', [testimoniController::class, 'index'])->name('laporanTesti');
    Route::resource('testimonies', testimoniController::class);

    //keluhan
    Route::get('admin/laporan/keluhan', [keluhanController::class, 'index'])->name('laporanKeluhan');
    Route::resource('keluhans', keluhanController::class);
  
  });

  
      
});


//Route::get('register', 'Auth\RegisterController@index')->name('register');
//Route::post('register', 'Auth\RegisterController@register');
Route::resource('admin/user', UserController::class);
Route::get('/', [cardController::class, 'index', 'view'])->name('fronts');
Route::get('/produk', [cardController::class, 'index'])->name('front');
Route::get('/show/{id}', [cardController::class, 'show'])->name('showFront');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home', [HomeController::class, 'addOrder'])->name('add.order');
Route::get('/booking', [HomeController::class, 'checkBooking'])->name('check.booking');
Route::post('/booking', [HomeController::class, 'bookingCheck'])->name('booking.check');
Route::get('/booking/{kode}', [HomeController::class, 'booking'])->name('booking');
Route::put('/lunas/{id}', [HomeController::class, 'lunas'])->name('lunas');
