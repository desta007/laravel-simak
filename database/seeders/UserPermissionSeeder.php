<?php

namespace Database\Seeders;

use App\Models\UserPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_permissions = [
            [
                'id_group_user' => '1',
                'nama_menu' => 'Master Cabang',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Master Proyek',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Master Manajemen User',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Master Kode Bukti',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Master Group Account',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Master Kode Perkiraan',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Setting Otorisasi Transaksi',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Transaksi Jurnal',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Proses Data Bulanan',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Proses Awal Tahun',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'General Ledger',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Buku Tambahan',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Laporan Posisi Keuangan/Neraca',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '1',
                'nama_menu' => 'Laporan Laba Rugi',
                'hak_akses' => 'admin'
            ],

            // 2
            [
                'id_group_user' => '2',
                'nama_menu' => 'Master Cabang',
                'hak_akses' => 'none'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Master Proyek',
                'hak_akses' => 'none'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Master Manajemen User',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Master Kode Bukti',
                'hak_akses' => 'read'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Master Group Account',
                'hak_akses' => 'read'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Master Kode Perkiraan',
                'hak_akses' => 'read'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Setting Otorisasi Transaksi',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Transaksi Jurnal',
                'hak_akses' => 'read'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Proses Data Bulanan',
                'hak_akses' => 'none'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Proses Awal Tahun',
                'hak_akses' => 'none'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'General Ledger',
                'hak_akses' => 'read'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Buku Tambahan',
                'hak_akses' => 'read'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Laporan Posisi Keuangan/Neraca',
                'hak_akses' => 'read'
            ],
            [
                'id_group_user' => '2',
                'nama_menu' => 'Laporan Laba Rugi',
                'hak_akses' => 'read'
            ],

            // 3
            [
                'id_group_user' => '3',
                'nama_menu' => 'Master Cabang',
                'hak_akses' => 'none'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Master Proyek',
                'hak_akses' => 'none'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Master Manajemen User',
                'hak_akses' => 'none'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Master Kode Bukti',
                'hak_akses' => 'none'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Master Group Account',
                'hak_akses' => 'none'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Master Kode Perkiraan',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Setting Otorisasi Transaksi',
                'hak_akses' => 'none'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Transaksi Jurnal',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Proses Data Bulanan',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Proses Awal Tahun',
                'hak_akses' => 'admin'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'General Ledger',
                'hak_akses' => 'read'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Buku Tambahan',
                'hak_akses' => 'read'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Laporan Posisi Keuangan/Neraca',
                'hak_akses' => 'read'
            ],
            [
                'id_group_user' => '3',
                'nama_menu' => 'Laporan Laba Rugi',
                'hak_akses' => 'read'
            ],
        ];

        foreach ($user_permissions as $perm) {
            UserPermission::create($perm);
        }
    }
}
