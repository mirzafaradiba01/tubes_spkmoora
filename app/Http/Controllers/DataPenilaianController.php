<?php

namespace App\Http\Controllers;

use App\Models\DataPenilaian;
use App\Models\Modelalternatif;
use Illuminate\Http\Request;

class DataPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alternatif= Modelalternatif::get();
        $datapenilaian = DataPenilaian::get();
        return view('penilaian.index', compact('alternatif','datapenilaian'))->with('i', 0);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penilaian.tambah');
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
            'id_alternatif' => 'required',
            'id_kriteria' => 'required',
            'skor' => 'required',
        ]);

        DataPenilaian::create($request->all());

        return redirect()->route('datapenilaian.index')
                ->with('success', 'Kriteria created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataPenilaian  $dataPenilaian
     * @return \Illuminate\Http\Response
     */
    public function show(DataPenilaian $dataPenilaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataPenilaian  $dataPenilaian
     * @return \Illuminate\Http\Response
     */
    public function edit(DataPenilaian $dataPenilaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataPenilaian  $dataPenilaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataPenilaian $dataPenilaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataPenilaian  $dataPenilaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataPenilaian $dataPenilaian)
    {
        //
    }
}
