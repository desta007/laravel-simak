<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klad_kas_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cabang');
            $table->unsignedBigInteger('id_proyek')->default(0);
            $table->string('jenis'); // kas atau bank
            $table->string('jenis_transaksi'); // pengeluaran atau penerimaan
            $table->unsignedBigInteger('id_rekening_bank')->nullable();
            $table->unsignedBigInteger('id_kode_bukti');
            $table->unsignedBigInteger('id_kode_perkiraan_kas_bank');
            $table->date('tgl');
            $table->string('no_bukti');
            $table->integer('no_urut_bukti');
            $table->string('pihak_terkait')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->timestamps();

            $table->foreign('id_cabang')->references('id')->on('cabangs')->onDelete('cascade');
            $table->foreign('id_rekening_bank')->references('id')->on('rekening_banks')->onDelete('set null');
            $table->foreign('id_kode_bukti')->references('id')->on('kode_buktis')->onDelete('cascade');
        });

        Schema::create('klad_kas_bank_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_klad_kas_bank');
            $table->unsignedBigInteger('id_kode_perkiraan');
            $table->string('jenis'); // D atau K
            $table->string('kategori'); // detail, ppn, pph, pot_um, pot_retensi, pot_lain, biaya_lain, kas_bank
            $table->double('jumlah');
            $table->timestamps();

            $table->foreign('id_klad_kas_bank')->references('id')->on('klad_kas_banks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klad_kas_bank_details');
        Schema::dropIfExists('klad_kas_banks');
    }
};
