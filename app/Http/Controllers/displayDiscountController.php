<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\display_discount;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class displayDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.display_discount.index', [
            'display_discount' => display_discount::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.display_discount.create', [
            'display_discoount' => display_discount::all(),
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
        $display_discount = new display_discount;
        $display_discount->excerpt = $request->excerpt;
        $display_discount->name = $request->name;
        $display_discount->tanggal = date('Y-m-d');
        $display_discount->periode = $request->periode;
        $display_discount->desc = $request->desc;
        $display_discount->images = $request->filefoto;
        
        if($request->file('filefoto'))
        {
            $file = $request->file('filefoto');
            $filefoto = time()."".$file->getClientOriginalName();
            $file_ext  = $file->getClientOriginalExtension();
            
            $local_gambar = "img/display_discount/".$display_discount->images;
            

            $tujuan_upload = 'img/display_discount/';
            $file->move($tujuan_upload,$filefoto);
            $display_discount->images = $filefoto;
        }

        $display_discount->save();
        return redirect()->route('displayDiscount.index')->with(['success' => 'Discount Successfully Created']);
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
        return view('admin.display_discount.edit', [
            'display_discount' => display_discount::find($id)
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
        $display_discount = display_discount::find($id);
        $display_discount->excerpt = $request->excerpt;
        $display_discount->name = $request->name;
        $display_discount->tanggal = date('Y-m-d');
        $display_discount->periode = $request->periode;
        $display_discount->desc = $request->desc;
        $display_discount->images = $request->filefoto;
        
        if($request->file('filefoto'))
        {
            $file = $request->file('filefoto');
            $filefoto = time()."".$file->getClientOriginalName();
            $file_ext  = $file->getClientOriginalExtension();
            
            $local_gambar = "img/display_discount/".$display_discount->images;
            

            $tujuan_upload = 'img/display_discount/';
            $file->move($tujuan_upload,$filefoto);
            $display_discount->images = $filefoto;
        }

        $display_discount->save();
        return redirect()->route('displayDiscount.index')->with(['success' => 'Discount Successfully Created']);
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
}
