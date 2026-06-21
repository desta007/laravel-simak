<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class MigrateKladKasBank extends Command
{
    protected $signature = 'migrate:klad-kas-bank';

    protected $description = 'Migrate tabel rekening_banks, klad_kas_banks, dan klad_kas_bank_details';

    public function handle()
    {
        // 1. Tabel rekening_banks
        if (Schema::hasTable('rekening_banks')) {
            $this->info('Tabel rekening_banks sudah ada, dilewati.');
        } else {
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
            $this->info('Tabel rekening_banks berhasil dibuat.');
        }

        // 2. Tabel klad_kas_banks
        if (Schema::hasTable('klad_kas_banks')) {
            $this->info('Tabel klad_kas_banks sudah ada, dilewati.');
        } else {
            Schema::create('klad_kas_banks', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_cabang');
                $table->unsignedBigInteger('id_proyek')->default(0);
                $table->enum('jenis', ['kas', 'bank']);
                $table->enum('jenis_transaksi', ['pengeluaran', 'penerimaan']);
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
                $table->foreign('id_kode_perkiraan_kas_bank')->references('id')->on('kode_perkiraans')->onDelete('cascade');
            });
            $this->info('Tabel klad_kas_banks berhasil dibuat.');
        }

        // 3. Tabel klad_kas_bank_details
        if (Schema::hasTable('klad_kas_bank_details')) {
            $this->info('Tabel klad_kas_bank_details sudah ada, dilewati.');
        } else {
            Schema::create('klad_kas_bank_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_klad_kas_bank');
                $table->unsignedBigInteger('id_kode_perkiraan');
                $table->enum('jenis', ['D', 'K']);
                $table->string('kategori');
                $table->double('jumlah');
                $table->timestamps();

                $table->foreign('id_klad_kas_bank')->references('id')->on('klad_kas_banks')->onDelete('cascade');
                $table->foreign('id_kode_perkiraan')->references('id')->on('kode_perkiraans')->onDelete('cascade');
            });
            $this->info('Tabel klad_kas_bank_details berhasil dibuat.');
        }

        $this->info('');
        $this->info('Selesai! Semua tabel klad kas bank sudah siap.');
    }
}
