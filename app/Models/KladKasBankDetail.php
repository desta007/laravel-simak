<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KladKasBankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_klad_kas_bank',
        'id_kode_perkiraan',
        'jenis',
        'kategori',
        'jumlah',
    ];

    public function kladKasBank(): BelongsTo
    {
        return $this->belongsTo(KladKasBank::class, 'id_klad_kas_bank', 'id');
    }

    public function kodePerkiraan(): BelongsTo
    {
        return $this->belongsTo(KodePerkiraan::class, 'id_kode_perkiraan', 'id');
    }
}
