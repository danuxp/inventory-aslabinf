<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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
        ];
        return view('auth.register', $data);
    }

    public function loginValid(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'

        ]);
        // return back()->withInput();
    }

    public function registerValid(Request $request)
    {
        $rules = [
            'nim' => 'required|numeric',
            'nama_lengkap' => 'required',
            'nama_cantik' => 'required',
            'angkatan' => 'required',
            'kelamin' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required|min:8',
            'password2' => 'required|same:password'
        ];

        $message = [
            'nim.required' => 'Nim tidak boleh kosong',
            'nim.numeric' => 'Nim tidak boleh karakter',
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
            'nama_cantik.required' => 'Nama cantik tidak boleh kosong',
            'angkatan.required' => 'Angkatan tidak boleh kosong',
            'kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password harus 8 karakter',
            'password2.required' => 'Konfirmasi password tidak boleh kosong',
            'password2.same' => 'Konfirmasi password tidak sesuai',
        ];
    //     $request->validate([
    //     ],
    //     [

    //     ]
    // );
        $validator = Validator::make($request->all(), $rules, $message);
 
        //cek validasi
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
    }
}