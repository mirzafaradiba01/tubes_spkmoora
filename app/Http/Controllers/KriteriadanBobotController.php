<?php

namespace App\Http\Controllers;

use App\Models\KriteriadanBobot;
use Illuminate\Http\Request;

class KriteriadanBobotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kriteriadanbobot = KriteriadanBobot::get();
        return view('kriteriadanbobot.index', compact('kriteriadanbobot'))->with('i', 0);
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
        $request->validate([
            'kode_kriteria' => 'required',
            'kriteria' => 'required',
            'bobot' => 'required',
            'jenis_kriteria' => 'required',
        ]);

        KriteriadanBobot::create($request->all());

        return redirect()->route('kriteriabobot.index')
                ->with('success', 'Kriteria created successfully');


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
        logger($request->all());

    $request->validate([
        'kode_kriteria' => 'required',
        'jenis_kriteria' => 'required',
        'bobot' => 'required',
        'kriteria' => 'required',
    ]);

    $kriteriadanbobot = KriteriadanBobot::findOrFail($id);

    $kriteriadanbobot->update($request->all());

    return redirect()->route('kriteriabobot.index')
                    ->with('success','Criteria updated successfully');


                

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KriteriadanBobot  $kriteriadanBobot
     * @return \Illuminate\Http\Response
     */
    public function destroy($kriteriadanbobot)
    {
            KriteriadanBobot::destroy($kriteriadanbobot);
            return redirect()->route('kriteriabobot.index')->with('success', 'Kriteria deleted successfully');

    }
}
