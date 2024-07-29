<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // dd(session()->all());
        $data = [
            'title' => 'Login',
        ];
        return view('dashboard', $data);
    }
}
