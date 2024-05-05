<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KodePerkiraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_cabang',
        'id_group_account',
        'id_proyek',
        'kode',
        'nama',
        'keterangan'
    ];

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id');
    }

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class, 'id_proyek', 'id');
    }

    public function groupaccount(): BelongsTo
    {
        return $this->belongsTo(GroupAccount::class, 'id_group_account', 'id');
    }
}
