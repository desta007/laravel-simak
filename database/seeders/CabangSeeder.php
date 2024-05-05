<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cabangs = [
            [
                'kode' => '000',
                'nama' => 'KANTOR PUSAT',
                'keterangan' => 'Default'
            ],
            [
                'kode' => '010',
                'nama' => 'PT. SURYA ARTO MORO',
                'keterangan' => 'Default'
            ],
            [
                'kode' => '020',
                'nama' => 'CV. NIMO PERKASA ABADI',
                'keterangan' => 'Default'
            ]
        ];

        foreach ($cabangs as $cabang) {
            Cabang::create($cabang);
        }
    }
}
