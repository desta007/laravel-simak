<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KladKasBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cabang',
        'id_proyek',
        'jenis',
        'jenis_transaksi',
        'id_rekening_bank',
        'id_kode_bukti',
        'id_kode_perkiraan_kas_bank',
        'tgl',
        'no_bukti',
        'no_urut_bukti',
        'pihak_terkait',
        'keterangan',
        'file_dokumen',
    ];

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id');
    }

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class, 'id_proyek', 'id');
    }

    public function rekeningBank(): BelongsTo
    {
        return $this->belongsTo(RekeningBank::class, 'id_rekening_bank', 'id');
    }

    public function kodebukti(): BelongsTo
    {
        return $this->belongsTo(KodeBukti::class, 'id_kode_bukti', 'id');
    }

    public function kodePerkiraan(): BelongsTo
    {
        return $this->belongsTo(KodePerkiraan::class, 'id_kode_perkiraan_kas_bank', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(KladKasBankDetail::class, 'id_klad_kas_bank', 'id');
    }
}
