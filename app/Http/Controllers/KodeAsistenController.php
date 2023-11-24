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
            'biodata' => Biodata::where('status', 'A')->get(),
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
    public function store(Request $request)
    {
        $rules = [];

        $message = [
            'asisten.required' => 'Kolom asisten harus diisi',
            'kode_asisten.required' => 'Kolom kode asisten harus diisi',
            'kode_asisten.unique' => 'Kode asisten tidak boleh sama'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $id = $request->id;
        $bio_id = $request->bio_id;

        $data = [
            'bio_id' => is_null($bio_id) ? $request->asisten : $bio_id,
            'kd_asisten' => strtoupper($request->kode_asisten)
        ];

        if(is_null($id)) {
            $rules['asisten'] = 'required|unique:kode_asistens,asisten';
            $rules['kode_asisten'] = 'required|unique:kode_asistens,kd_asisten';
            try {
                KodeAsisten::create($data);
                Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
                return redirect()->back();
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th->getMessage());
                return redirect()->back();
            }

        } else {
            try {
                $update = KodeAsisten::find($id);
                $update->update($data);
                Alert::success('Berhasil', 'Data Berhasil Diupdate');
                return redirect()->back();
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th->getMessage());
                return redirect()->back();
            }

        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id; 
        try {
            $result = KodeAsisten::find($id);
            $result->delete();
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::warning('Gagal', $th->getMessage());
            return redirect()->back();
        }
    }
}