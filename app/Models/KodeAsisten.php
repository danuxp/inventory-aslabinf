<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KodeAsisten extends Model
{
    use HasFactory;
    protected $fillable = ['kd_asisten', 'bio_id'];

    public function biodata()
    {
        return $this->belongsTo(Biodata::class, 'bio_id');
    }

    public function joinBiodata()
    {
        $query = DB::table('kode_asistens')
        ->join('biodatas', 'kode_asistens.bio_id', '=', 'biodatas.id_bio')
        ->select('kode_asistens.*', 'biodatas.nim', 'biodatas.nama_lengkap', 'biodatas.no_wa')
        ->get();
        return $query;
    }

    public function getJoinBio($id = '')
    {
        $query = DB::table('kode_asistens')
        ->join('biodatas', 'kode_asistens.bio_id', '=', 'biodatas.id_bio')
        ->select('kode_asistens.*', 'biodatas.nim', 'biodatas.nama_lengkap', 'biodatas.no_wa')
        ->where('kode_asistens.id', $id)
        ->get();
        return $query;
    }

}