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
        $id = $request->id;

        $data = [
            'nama_divisi' => $nama_divisi
        ];

        $cek_kode = Divisi::find($kode);
        $cek_divisi = Divisi::where('nama_divisi', $nama_divisi)->get();


        if($cek_kode == true or count($cek_divisi) == 1) {
            Alert::warning('Peringatan', 'Maaf Data Sudah Ada');
            return redirect()->back();
        } else {
            if(is_null($id)) {
                try {
                    $data['kd_divisi'] = $kode;
                    Divisi::create($data);
                    Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
                    return redirect()->back();
                } catch (\Throwable $th) {
                    Alert::error('Gagal', $th->getMessage());
                    return redirect()->back();
                }
            } else {
                try {
                    $update = Divisi::find($id);
                    $update->update($data);
                    Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
                    return redirect()->back();
                } catch (\Throwable $th) {
                    Alert::error('Gagal', $th->getMessage());
                    return redirect()->back();
                }
            }
            
        }

    }

    public function destroy(Request $request)
    {
        $id = $request->id; 
        try {
            $result = Divisi::find($id);
            $result->delete();
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Peringatan', $th->getMessage());
            return redirect()->back();
        }
    }
}