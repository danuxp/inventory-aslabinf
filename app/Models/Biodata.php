<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Biodata extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_bio';
    protected $guarded = ['id_bio'];

    // public function kodeAsisten()
    // {
    //     return $this->belongsTo(KodeAsisten::class,'bio_id');
    // }

    // public function divisi(): HasOne 
    // {
    //     return $this->hasOne(Divisi::class)
    // }
}
