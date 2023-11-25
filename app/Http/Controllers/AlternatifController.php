<?php

namespace App\Http\Controllers;

use App\Models\alternatif;
use App\Models\Modelalternatif;
use Illuminate\Http\Request;

class AlternatifController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alternatif = Modelalternatif::get();
        return view('alternatif.index', compact('alternatif'))->with('i',0);
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

        Modelalternatif::create($request->all());

        return redirect()->route('alternatif.index')
                ->with('success', 'Alternatif created successfully');
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
    public function edit(Modelalternatif $alternatif)
    {
        
        $alternatifscores = Modelalternatif::where('nama', $alternatif->id)->get();
        return view('alternatif.edit', compact('alternatif'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modelalternatif $alternatif)
    {
        $request->validate([
            'nama' => 'required'
            
        ]);

        $alternatif->update($request->all());

        return redirect()->route('alternatif.index')
                        ->with('success','Criteria updated successfully');
    }
    


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\alternatif  $alternatif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modelalternatif $alternatif)
    {
        $scores = Modelalternatif::where('nama', $alternatif->id)->delete();
        $alternatif->delete();

        return redirect()->route('alternatif.index')
            ->with('success', 'alternatif deleted successfully');
    }
}
    

