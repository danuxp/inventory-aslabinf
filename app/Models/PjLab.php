<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Biodata;


class PjLab extends Model
{
    use HasFactory;
    protected $fillable = ['bio_id', 'lab_id', 'status'];

    public function joinData()
    {
        $query = DB::table('pj_labs')
            ->select('biodatas.*', 'nama_labs.nama as nama_lab, nama_labs.id')
            ->join('biodatas', 'biodatas.nim = pj_labs.nim')
            ->join('nama_labs', 'nama_labs.id = pj_labs.lab_id')
            ->get();
        return $query;
    }

    public function getDataPjLab()
    {
        $data = [];

        $query = DB::table('pj_labs')->join('nama_labs', 'nama_labs.id', '=', 'pj_labs.lab_id')->select('pj_labs.*', 'nama_labs.nama as namalab')->where('pj_labs.status', 'A')->get();
        foreach ($query as $row) {
            $bio_id = json_decode($row->bio_id, true);

            $data[$row->id] = [
                'bio_id' => $bio_id,
                'asisten' => [],
                'nama_lab' => $row->namalab
            ];
            $biodata = Biodata::all();
            foreach ($biodata as $bio) {
                if (in_array($bio->id_bio, $bio_id)) {
                    array_push(
                        $data[$row->id]['asisten'],
                        [
                            'nim' => $bio->nim,
                            'nama' => $bio->nama_lengkap,
                            'nama_cantik' => $bio->nama_cantik,
                            'jenis_kelamin' => $bio->jenis_kelamin,
                            'angkatan' => $bio->angkatan
                        ]
                    );
                }
            }
        }
        return $data;
    }
}
