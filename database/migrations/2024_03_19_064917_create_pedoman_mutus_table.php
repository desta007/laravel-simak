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
        Schema::create('pedoman_mutus', function (Blueprint $table) {
            $table->id();
            $table->string('no_dokumen');
            $table->string('nama_dokumen');
            $table->string('file_dokumen');
            $table->string('tipe_dokumen');
            $table->integer('id_proyek')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedoman_mutus');
    }
};
