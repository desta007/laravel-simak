<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('klad_kas_banks', function (Blueprint $table) {
            $table->string('alamat')->nullable()->after('pihak_terkait');
            $table->string('berupa')->nullable()->after('alamat');   // TUNAI | CHEQUE | ONLINE | TRANSFER
            $table->string('catatan')->nullable()->after('berupa');
        });

        // Kas/Bank kini menjadi baris jurnal manual, jadi kolom ini tidak lagi wajib.
        // Tanpa doctrine/dbal, gunakan raw ALTER (MySQL).
        DB::statement('ALTER TABLE klad_kas_banks MODIFY id_kode_perkiraan_kas_bank BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        Schema::table('klad_kas_banks', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'berupa', 'catatan']);
        });

        DB::statement('ALTER TABLE klad_kas_banks MODIFY id_kode_perkiraan_kas_bank BIGINT UNSIGNED NOT NULL');
    }
};
