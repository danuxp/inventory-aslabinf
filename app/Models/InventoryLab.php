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

    public function joinNamalab($id = false)
    {
        $query = DB::table('inventory_labs as invlab')
            ->join('nama_labs as nmlab', 'invlab.lab_id', '=', 'nmlab.id')
            ->select('invlab.*', 'nmlab.nama');
        if ($id !== false) {
            $query->where('invlab.id', $id);
        }
        return $query->get();
    }
}
