<?php

namespace App\Http\Controllers;

use App\Models\DataPenilaian;
use App\Models\KriteriadanBobot;
use App\Models\Modelalternatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DataPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(){
        $data = Modelalternatif::selectRaw('id, nama');
        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }
    public function index()
    {
       return view('datapenilaian.index');
        // $alternatif= Modelalternatif::get();
        // $datapenilaian = DataPenilaian::get();
        // return view('penilaian.index', compact('alternatif','datapenilaian'))->with('i', 0);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('datapenilaian.tambah');
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
        'nama' => 'required',
        'kode_kriteria' => 'required'
    ]);

    // Create Modelalternatif
    $alt = Modelalternatif::create(['nama' => $request->nama]);

    // Create KriteriadanBobot
    $kriteria = KriteriadanBobot::create(['kode_kriteria' => $request->kode_kriteria]);

    // Create DataPenilaian for each kriteria
    $kriteria = KriteriadanBobot::get();
    foreach ($kriteria as $c) {
        $data = new DataPenilaian();
        $data->id_alternatif = $alt->id;
        $data->id_kriteria = $c->id;
        $data->skor = $request->input('kriteria')[$c->id];
        $data->save();
    }

    // Return JSON response with redirect URL
    return response()->json([
        'status' => true,
        'message' => 'Penilaian created successfully',
        'redirect' => route('datapenilaian.index')
    ]);
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
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataPenilaian  $dataPenilaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $rule = [
        'nama' => 'required|string',
        'kode_kriteria' => 'required'
    ];

    $validator = Validator::make($request->all(), $rule);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'modal_close' => false,
            'message' => 'Data gagal diedit' . $validator->errors()->first(),
            'data' => $validator->errors()
        ]);
    }

    // Update Modelalternatif
    $modelAlternatif = Modelalternatif::find($id);
    $modelAlternatif->update($request->except('_token', '_method'));

    // Update KriteriadanBobot
    $kriteriaDanBobot = KriteriadanBobot::find($id);
    $kriteriaDanBobot->update($request->except('_token', '_method'));

    return response()->json([
        'status' => true,
        'modal_close' => true,
        'message' => 'Data berhasil diedit',
        'data' => null
    ]);
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
