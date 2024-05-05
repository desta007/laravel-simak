<?php

namespace Database\Seeders;

use App\Models\Proyek;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyeks = [
            [
                'id_cabang' => 2,
                'nama' => 'Proyek A',
                'nomor_wo' => '110',
                'keterangan' => 'Default Proyek'
            ],
            [
                'id_cabang' => 3,
                'nama' => 'Proyek B',
                'nomor_wo' => '120',
                'keterangan' => 'Default Proyek'
            ]
        ];

        foreach ($proyeks as $proyek) {
            Proyek::create($proyek);
        }
    }
}
