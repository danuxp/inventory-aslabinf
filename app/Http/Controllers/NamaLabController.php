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

        if(is_null($id)) {
            try {
                NamaLab::create($data);
                Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
                return redirect()->back();
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th);
                return redirect()->back();
            }
        } else {
            try {
                $update = NamaLab::find($id);
                $update->update($data);
                Alert::success('Berhasil', 'Data Berhasil Diupdate');
                return redirect()->back();
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th);
                return redirect()->back();
            }
            
            
        }
    }

    public function update(Request $request, NamaLab $namaLab)
    {
        $rules = [
            'edit_lab' => 'required'
        ];

        $message = [
            'edit_lab.required' => 'Kolom asisten harus diisi'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'nama' => strtoupper($request->edit_lab),
        ];

        $result = $namaLab->where('id', $request->id)->update($data);
        
        if($result == true) {
            Alert::success('Berhasil', 'Data Berhasil Diedit');
            return redirect()->back();
        } else {
            Alert::warning('Peringatan', 'Data Gagal Diedit');
            return redirect()->back();
        }
    }

    public function destroy(Request $request, NamaLab $namaLab)
    {
        $id = $request->id; 
        $result = $namaLab->findOrFail($id);
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