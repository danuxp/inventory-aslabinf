<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LapRapatController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Laporan Rapat',
        
        ];

        return view('lap_rapat.index', $data);

    }

    public function store(Request $request)
    {
        // $rules = [
        //     'nim' => 'required',
        //     'lab' => 'required'
        // ];

        // $message = [
        //     'nim.required' => 'Kolom nim harus diisi',
        //     'lab.required' => 'Kolom lab harus diisi',
        // ];

        // $validator = Validator::make($request->all(), $rules, $message);
 
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput($request->all());
        // }
        $tgl = $request->tanggal;
        $jenis = $request->jenis;
        $catatan = $request->catatan;

        $data = [
            'tanggal' => $tgl,
            'jenis' => $jenis,
            'catatan' => htmlspecialchars($catatan)
        ];
         dd($data);

    }
}