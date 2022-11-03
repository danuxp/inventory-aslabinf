<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'User Login'
        ];
        return view('user_login.index', $data);
    }
}
