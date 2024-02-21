<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Angkatan;
use App\Models\Biodata;
use App\Models\Divisi;
use App\Models\KodeAsisten;
use App\Models\LapRapat;
use App\Models\NamaLab;
use App\Models\PjLab;

class DataAjaxController extends Controller
{
    // get ajax id angkatam
    public function getIdAngkatan(Request $request)
    {
        $id = $request->id;
        $data['data'] = Angkatan::find($id);
        return response()->json($data);
    }

    // get ajax angkatan
    public function getDataAngkatan()
    {
        $data['data'] = Angkatan::all();
        return response()->json($data);
    }

    // get ajax divisi
    public function getIdDivisi(Request $request)
    {
        $id = $request->id;
        $data['data'] = Divisi::find($id);
        return response()->json($data);
    }

    // get ajax kode asisten
    public function getIdKode(Request $request, KodeAsisten $kodeAsisten)
    {
        $id = $request->id;
        $data['data'] = $kodeAsisten->getJoinBio($id);
        return response()->json($data);
    }

    // get ajax nama lab
    public function getIdLab(Request $request)
    {
        $id = $request->id;
        $data['data'] = NamaLab::find($id);
        return response()->json($data);
    }

    public function getIdLapRapat(Request $request)
    {
        $id = $request->id;
        $data['data'] = LapRapat::find($id);
        return response()->json($data);
    }

    public function getIdBiodata(Request $request)
    {
        $id = $request->id;
        $data = Biodata::find($id);
        return response()->json($data);
    }

    public function getIdPjLab(Request $request)
    {
        $id = $request->id;
        $data = PjLab::find($id);
        return response()->json($data);
    }
}
