<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Angkatan;
use Alert;

class AngkatanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Angkatan',
            'angkatan' => Angkatan::all()
        ];

        return view('angkatan.index', $data);
    }

    protected function store(Request $request)
    {
        $rules = [
            'angkatan' => 'required|numeric'
        ];

        $message = [
            'angkatan.required' => 'Kolom angkatan harus diisi',
            'angkatan.numeric' => 'Inputan harus berupa angka'
        ];

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $id = $request->id;

        $data = [
            'angkatan_ke' => $request->angkatan
        ];

        if (is_null($id)) {
            try {
                Angkatan::create($data);
                Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th->getMessage());
            }
            return redirect()->back();
        } else {
            try {
                $update = Angkatan::find($id);
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
            $data = Angkatan::find($id);
            $data->delete();
            $response = ['title' => 'Berhasil', 'icon' => 'success', 'text' => 'Berhasil dihapus'];
        } catch (\Throwable $th) {
            $response = ['title' => 'Gagal', 'icon' => 'error', 'text' => 'Gagal dihapus'];
        }
        return response()->json($response);
    }
}
