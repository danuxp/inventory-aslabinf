<?php

namespace App\Http\Controllers;

use App\Models\LapRapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;

class LapRapatController extends Controller
{
    public function index()
    {
        
        $data = [
            'title' => 'Laporan Rapat',
            'data' => LapRapat::all()
        ];
        return view('lap_rapat.index', $data);
    }

    public function store(Request $request, LapRapat $lapRapat)
    {
        $rules = [
            'tanggal' => 'required|date',
            'jenis' => 'required',
            'catatan' => 'required'
        ];

        $message = [
            'tanggal.required' => 'Kolom tanggal harus diisi',
            'tanggal.date' => 'Kolom harus berupa tanggal',
            'jenis.required' => 'Kolom jenis harus diisi',
            'catatan.required' => 'Kolom catatan harus diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'catatan' => htmlspecialchars($request->catatan)
        ];

        if($lapRapat->create($data) == true) {
            Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Data Gagal Ditambahkan');
            return redirect()->back();
        }

    }
}