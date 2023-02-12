<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BiodataController extends Controller
{
    public function profile()
    {
        $data = [
            'title' => 'Profile',
        ];

        return view('profile.index', $data); 
    }
}