<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AngkatanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Angkatan',
        ];
        return view('angkatan.index', $data);
        
    }
}
