<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Divisi',
            'divisi' => Divisi::all()
        ];
        
        return view('divisi.index', $data); 
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
        $rules = [
            'divisi' => 'required'
        ];

        $message = [
            'divisi.required' => 'Kolom divisi harus diisi',
            // 'divisi.string' => 'Inputan harus berupa string'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $kode = "ASBINF" . rand(100, 999);
        $nama_divisi = strtoupper($request->divisi);

        $data = [
            'kd_divisi' => $kode,
            'nama_divisi' => $nama_divisi
        ];

        $cek_kode = Divisi::find($kode);
        $cek_divisi = Divisi::where('nama_divisi', $nama_divisi)->get();


        if($cek_kode == true or count($cek_divisi) == 1) {
            Alert::warning('Peringatan', 'Maaf Data Sudah Ada');
            return redirect()->back();
        } else {
            Divisi::create($data);
            Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function show(Divisi $divisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function edit(Divisi $divisi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Divisi $divisi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Divisi $divisi)
    {
        //
    }
}