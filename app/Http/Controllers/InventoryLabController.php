<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InventoryLab;
use App\Models\NamaLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;

class InventoryLabController extends Controller
{
    public function index()
    {
        $invlab = new InventoryLab();
        // $r = $invlab->lab->nama;
        // dd($r);
        $data = [
            "title" => "Inventory Lab",
            "nama_lab" => NamaLab::all(),
            "data" => $invlab->joinNamalab()
        ];
        return view('inventory_lab.index', $data);
    }

    protected function store(Request $request)
    {
        $nama_lab = $request->namalab;
        $nama_barang = $request->nama_barang;
        $jml_baik = $request->jml_baik;
        $jml_rusak = $request->jml_rusak;
        $data_barang = [];

        $get_lab_id = InventoryLab::where('lab_id', $nama_lab)->first();

        if ($get_lab_id != null) {
            Alert::error('Maaf data lab sudah ditambahkan');
            return redirect()->back();
        }

        foreach ($nama_barang as $key => $row) {
            $data_barang[] = [
                'nama' => $row,
                'jml_baik' => $jml_baik[$key],
                'jml_rusak' => $jml_rusak[$key]
            ];
        }

        $data = [
            'lab_id' => $nama_lab,
            'barang' => json_encode($data_barang)
        ];

        try {
            InventoryLab::create($data);
            Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            Alert::error('Gagal', $th->getMessage());
        }
        return redirect()->back();
    }

    public function deleteItem(Request $request)
    {
        $id = $request->id;
        $key = $request->key;
        // $q = DB::table('inventory_labs')
        //     ->where('id', $id)
        //     ->update([
        //         'barang' => DB::raw("JSON_REMOVE(barang, '$[$key]')")
        //     ]);

        // return redirect()->back();
        return response()->json(['message' => 'Baris baru berhasil ditambahkan'], 200);
    }

    public function addNewRow(Request $request)
    {
        $id = $request->id;
        $barang_add = $request->barang_add;
        $jmlbaik_add = $request->jmlbaik_add;
        $jmlrusak_add = $request->jmlrusak_add;

        $jsonData = [];

        foreach ($barang_add as $key => $row) {
            $jsonData[] = [
                'nama' => $row,
                'jml_baik' => $jmlbaik_add[$key],
                'jml_rusak' => $jmlrusak_add[$key]
            ];
        }


        $updatedData = json_encode($jsonData);

        // dd($updatedData);
        return response()->json($updatedData);

        // DB::table('nama_table')
        //     ->where('id', $id)
        //     ->update(['barang' => $updatedData]);
    }
}
