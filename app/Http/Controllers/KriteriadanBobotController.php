<?php

namespace App\Http\Controllers;

use App\Models\KriteriadanBobot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KriteriadanBobotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $data = KriteriadanBobot::selectRaw('id, kode_kriteria, jenis_kriteria, bobot, kriteria');

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function penilaian()
    {
        $data = KriteriadanBobot::selectRaw('id, kode_kriteria');

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

     public function index()
    {
        // $kriteriadanbobot = KriteriadanBobot::get();
        // return view('kriteriadanbobot.index', compact('kriteriadanbobot'))->with('i', 0);
        return view('kriteriadanbobot.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kriteriadanbobot.tambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule= [
            'kode_kriteria' => 'required|string|unique:kriteriadan_bobot,kode_kriteria',
            'jenis_kriteria' => 'required|in:Benefit,Cost',
            'bobot' => 'required',
            'kriteria' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rule);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'modal_close' => false,
                'message' => 'Data gagal ditambahkan. ' .$validator->errors()->first(),
                'data' => $validator->errors()
            ]);
        }

        $kriteriadanBobot = KriteriadanBobot::create($request->all());
        return response()->json([
            'status' => ($kriteriadanBobot),
            'modal_close' => false,
            'message' => ($kriteriadanBobot)? 'Data berhasil ditambahkan' : 'Data gagal ditambahkan',
            'data' => null
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KriteriadanBobot  $kriteriadanBobot
     * @return \Illuminate\Http\Response
     */
    public function show(KriteriadanBobot $kriteriadanBobot)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KriteriadanBobot  $kriteriadanBobot
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kriteriadanbobot = KriteriadanBobot::findOrFail($id);

        return view('kriteriadanbobot.edit', compact('kriteriadanbobot'));

    }
    



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KriteriadanBobot  $kriteriadanBobot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $rule= [
            'kode_kriteria' => 'required|string|unique:kriteriadanbobot, kode_kriteria',
            'jenis_kriteria' => 'required|in:Benefit,Cost',
            'bobot' => 'required',
            'kriteria' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rule);
            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'modal_close' => false,
                    'message' => 'Data gagal diedit. ' .$validator->errors()->first(),
                    'data' => $validator->errors()
                ]);
            }

            $kriteriadanBobot = KriteriadanBobot::where('id', $id)->update($request->except('_token', '_method'));

            return response()->json([
                'status' => ($kriteriadanBobot),
                'modal_close' => $kriteriadanBobot,
                'message' => ($kriteriadanBobot)? 'Data berhasil diedit' : 'Data gagal diedit',
                'data' => null
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KriteriadanBobot  $kriteriadanBobot
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kriteriadanBobot = KriteriadanBobot::find($id);

        if (!$kriteriadanBobot) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
                'data' => null
            ]);
        }

        $deleted = $kriteriadanBobot->delete();

        if ($deleted) {
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus',
                'data' => null
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data gagal dihapus',
                'data' => null
            ]);
        }
    }

}
