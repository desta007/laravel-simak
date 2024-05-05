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
        Schema::create('kode_perkiraans', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cabang');
            $table->integer('id_group_account');
            $table->integer('id_proyek')->default(0);
            $table->string('kode');
            $table->string('nama');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_perkiraans');
    }
};
