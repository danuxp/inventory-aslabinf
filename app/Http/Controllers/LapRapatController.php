<?php

namespace App\Http\Controllers;

use App\Models\LapRapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;

class LapRapatController extends Controller
{
    public function index()
    {
        
        $data = [
            'title' => 'Laporan Rapat',
            'data' => LapRapat::all()
        ];
        return view('lap_rapat.index', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'tanggal' => 'required|date',
            'jenis_rapat' => 'required',
            'catatan' => 'required'
        ];

        $message = [
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Inputan harus berupa tanggal',
            'jenis_rapat.required' => 'Jenis rapat harus diisi',
            'catatan.required' => 'Catatan harus diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $message);
 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $id = $request->id;

        $data = [
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis_rapat,
            'catatan' => $request->catatan
        ];

        if(is_null($id)) {
            try {
                $data['author'] = 'Tes';
                $data['tempat'] = $request->tempat == null ? 'Laboratorium' : $request->tempat;
                LapRapat::create($data);
                Alert::success('Berhasil', 'Data Berhasil Ditambahkan');
                return redirect()->back();
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th);
                return redirect()->back();
            }

        } else {
            try {
                $update = LapRapat::find($id);
                $data['tempat'] = $request->jenis_rapat == "RB" ? $request->tempat : 'Laboratorium';
                $update->update($data);
                Alert::success('Berhasil', 'Data Berhasil Diupdate');
                return redirect()->back();
            } catch (\Throwable $th) {
                Alert::error('Gagal', $th);
                return redirect()->back();
            }
        }

    }

    public function destroy(Request $request)
    {
        $id = $request->id; 
        $result = LapRapat::findOrFail($id);
        if($result == true) {
            $result->delete();
            Alert::success('Berhasil', 'Data Berhasil Dihapus');
            return redirect()->back();
        } else {
            Alert::warning('Peringatan', 'Data Gagal Dihapus');
            return redirect()->back();
        }
    }

    public function cetak($id = null)
    {
        $decrypt_id = Crypt::decryptString($id);
        $data = [
            'data' => LapRapat::find($decrypt_id),
            'title' => 'Laporan Rapat_'.date('Y-m-d')
        ];
    
        $pdf = PDF::loadView('lap_rapat.cetak', $data);
        return $pdf->stream('cetak_laporan.pdf');
        
    }
}