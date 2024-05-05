<?php

namespace Database\Seeders;

use App\Models\UserProyek;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProyekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userProyeks = [
            [
                'id_user' => 5,
                'id_proyek' => 1
            ],
            [
                'id_user' => 6,
                'id_proyek' => 2
            ]
        ];

        foreach ($userProyeks as $userProyek) {
            UserProyek::create($userProyek);
        }
    }
}
