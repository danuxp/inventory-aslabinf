<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\KodeAsisten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;


class KodeAsistenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KodeAsisten $kodeAsisten)
    {
        $data = [
            'title' => 'Kode Asisten',
            'biodata' => Biodata::all(),
            'data' => $kodeAsisten->joinBiodata()

        ];
        return view('kode_asisten.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, KodeAsisten $kodeAsisten)
    {
        $rules = [
            'bio_id' => 'required|unique:kode_asistens,bio_id',
            'kode_asisten' => 'required|unique:kode_asistens,kd_asisten'
        ];

        $message = [
            'bio_id.required' => 'Kolom asisten harus diisi',
            'bio_id.unique' => 'Data sudah ada',
            'kode_asisten.required' => 'Kolom kode asisten harus diisi',
            'kode_asisten.unique' => 'Kode asisten tidak boleh sama'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'bio_id' => $request->bio_id,
            'kd_asisten' => strtoupper($request->kode_asisten)
        ];
        
        if($kodeAsisten->create($data) == true) {
            Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Data Gagal Ditambahkan');
            return redirect()->back();
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KodeAsisten  $kodeAsisten
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KodeAsisten $kodeAsisten)
    {
        $rules = [
            'edit_kode' => 'required|unique:kode_asistens,kd_asisten'
        ];

        $message = [
            'edit_kode.required' => 'Kolom kode asisten harus diisi',
            'edit_kode.unique' => 'Kode asisten tidak boleh sama'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'kd_asisten' => strtoupper($request->edit_kode)
        ];

        $result = $kodeAsisten->where('id', $request->id)->update($data);
        
        if($result == true) {
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
     * @param  \App\Models\KodeAsisten  $kodeAsisten
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, KodeAsisten $kodeAsisten)
    {
        $id = $request->id; 
        $result = $kodeAsisten->findOrFail($id);
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