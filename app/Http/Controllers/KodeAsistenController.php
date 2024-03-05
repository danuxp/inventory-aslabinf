<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\KodeAsisten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;


class KodeAsistenController extends Controller
{
    public function index(KodeAsisten $kodeAsisten)
    {
        $data = [
            'title' => 'Kode Asisten',
            'biodata' => Biodata::where('status', 'A')->get(),
            'data' => $kodeAsisten->joinBiodata()

        ];
        return view('kode_asisten.index', $data);
    }

    protected function store(Request $request)
    {
        $rules = [];

        $id = $request->id;
        $bio_id = $request->bio_id;

        $message = [
            'asisten.required' => 'Kolom asisten harus diisi',
            'asisten.unique' => 'Data asisten sudah ada',
            'kode_asisten.required' => 'Kolom kode asisten harus diisi',
            'kode_asisten.unique' => 'Kode asisten tidak boleh sama'
        ];

        if (is_null($id)) {
            $rules['asisten'] = 'required|unique:kode_asistens,bio_id';
            $rules['kode_asisten'] = 'required|unique:kode_asistens,kd_asisten';
        }


        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'bio_id' => is_null($bio_id) ? $request->asisten : $bio_id,
            'kd_asisten' => strtoupper($request->kode_asisten)
        ];

        if (is_null($id)) {
            try {
                KodeAsisten::create($data);
                Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th->getMessage());
            }
            return redirect()->back();
        } else {
            try {
                $update = KodeAsisten::find($id);
                $update->update($data);
                Alert::success('Berhasil', 'Data Berhasil Diupdate');
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th->getMessage());
            }
            return redirect()->back();
        }
    }

    protected function destroy(Request $request)
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
