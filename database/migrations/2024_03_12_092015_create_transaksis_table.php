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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cabang');
            $table->integer('id_proyek')->default(0);
            $table->integer('id_kode_bukti');
            $table->date('tgl');
            $table->string('no_bukti');
            $table->string('no_urut_bukti');
            $table->string('no_urut_jurnal');
            $table->string('keterangan');
            $table->string('file_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
