<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InventoryLab;
use App\Models\NamaLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InventoryLabController extends Controller
{
    public function index()
    {

        return QrCode::generate("haii semua");

        $data = [
            "title" => "Inventory Lab",
            "nama_lab" => NamaLab::all(),
            "data" => InventoryLab::all()
        ];
        return view('inventory_lab.index', $data);
    }

    protected function store(Request $request)
    {
        $nama_lab = $request->namalab;
        $nama_barang = $request->nama_barang;
        $jml_baik = $request->jml_baik;
        $jml_rusak = $request->jml_rusak;
        $keterangan = $request->keterangan;
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
                'jml_rusak' => $jml_rusak[$key],
                'keterangan' => $keterangan[$key]
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
        try {
            DB::table('inventory_labs')
                ->where('id', $id)
                ->update([
                    'barang' => DB::raw("JSON_REMOVE(barang, '$[$key]')")
                ]);
            $response = ['title' => 'Berhasil', 'icon' => 'success', 'text' => 'Berhasil diupdate'];
        } catch (\Throwable $th) {
            $response = ['title' => 'Gagal', 'icon' => 'error', 'text' => 'Gagal diupdate'];
        }
        return response()->json($response);
    }

    public function addNewRow(Request $request)
    {
        $id = $request->id;
        $barang_add = $request->barang_add;
        $jmlbaik_add = $request->jmlbaik_add;
        $jmlrusak_add = $request->jmlrusak_add;
        $keterangan_add = $request->keterangan_add;

        $jsonData = [];

        foreach ($barang_add as $key => $row) {
            $jsonData[] = [
                'nama' => $row,
                'jml_baik' => $jmlbaik_add[$key],
                'jml_rusak' => $jmlrusak_add[$key],
                'keterangan' => $keterangan_add[$key],
            ];
        }

        $updatedData = json_encode($jsonData);

        try {
            DB::table('inventory_labs')
                ->where('id', $id)
                ->update(['barang' => $updatedData]);
            $response = ['title' => 'Berhasil', 'icon' => 'success', 'text' => 'Berhasil diupdate'];
        } catch (\Throwable $th) {
            $response = ['title' => 'Gagal', 'icon' => 'error', 'text' => 'Gagal diupdate'];
        }
        return response()->json($response);
    }

    public function hapus(Request $request)
    {
        $id = $request->id;
        try {
            $inventory = InventoryLab::find($id);
            $inventory->delete();
            $response = ['title' => 'Berhasil', 'icon' => 'success', 'text' => 'Berhasil dihapus'];
        } catch (\Throwable $th) {
            $response = ['title' => 'Gagal', 'icon' => 'error', 'text' => 'Gagal dihapus'];
        }
        return response()->json($response);
    }

    public function cetak($id = null)
    {
        if ($id) {
            try {
                $decrypt_id = Crypt::decryptString($id);
                // $inventoryLab = new InventoryLab();
                $getdata = InventoryLab::find($decrypt_id);
                $data = [
                    'data' => $getdata,
                    'title' => 'Inventory Lab ' . $getdata->lab->nama,
                    'barang' => json_decode($getdata->barang, true)
                ];

                $pdf = PDF::loadView('inventory_lab.cetak', $data);
                return $pdf->stream($data['title'] . '.pdf');
            } catch (\Throwable $th) {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function cetak_qr(Request $request)
    {
        $id = $request->id;
        $key = $request->key;
        if ($id) {
            try {
                $getdata = InventoryLab::find($id);
                $data_inventory = json_decode($getdata->barang, true)[$key];
                $data = [
                    'data' => $getdata,
                    'title' => 'Inventory Lab ' . $getdata->lab->nama,
                    'barang' => $data_inventory,
                    'key' => $key,
                    'id' => $id,
                ];
                return view('inventory_lab.cetakqr', $data);
            } catch (\Throwable $th) {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function show_qr($param)
    {
        $get_qr = base64_decode($param);
        $qrcode = explode('_', $get_qr);
        $inventory = InventoryLab::find($qrcode[1]);
        $data_barang = json_decode($inventory->barang, true);

        $data = [
            'title' => 'View Qr Code',
            'data' => $inventory,
            'barang' => $data_barang[$qrcode[2]],
            'key' => $qrcode[3]
        ];
        return view('inventory_lab.view_qrcode', $data);
    }
}
