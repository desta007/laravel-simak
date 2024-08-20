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
        Schema::create('saldo_akuns', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kode_perkiraan');
            $table->string('bulan')->nullable();
            $table->year('tahun');
            $table->bigInteger('saldo_debet');
            $table->bigInteger('saldo_kredit');
            $table->integer('is_saldo_awal')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldo_akuns');
    }
};
