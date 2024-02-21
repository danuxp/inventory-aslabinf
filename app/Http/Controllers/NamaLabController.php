<?php

namespace App\Http\Controllers;

use App\Models\NamaLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;

class NamaLabController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Nama Laboratorium',
            'data' => NamaLab::all(),

        ];
        return view('nama_lab.index', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_lab' => 'required'
        ];

        $message = [
            'nama_lab.required' => 'Nama lab harus diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $id = $request->id;

        $data = [
            'nama' => strtoupper($request->nama_lab),
        ];

        if (is_null($id)) {
            try {
                NamaLab::create($data);
                Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th->getMessage());
            }
            return redirect()->back();
        } else {
            try {
                $update = NamaLab::find($id);
                $update->update($data);
                Alert::success('Berhasil', 'Data Berhasil Diupdate');
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th->getMessage());
            }
            return redirect()->back();
        }
    }


    public function destroy(Request $request, NamaLab $namaLab)
    {
        $id = $request->id;
        try {
            $result = $namaLab->findOrFail($id);
            $result->delete();
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
            return redirect()->back();
        }
    }
}
