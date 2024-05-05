<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatatanMutu extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_dokumen',
        'nama_dokumen',
        'file_dokumen',
        'id_proyek'
    ];

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class, 'id_proyek', 'id');
    }
}
