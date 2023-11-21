<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Angkatan;
use App\Models\Biodata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Alert;
use App\Models\User;

class RegistrasiAsistenControlller extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Registrasi Asisten',
            'angkatan' => Angkatan::all(),
            'data' => Biodata::all()

        ];
        return view('biodata.register', $data);

    }

    public function store(Request $request)
    {
        $id = $request->id;

        $rules = [
            'namalengkap' => 'required',
            'namacantik' => 'required',
            'kelamin' => 'required',
            'angkatan' => 'required',
        ];

        $message = [
            'namalengkap.required' => 'Nama lengkap harus diisi',
            'namacantik.required' => 'Nama cantik harus diisi',
            'kelamin.required' => 'Jenis kelamin harus diisi',
            'angkatan.required' => 'Angkatan harus diisi',
        ];

        if(is_null($id)) {
            $rules['nim'] = 'required|unique:biodatas,nim';
            $message['nim'] = ['required' => 'Nim harus diisi',
            'unique' => 'Nim sudah ada'];
        }

        $validator = Validator::make($request->all(), $rules, $message);

 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }


        $data = [
            'nim' => $request->nim,
            'nama_lengkap' => strtoupper($request->namalengkap),
            'nama_cantik' => strtoupper($request->namacantik),
            'jenis_kelamin' => $request->kelamin,
            'angkatan' => $request->angkatan,
        ];

        $user = [
            'nim' => $request->nim,
            'username' => $request->nim,
            'password' => Hash::make($request->nim),
            'role' => 1
        ];

        if(is_null($id)) {
             try {
                User::create($user);
                Biodata::create($data);
                Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
                return redirect()->back();
             } catch (\Throwable $th) {
                Alert::success('Gagal', $th);
                return redirect()->back();
             }
        } else {
            try {
                $update = Biodata::find($id);
                $update->update($data);
                Alert::success('Berhasil', 'Data Berhasil Diupdate');
                return redirect()->back();
            } catch (\Throwable $th) {
                Alert::success('Gagal', $th);
                return redirect()->back();
            }
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        try {
            $delete = Biodata::find($id);
            $delete->delete();
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::success('Gagal', $th);
            return redirect()->back();
        }

    }
}
