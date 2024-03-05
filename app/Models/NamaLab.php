<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NamaLab extends Model
{
    use HasFactory;
    protected $fillable = ['nama'];

    public function inventory_lab(): HasOne
    {
        return $this->hasOne(InventoryLab::class, 'lab_id', 'id');
    }
}
