<?php

namespace Database\Seeders;

use App\Models\KodeBukti;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KodeBuktiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kodeBuktis = [
            [
                'kode' => 'BJB',
                'nama' => 'Bank Jabar Banten',
                'keterangan' => 'Bank Jabar Banten'
            ],
            [
                'kode' => 'BMA',
                'nama' => 'Bank Mandiri',
                'keterangan' => 'Bank Mandiri'
            ],
            [
                'kode' => 'BME',
                'nama' => 'Bank Mega',
                'keterangan' => 'Bank Mega'
            ],
            [
                'kode' => 'BMG',
                'nama' => 'Bank Mandiri Giro',
                'keterangan' => 'Bank Mandiri Giro'
            ],
            [
                'kode' => 'BNI',
                'nama' => 'Bank Negara Indonesia',
                'keterangan' => 'Bank Negara Indonesia'
            ],
            [
                'kode' => 'BPM',
                'nama' => 'Bank Permata',
                'keterangan' => 'Bank Permata'
            ],
            [
                'kode' => 'BRI',
                'nama' => 'Bank Rakyat Indonesia',
                'keterangan' => 'Bank Rakyat Indonesia'
            ],
            [
                'kode' => 'BSP',
                'nama' => 'Bank Syariah Bukopin',
                'keterangan' => 'Bank Syariah Bukopin'
            ],
            [
                'kode' => 'BTN',
                'nama' => 'Bank Tabungan Negara',
                'keterangan' => 'Bank Tabungan Negara'
            ],
            [
                'kode' => 'KAN',
                'nama' => 'Koreksi Audit',
                'keterangan' => ' Koreksi Audit Jurnal AJE/CAJE'
            ],
            [
                'kode' => 'KAS',
                'nama' => 'Kas Kantor',
                'keterangan' => 'Kas Kantor'
            ],
            [
                'kode' => 'MPK',
                'nama' => 'Koreksi',
                'keterangan' => 'Koreksi Perkiraan, Pembukuan'
            ],
            [
                'kode' => 'MPP',
                'nama' => 'Penjualan',
                'keterangan' => 'Membuku Penagihan Piutang'
            ],
            [
                'kode' => 'PMB',
                'nama' => 'Utang',
                'keterangan' => 'Membuku Utang'
            ],
            [
                'kode' => 'TBM',
                'nama' => 'Bank Mandiri Tabungan Bisnis',
                'keterangan' => 'Bank Mandiri Tabungan Bisnis'
            ],
        ];

        foreach ($kodeBuktis as $kodeBukti) {
            KodeBukti::create($kodeBukti);
        }
    }
}
