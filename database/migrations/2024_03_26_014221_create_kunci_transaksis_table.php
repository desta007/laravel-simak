<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunci_transaksis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cabang');
            $table->integer('id_proyek')->default(0);
            $table->string('bulan');
            $table->year('tahun');
            $table->integer('status_akses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunci_transaksis');
    }
};
