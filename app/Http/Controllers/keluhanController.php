<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\keluhan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class keluhanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keluhan = keluhan::query();

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
            $keluhan = $keluhan->whereBetween('keluhans.tanggal', [$start_date, $end_date]);
        }

        $keluhan = $keluhan->get();

        return view('admin.keluhan.index', compact('keluhan', 'start_date', 'end_date'));
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
        $request->validate([
            // 'nama' => 'required',
            'isi' => 'required',
        ]);

        $keluhan = new keluhan();
        $keluhan->nama = $request->nama;
        $keluhan->category = $request->category;
        $keluhan->isi = $request->isi;
        $keluhan->tanggal = date('Y-m-d');
        $keluhan->save();

        return redirect('keluhan')->with('succes', 'Data Keluhan Berhasil di Input');
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
        $keluhan = keluhan::where('keluhans.id', $id)->first();
        return view('admin.keluhan.edit', compact('keluhan'));
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
        DB::table('keluhans')->where('id', $request->id)
            ->update([
                'nama' => $request->nama,
                'tanggal' => $request->tanggal,
                'isi' => $request->isi,
                'tgl_tanggapan' => $request->tgl_tanggapan,
                'tanggapan' => $request->tanggapan,
                'status' => $request->status,
            ]);

        return redirect()->back()
            ->with('success', 'Keluhan updated successfully');
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

    public function exportPDFKeluhan(Request $request)
    {
        $keluhan = keluhan::query();

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        if ($request->has('start_date') && $request->has('end_date')) {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
            $keluhan = $keluhan->whereBetween('keluhans.tanggal', [$start_date, $end_date]);
        }

        $keluhan = $keluhan->get();

        $pdf = PDF::loadView('admin.laporan.PDFKeluhan', compact('keluhan', 'start_date', 'end_date'));
        return $pdf->download('laporan Keluhan.pdf');
    }
}
