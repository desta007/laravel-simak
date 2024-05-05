<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'nama',
        'jenis'
    ];
}
