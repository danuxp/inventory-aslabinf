<?php

namespace App\Http\Controllers;

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

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $data = [
            'nim' => $request->input('nim'),
            'nama_lengkap' => $request->input('nama_lengkap'),
            'nama_cantik' => $request->input('nama_cantik'),
            'angkatan' => $request->input('angkatan'),
            'kelamin' => $request->input('kelamin'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ];
        dd($data);
    }
}