<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekeningBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cabang',
        'nama_bank',
        'kode_bank',
        'jenis_rekening',
        'nomor_rekening',
        'nama_rekening',
        'cabang_bank',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id');
    }

    /**
     * Segmen kode bukti: induk -> PST, operasional -> OPR
     */
    public function getSegmenBuktiAttribute(): string
    {
        return $this->jenis_rekening === 'induk' ? 'PST' : 'OPR';
    }
}
