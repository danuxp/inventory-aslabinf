<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use App\Models\Biodata;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Login',
        ];
        return view('auth.login', $data);
        
    }

    public function register()
    {
        $data = [
            'title' => 'Register',
            'angkatan' => Angkatan::all()
        ];
        return view('auth.register', $data);
    }

    public function loginValid(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $message = [
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'nim' => 'required|numeric|max_digits:13|unique:users,nim',
            'nama_lengkap' => 'required',
            'nama_cantik' => 'required',
            'angkatan' => 'required',
            'kelamin' => 'required',
            'email' => 'required|email:dns',
            'username' => 'required',
            'password' => 'required|min:6',
            'password2' => 'required|same:password'
        ];

        $message = [
            'nim.required' => 'Nim tidak boleh kosong',
            'nim.numeric' => 'Nim tidak boleh karakter',
            'nim.max_digits' => 'Maksimal nim 13 angka',
            'nim.unique' => 'Nim sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
            'nama_cantik.required' => 'Nama cantik tidak boleh kosong',
            'angkatan.required' => 'Angkatan tidak boleh kosong',
            'kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password harus 6 karakter',
            'password2.required' => 'Konfirmasi password tidak boleh kosong',
            'password2.same' => 'Konfirmasi password tidak sesuai',
        ];


        $validator = Validator::make($rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        } 

        $dataBio = [
            'nim' => $request->nim,
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'nama_cantik' => strtoupper($request->nama_cantik),
            'angkatan' => $request->angkatan,
            'jenis_kelamin' => $request->kelamin,
            'email' => $request->email,
        ];

        $dataUser = [
            'nim' => $request->nim,
            'username' => $request->username,
            'role' => 2,
            'password' => Hash::make($request->password)
        ];

        if(User::create($dataUser) == true) {
            Biodata::create($dataBio);
            session()->flash('notif-success');
            return redirect()->to('/login');
        } else {
            session()->flash('notif-error');
            return redirect()->back();
        }
       
    }
}