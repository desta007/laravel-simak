<?php

namespace Database\Seeders;

use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::create(
        $listUsers = [
            [
                'name' => 'Desta CP',
                'email' => 'detajuventini@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'id_group_user' => 1,
                'id_cabang' => null,
                'phone' => '082190319325',
                'alamat' => 'Jakarta',
                'photo' => 'untitled.png'
            ],
            [
                'name' => 'Admin Kantor Pusat',
                'email' => 'cabangpusat@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'id_group_user' => 2,
                'id_cabang' => 1,
                'phone' => '-',
                'alamat' => 'Jakarta',
                'photo' => 'untitled.png'
            ],
            [
                'name' => 'Admin Cabang SAM',
                'email' => 'cabangsam@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'id_group_user' => 2,
                'id_cabang' => 2,
                'phone' => '-',
                'alamat' => 'Jakarta',
                'photo' => 'untitled.png'
            ],
            [
                'name' => 'Admin Cabang Nimo',
                'email' => 'cabangnimo@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'id_group_user' => 2,
                'id_cabang' => 3,
                'phone' => '-',
                'alamat' => 'Jakarta',
                'photo' => 'untitled.png'
            ],
            [
                'name' => 'Staf Proyek A',
                'email' => 'stafproyeka@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'id_group_user' => 3,
                'id_cabang' => 2,
                'phone' => '-',
                'alamat' => 'Jakarta',
                'photo' => 'untitled.png'
            ],
            [
                'name' => 'Staf Proyek B',
                'email' => 'stafproyekb@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'id_group_user' => 3,
                'id_cabang' => 3,
                'phone' => '-',
                'alamat' => 'Jakarta',
                'photo' => 'untitled.png'
            ]
        ];

        foreach ($listUsers as $listUser) {
            User::create($listUser);
        }

        $groupUsers = [
            [
                'nama' => 'Admin'
            ],
            [
                'nama' => 'Staff Cabang'
            ],
            [
                'nama' => 'Staff Proyek'
            ]
        ];

        foreach ($groupUsers as $groupUser) {
            GroupUser::create($groupUser);
        }
    }
}
