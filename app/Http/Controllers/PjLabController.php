<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\NamaLab;
use App\Models\PjLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;
use Illuminate\Support\Facades\DB;


class PjLabController extends Controller
{
    public function index(PjLab $pjLab)
    {
        // $query = PjLab::join('biodatas as b', function ($join) {
        //     $join->on(DB::raw("FIND_IN_SET(b.id_bio, REPLACE(REPLACE(pj_labs.bio_id, '[', ''), ']', ''))"), '>', DB::raw("0"));
        // })->join('nama_labs as nl', 'nl.id', '=', 'pj_labs.lab_id')->select('pj_labs.*', 'b.nim', 'b.nama_lengkap', 'b.nama_cantik', 'b.angkatan', 'nl.nama as nama_lab')
        //     ->get();


        $data = [
            'title' => 'Pj Laboratorium',
            'asisten' => Biodata::all(),
            'nama_lab' => NamaLab::all(),
            'data' => $pjLab->getDataPjLab()
        ];
        // var_dump($data['data']);
        // echo "<pre>", var_dump($data['data']), "</pre>";
        // die;
        return view('pj_lab.index', $data);
    }

    public function store(Request $request)
    {

        $id = $request->id;
        $bio_id = $request->bio_id;
        $lab = $request->namalab;

        $rules = [];

        $message = [
            'bio_id.required' => 'Kolom nim harus diisi',
            'namalab.required' => 'Kolom nama lab harus diisi',
        ];

        if (is_null($id)) {
            $rules['bio_id'] = 'required';
            $rules['namalab'] = 'required';

            foreach ($bio_id as $row) {
                $cek = $this->cek_bioid($row);
                if ($cek === true) {
                    Alert::error('Maaf terdapat asisten yang sudah ditambahkan');
                    return redirect()->back();
                }
            }
        }

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }



        $data = [
            'bio_id' => json_encode(array_map('intval', $bio_id)),
            'lab_id' => $lab,
            'status' => 'A'
        ];

        if (is_null($id)) {
            try {
                PjLab::create($data);
                Alert::success('Berhasil Ditambahkan');
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th->getMessage());
            }
            return redirect()->back();
        } else {
            try {
                $update = PjLab::find($id);
                $update->update($data);
                Alert::success('Berhasil Diupdate');
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th->getMessage());
            }
            return redirect()->back();
        }
    }

    protected function cek_bioid($value)
    {
        $pjLab = new PjLab();
        $getdata = $pjLab->pluck('bio_id')->toArray();
        $data_nim = [];
        foreach ($getdata as $row) {
            $res_arr = json_decode($row, true);
            foreach ($res_arr as $val) {
                $data_nim[] = $val;
            }
        }

        if (in_array($value, $data_nim)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        try {
            $result = PjLab::find($id);
            $result->delete();
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
        } catch (\Throwable $th) {
            Alert::error('Peringatan', $th->getMessage());
        }
        return redirect()->back();
    }

    public function nonaktif(Request $request)
    {
        $id = $request->id;
        try {
            $result = PjLab::find($id);
            $result->update(['status' => 'T']);
            Alert::success('Berhasil', 'Data Berhasil Dinonaktifkan');
        } catch (\Throwable $th) {
            Alert::error('Peringatan', $th->getMessage());
        }
        return redirect()->back();
    }
}
