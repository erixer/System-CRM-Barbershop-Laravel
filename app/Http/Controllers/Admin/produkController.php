<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\produk;
use App\Models\categoryProduk;

use Illuminate\Support\Facades\DB;
class produkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //$produk = DB::table('category_produks')
               //  ->join('produks', 'category_produks.id', '=', 'produks.category_id')->get();
        //dd($produk);
        return view('admin.produk.index', [
            'produk' => produk::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.produk.create', [
            'categoryProduk' => categoryProduk::all(),
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
    
        $produk = new produk;
        $produk->category_id = $request->category;
        $produk->slug = $request->slug;
        $produk->name = $request->name;
        $produk->price = $request->price;
        $produk->desc = $request->desc;
        $produk->images = $request->filefoto;
        
        if($request->file('filefoto'))
        {
            $file = $request->file('filefoto');
            $filefoto = time()."".$file->getClientOriginalName();
            $file_ext  = $file->getClientOriginalExtension();
            
            $local_gambar = "img/produk/".$produk->images;
            

            $tujuan_upload = 'img/produk/';
            $file->move($tujuan_upload,$filefoto);
            $produk->images = $filefoto;
        }

        $produk->save();

        

        return redirect()->route('produk.index')->with(['success' => 'produk Successfully Created']);
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
        return view('admin.produk.edit', [
            'produk' => produk::find($id),
            'categoryProduk' => categoryProduk::all(),
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
        $produk = produk::find($id);
        $produk->category_id = $request->category;
        $produk->slug = $request->slug;
        $produk->name = $request->name;
        $produk->price = $request->price;
        $produk->desc = $request->desc;
        $produk->images = $request->image;
        if($request->file('filefoto'))
        {
            $file = $request->file('filefoto');
            $filefoto = time()."".$file->getClientOriginalName();
            $file_ext  = $file->getClientOriginalExtension();
            
            $local_gambar = "img/produk/".$produk->images;
            

            $tujuan_upload = 'img/produk/';
            $file->move($tujuan_upload,$filefoto);
            $produk->images = $filefoto;
        }
        $produk->save();

        return redirect()->route('produk.index')->with(['success' => 'produk Successfully Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = produk::find($id);
        $produk->delete();
        return redirect()->route('produk.index')->with(['success' => 'produk Successfully Deleted']);
    }
}
