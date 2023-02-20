<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class PjLab extends Model
{
    use HasFactory;
    protected $fillable = ['nim', 'lab_id', 'status'];

    public function joinData()
    {
        $query = DB::table('pj_labs')
        ->select('biodatas.*', 'nama_labs.nama as nama_lab, nama_labs.id')
        ->join('biodatas', 'biodatas.nim = pj_labs.nim')
        ->join('nama_labs', 'nama_labs.id = pj_labs.lab_id')
        ->get();
        return $query;
    }

}