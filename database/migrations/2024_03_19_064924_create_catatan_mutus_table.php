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
        Schema::create('catatan_mutus', function (Blueprint $table) {
            $table->id();
            $table->string('no_dokumen');
            $table->string('nama_dokumen');
            $table->string('file_dokumen');
            $table->integer('id_proyek');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_mutus');
    }
};
