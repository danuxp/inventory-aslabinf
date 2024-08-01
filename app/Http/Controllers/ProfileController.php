<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Setting'
        ];
        return view('setting.index', $data);
    }
}
