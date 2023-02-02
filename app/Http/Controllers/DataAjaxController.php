<?php

namespace App\Http\Controllers;

use App\Models\Angkatan;
use Illuminate\Http\Request;

class DataAjaxController extends Controller
{
    public function getIdAngkatan(Request $request) 
    {
        $id = $request->id;
        $data['data'] = Angkatan::find($id);
        return response()->json($data);

    }

    public function getDataAngkatan()
    {
        $data['data'] = Angkatan::all();
        return response()->json($data);
    }
}