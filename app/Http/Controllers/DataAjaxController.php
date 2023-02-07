<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Angkatan;
use App\Models\Divisi;


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

    public function getIdDivisi(Request $request)
    {
        $id = $request->id;
        $data['data'] = Divisi::find($id);
        return response()->json($data);
    }
}