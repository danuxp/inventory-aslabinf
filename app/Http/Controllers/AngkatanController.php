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

        $data = [
            'angkatan_ke' => $request->angkatan
        ];

        if(Angkatan::create($data) == true) {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Angkatan $angkatan)
    {
        $rules = [
            'edit_angkatan' => 'required|numeric'
        ];

        $message = [
            'edit_angkatan.required' => 'Kolom angkatan harus diisi',
            'edit_angkatan.numeric' => 'Inputan harus berupa angka'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'angkatan_ke' => $request->edit_angkatan
        ];

        $result = $angkatan->where('id_angkatan', $request->id)->update($data);
        
        if($result == true) {
            Alert::success('Berhasil', 'Data Berhasil Diedit');
            return redirect()->back();
        } else {
            Alert::warning('Peringatan', 'Data Gagal Diedit');
            return redirect()->back();
        }
        
        // return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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