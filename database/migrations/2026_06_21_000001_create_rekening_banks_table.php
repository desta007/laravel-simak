<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekening_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cabang');
            $table->string('nama_bank');
            $table->string('kode_bank');
            $table->string('nomor_rekening');
            $table->string('nama_rekening');
            $table->string('cabang_bank')->nullable();
            $table->string('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('id_cabang')->references('id')->on('cabangs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekening_banks');
    }
};
