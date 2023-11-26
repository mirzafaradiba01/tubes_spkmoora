<?php

namespace App\Http\Controllers;

use App\Models\alternatif;
use App\Models\Modelalternatif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Node\FunctionNode;
use Yajra\DataTables\Facades\DataTables;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $data = Modelalternatif::selectRaw('id, nama');

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }
    
     public function index()
    {
        // $alternatif = Modelalternatif::get();
        // return view('alternatif.index', compact('alternatif'))->with('i',0);
        return view('alternatif.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alternatif.tambah');
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
            'nama' => 'required'
        ]);

        $alternatif = Modelalternatif::create(['nama' => $request->nama]);

        // Return JSON response with redirect URL
        return response()->json([
            'status' => true,
            'message' => 'Alternatif created successfully',
            'redirect' => route('alternatif.index')
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    // public function show(alternatif $alternatif)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $alternatif = Modelalternatif::find($id);
        return view('alternatif.index')
            ->with('alt', $alternatif)
            ->with('url_form', url('/alternatif/'.$id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rule = [
            'nama' => 'required|string',
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

        $alternatif = Modelalternatif::where('id', $id)->update($request->except('_token', '_method'));

        return response()->json([
            'status' => ($alternatif),
            'modal_close' => $alternatif,
            'message' => ($alternatif)? 'Data berhasil diedit' : 'Data gagal diedit',
            'data' => null
        ]);
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alternatif = Modelalternatif::find($id);

        if (!$alternatif) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
                'data' => null
            ]);
        }

        $deleted = $alternatif->delete();

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
    

