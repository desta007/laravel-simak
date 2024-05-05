<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cabang',
        'id_proyek',
        'id_kode_bukti',
        'tgl',
        'no_urut_bukti',
        'no_bukti',
        'no_urut_jurnal',
        'keterangan',
        'file_dokumen'
    ];

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id');
    }

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class, 'id_proyek', 'id');
    }

    public function kodebukti(): BelongsTo
    {
        return $this->belongsTo(KodeBukti::class, 'id_kode_bukti', 'id');
    }

    public function transaksiDetail(): HasMany
    {
        return $this->hasMany(TransaksiDetail::class, 'id_transaksi', 'id');
    }
}
