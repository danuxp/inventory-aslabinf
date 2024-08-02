<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class InventoryLab extends Model
{
    use HasFactory;
    protected $fillable = ['lab_id', 'barang'];

    public function lab(): BelongsTo
    {
        return $this->belongsTo(NamaLab::class);
    }
}
