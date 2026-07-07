<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekening_banks', function (Blueprint $table) {
            // 'induk' | 'operasional' -> menentukan segmen bukti PST/OPR
            $table->string('jenis_rekening')->default('operasional')->after('kode_bank');
        });
    }

    public function down(): void
    {
        Schema::table('rekening_banks', function (Blueprint $table) {
            $table->dropColumn('jenis_rekening');
        });
    }
};
