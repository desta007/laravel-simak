<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaksi',
        'id_kode_perkiraan',
        'jumlah',
        'jenis'
    ];

    public function kodePerkiraan(): BelongsTo
    {
        return $this->belongsTo(KodePerkiraan::class, 'id_kode_perkiraan', 'id');
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
    }
}
