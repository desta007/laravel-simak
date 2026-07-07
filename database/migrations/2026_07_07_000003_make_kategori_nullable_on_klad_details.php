<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Input kini jurnal langsung D/K; kolom kategori tidak lagi wajib.
        DB::statement('ALTER TABLE klad_kas_bank_details MODIFY kategori VARCHAR(255) NULL');
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE klad_kas_bank_details MODIFY kategori VARCHAR(255) NOT NULL DEFAULT ''");
    }
};
