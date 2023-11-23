<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Angkatan;
use Alert;

class AngkatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Angkatan',
            'angkatan' => Angkatan::all()
        ];

        return view('angkatan.index', $data); 
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

        if(is_null($id)) {
            try {
                Angkatan::create($data);
                Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
                return redirect()->back();
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th);
                return redirect()->back();  
            }
        } else {
            try {
                $update = Angkatan::find($id);
                $update->update($data);
                Alert::success('Berhasil', 'Data Berhasil Diupdate');
                return redirect()->back();
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th);
                return redirect()->back(); 
            }
        }
    }

    public function destroy(Request $request, Angkatan $angkatan)
    {
        $id = $request->id; 
        $data = $angkatan->findOrFail($id);
        if($data == true) {
            $data->delete();
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
            return redirect()->back();
        } else {
            Alert::warning('Peringatan', 'Data Gagal Dihapus');
            return redirect()->back();
        }
    }
}