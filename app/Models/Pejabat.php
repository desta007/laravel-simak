<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'is_active',
        'is_ttd_laporan_neraca',
        'is_ttd_laporan_labarugi'
    ];
}
