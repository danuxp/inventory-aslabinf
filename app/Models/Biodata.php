<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_bio';
    protected $guarded = ['id_bio'];

    // public function kodeAsisten()
    // {
    //     return $this->belongsTo(KodeAsisten::class,'bio_id');
    // }
}