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
            // 'divisi.regex' => 'Inputan harus berupa string'
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Divisi $divisi)
    {
        $rules = [
            'edit_divisi' => 'required'
        ];

        $message = [
            'edit_divisi.required' => 'Kolom angkatan harus diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'nama_divisi' => strtoupper($request->edit_divisi)
        ];

        $cek_nama = $divisi->where('nama_divisi', strtoupper($request->edit_divisi))->get();
        
        $result = $divisi->where('id_divisi', $request->id)->update($data);
        
        if(count($cek_nama) == 1) {
            Alert::warning('Peringatan', 'Maaf Data Sudah Ada');
            return redirect()->back();
        } else if($result == true) {
            Alert::success('Berhasil', 'Data Berhasil Diedit');
            return redirect()->back();
        } else {
            Alert::warning('Peringatan', 'Data Gagal Diedit');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Divisi $divisi)
    {
        $id = $request->id; 
        $result = $divisi->findOrFail($id);
        if($result == true) {
            $result->delete();
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
            return redirect()->back();
        } else {
            Alert::warning('Peringatan', 'Data Gagal Dihapus');
            return redirect()->back();
        }
    }
}