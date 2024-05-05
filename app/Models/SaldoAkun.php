<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaldoAkun extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kode_perkiraan',
        'bulan',
        'tahun',
        'saldo_debet',
        'saldo_kredit',
        'is_saldo_awal'
    ];

    public function kodePerkiraan(): BelongsTo
    {
        return $this->belongsTo(KodePerkiraan::class, 'id_kode_perkiraan', 'id');
    }
}
