<?php

namespace Database\Seeders;

use App\Models\KodePerkiraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KodePerkiraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kodePerkiraans = [
            // pusat
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 1,
                'kode' => '100.000.0000',
                'nama' => 'Kas Kantor Pusat',
                'keterangan' => 'Kas Kantor Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 2,
                'kode' => '101.000.0000',
                'nama' => 'Kas Pelaksana Kantor Pusat',
                'keterangan' => 'Kas Pelaksana Kantor Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 6,
                'kode' => '110.000.0000',
                'nama' => 'Bank Mandiri Pusat',
                'keterangan' => 'Bank Mandiri Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 7,
                'kode' => '111.000.0000',
                'nama' => 'BNI Pusat',
                'keterangan' => 'BNI Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 11,
                'kode' => '115.000.0000',
                'nama' => 'BPD Pusat',
                'keterangan' => 'BPD Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 12,
                'kode' => '116.000.0000',
                'nama' => 'BRI Pusat',
                'keterangan' => 'BRI Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 15,
                'kode' => '119.000.0000',
                'nama' => 'BSI Pusat',
                'keterangan' => 'BSI Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 16,
                'kode' => '11A.000.0000',
                'nama' => 'BII Pusat',
                'keterangan' => 'BII Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 17,
                'kode' => '11B.000.0000',
                'nama' => 'BCA Pusat',
                'keterangan' => 'BCA Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 18,
                'kode' => '11C.000.0000',
                'nama' => 'Bank CIMB Niaga Pusat',
                'keterangan' => 'Bank CIMB Niaga Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 19,
                'kode' => '11D.000.0000',
                'nama' => 'Bank Tabungan Negara Pusat',
                'keterangan' => 'Bank Tabungan Negara Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 20,
                'kode' => '11E.000.0000',
                'nama' => 'Bank Bukopin Pusat',
                'keterangan' => 'Bank Bukopin Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 22,
                'kode' => '11G.000.0000',
                'nama' => 'Bank Finconesia Pusat',
                'keterangan' => 'Bank Finconesia Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 23,
                'kode' => '11H.000.0000',
                'nama' => 'Bank Danamon Pusat',
                'keterangan' => 'Bank Danamon Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 25,
                'kode' => '11J.000.0000',
                'nama' => 'Bank Permata Pusat',
                'keterangan' => 'Bank Permata Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 26,
                'kode' => '11K.000.0000',
                'nama' => 'Bank Panin Pusat',
                'keterangan' => 'Bank Panin Rekening Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 27,
                'kode' => '120.000.0000',
                'nama' => 'Piutang Pekerjaan',
                'keterangan' => 'Piutang Pekerjaan'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 28,
                'kode' => '121.000.0000',
                'nama' => 'Piutang Retensi Pekerjaan',
                'keterangan' => 'Piutang Retensi Pekerjaan'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 29,
                'kode' => '122.000.0000',
                'nama' => 'Uang Muka Leveransir',
                'keterangan' => 'Uang Muka Leveransir'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 30,
                'kode' => '123.000.0000',
                'nama' => 'Uang Muka Sub Kontraktor',
                'keterangan' => 'Uang Muka Sub Kontraktor'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 31,

                'kode' => '124.000.0000',
                'nama' => 'Panjar Pelaksana',
                'keterangan' => 'Panjar Pelaksana'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 32,

                'kode' => '125.000.0000',
                'nama' => 'Piutang Jaminan',
                'keterangan' => 'Piutang Jaminan'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 33,

                'kode' => '126.000.0000',
                'nama' => 'Piutang Pegawai',
                'keterangan' => 'Piutang Pegawai'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 34,

                'kode' => '127.000.0000',
                'nama' => 'Piutang Joint Operation',
                'keterangan' => 'Piutang Joint Operation'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 35,

                'kode' => '128.000.0000',
                'nama' => 'Piutang Lain-Lain',
                'keterangan' => 'Piutang Lain-Lain'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 36,

                'kode' => '129.000.0000',
                'nama' => 'Penyisihan Piutang',
                'keterangan' => 'Penyisihan Piutang'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 37,

                'kode' => '12C.000.0000',
                'nama' => 'Piutang PPN',
                'keterangan' => 'Piutang PPN'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 38,

                'kode' => '130.000.0000',
                'nama' => 'PPH Badan Untuk Tahun Lalu',
                'keterangan' => 'PPH Badan Untuk Tahun Lalu'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 39,

                'kode' => '131.000.0000',
                'nama' => 'PPH Final',
                'keterangan' => 'PPH Final'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 40,

                'kode' => '132.000.0000',
                'nama' => 'PPH Pasal 22',
                'keterangan' => 'PPH Pasal 22'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 41,

                'kode' => '133.000.0000',
                'nama' => 'PPH Pasal 23',
                'keterangan' => 'PPH Pasal 23'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 42,

                'kode' => '134.000.0000',
                'nama' => 'PPH Pasal 24',
                'keterangan' => 'PPH Pasal 24'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 42,

                'kode' => '134.000.0000',
                'nama' => 'PPH Pasal 24',
                'keterangan' => 'PPH Pasal 24'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 43,

                'kode' => '135.000.0000',
                'nama' => 'PPH Pasal 25',
                'keterangan' => 'PPH Pasal 25'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 44,

                'kode' => '136.000.0000',
                'nama' => 'PPN Atas Uang Muka',
                'keterangan' => 'PPN Atas Uang Muka'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 45,

                'kode' => '137.000.0000',
                'nama' => 'Pajak Masukan (PM)',
                'keterangan' => 'Pajak Masukan (PM)'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 46,

                'kode' => '138.000.0000',
                'nama' => 'Piutang PPN',
                'keterangan' => 'Piutang PPN'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 47,

                'kode' => '139.000.0000',
                'nama' => 'PPH Pasal 29',
                'keterangan' => 'PPH Pasal 29'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 48,

                'kode' => '13A.000.0000',
                'nama' => 'PM Untuk PPN Yg Belum Terbit FP',
                'keterangan' => 'PM Untuk PPN Yg Belum Terbit FP'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 49,

                'kode' => '140.000.0000',
                'nama' => 'Persediaan Bahan / Material',
                'keterangan' => 'Persediaan Bahan / Material'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 50,

                'kode' => '141.000.0000',
                'nama' => 'Persediaan Spareparts / Suku Cadang',
                'keterangan' => 'Persediaan Spareparts / Suku Cadang'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 51,

                'kode' => '142.000.0000',
                'nama' => 'Koreksi Persediaan Bahan',
                'keterangan' => 'Koreksi Persediaan Bahan'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 52,

                'kode' => '143.000.0000',
                'nama' => 'Koreksi Persediaan Spareparts',
                'keterangan' => 'Koreksi Persediaan Spareparts'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 53,

                'kode' => '144.000.0000',
                'nama' => 'Perbedaan Harga Bahan',
                'keterangan' => 'Perbedaan Harga Bahan'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 54,

                'kode' => '145.000.0000',
                'nama' => 'Bangunan Dalam Proses',
                'keterangan' => 'Bangunan Dalam Proses'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 55,

                'kode' => '146.000.0000',
                'nama' => 'Bangunan Selesai',
                'keterangan' => 'Bangunan Selesai'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 56,

                'kode' => '147.000.0000',
                'nama' => 'Persediaan AMP',
                'keterangan' => 'Persediaan AMP'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 57,

                'kode' => '148.000.0000',
                'nama' => 'Persediaan Bahan Batching Plant',
                'keterangan' => 'Persediaan Bahan Batching Plant'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 58,

                'kode' => '150.000.0000',
                'nama' => 'PDP. Kontrak Induk',
                'keterangan' => 'PDP. Kontrak Induk'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 59,

                'kode' => '151.000.0000',
                'nama' => 'PDP. Kontrak Tambah',
                'keterangan' => 'PDP. Kontrak Tambah'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 60,

                'kode' => '152.000.0000',
                'nama' => 'PDP. Eskalasi',
                'keterangan' => 'PDP. Eskalasi'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 61,

                'kode' => '153.000.0000',
                'nama' => 'PDP. Selisih Kurs',
                'keterangan' => 'PDP. Selisih Kurs'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 62,

                'kode' => '160.000.0000',
                'nama' => 'Biaya Yg Dibayar Dimuka',
                'keterangan' => 'Biaya Yg Dibayar Dimuka'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 63,

                'kode' => '161.000.0000',
                'nama' => 'Pendapatan Yg Akan Diterima',
                'keterangan' => 'Pendapatan Yg Akan Diterima'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 64,

                'kode' => '162.000.0000',
                'nama' => 'Uang Muka Pembagian Laba',
                'keterangan' => 'Uang Muka Pembagian Laba'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 65,

                'kode' => '163.000.0000',
                'nama' => 'Rumah & Bangunan Yg Disewakan',
                'keterangan' => 'Rumah & Bangunan Yg Disewakan'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 66,

                'kode' => '164.000.0000',
                'nama' => 'Piutang Jangka Panjang',
                'keterangan' => 'Piutang Jangka Panjang'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 67,

                'kode' => '170.000.0000',
                'nama' => 'Penyertaan Saham',
                'keterangan' => 'Penyertaan Saham'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 68,

                'kode' => '171.000.0000',
                'nama' => 'Piutang Pemegang Saham',
                'keterangan' => 'Piutang Pemegang Saham'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 69,

                'kode' => '172.000.0000',
                'nama' => 'Inv. Pada Ventura Bersama',
                'keterangan' => 'Inv. Pada Ventura Bersama'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 70,

                'kode' => '180.000.0000',
                'nama' => 'Tanah',
                'keterangan' => 'Tanah'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 71,

                'kode' => '181.000.0000',
                'nama' => 'Gedung',
                'keterangan' => 'Gedung'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 72,

                'kode' => '182.000.0000',
                'nama' => 'Mesin / Alat',
                'keterangan' => 'Mesin / Alat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 73,

                'kode' => '183.000.0000',
                'nama' => 'Alat Angkut / Kendaraan',
                'keterangan' => 'Alat Angkut / Kendaraan'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 74,

                'kode' => '184.000.0000',
                'nama' => 'Kantor',
                'keterangan' => 'Kantor'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 75,

                'kode' => '185.000.0000',
                'nama' => 'Mess',
                'keterangan' => 'Mess'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 79,

                'kode' => '190.000.0000',
                'nama' => 'Hak Pengelolaan',
                'keterangan' => 'Hak Pengelolaan'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 81,

                'kode' => '1A0.000.0000',
                'nama' => 'Hak Patent',
                'keterangan' => 'Hak Patent'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 95,

                'kode' => '1B9.000.0000',
                'nama' => 'Aktiva Lain-Lain',
                'keterangan' => 'Aktiva Lain-Lain'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 98,

                'kode' => '200.000.0000',
                'nama' => 'Utang Pada Leveransir',
                'keterangan' => 'Utang Pada Leveransir'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 99,

                'kode' => '201.000.0000',
                'nama' => 'Utang Pada Sub Kontraktor',
                'keterangan' => 'Utang Pada Sub Kontraktor'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 100,

                'kode' => '202.000.0000',
                'nama' => 'Uang Muka Bowheer',
                'keterangan' => 'Uang Muka Bowheer'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 101,

                'kode' => '203.000.0000',
                'nama' => 'Utang Deviden / DPS',
                'keterangan' => 'Utang Deviden / DPS'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 102,

                'kode' => '204.000.0000',
                'nama' => 'Utang Tantiem',
                'keterangan' => 'Utang Tantiem'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 103,

                'kode' => '205.000.0000',
                'nama' => 'Utang Leasing',
                'keterangan' => 'Utang Leasing'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 104,

                'kode' => '206.000.0000',
                'nama' => 'Utang Jangka Panjang Lain Yg Lancar',
                'keterangan' => 'Utang Jangka Panjang Lain Yg Lancar'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 105,

                'kode' => '207.000.0000',
                'nama' => 'Utang Astek / THT',
                'keterangan' => 'Utang Astek / THT'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 106,

                'kode' => '208.000.0000',
                'nama' => 'Utang Dana Jasa Produksi',
                'keterangan' => 'Utang Dana Jasa Produksi'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 107,

                'kode' => '209.000.0000',
                'nama' => 'Utang Lain-Lain',
                'keterangan' => 'Utang Lain-Lain'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 108,

                'kode' => '20A.000.0000',
                'nama' => 'Utang PPN Leveransir',
                'keterangan' => 'Utang PPN Leveransir'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 129,

                'kode' => '221.000.0000',
                'nama' => 'PPH Pasal 21',
                'keterangan' => 'PPH Pasal 21'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 130,

                'kode' => '222.000.0000',
                'nama' => 'PPH Pasal 22',
                'keterangan' => 'PPH Pasal 22'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 131,

                'kode' => '223.000.0000',
                'nama' => 'PPH Pasal 23',
                'keterangan' => 'PPH Pasal 23'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 132,

                'kode' => '224.000.0000',
                'nama' => 'PPN Yang Dihitung',
                'keterangan' => 'PPN Yang Dihitung'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 133,

                'kode' => '225.000.0000',
                'nama' => 'PPH Pasal 25',
                'keterangan' => 'PPH Pasal 25'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 134,

                'kode' => '226.000.0000',
                'nama' => 'PPH Pasal 26',
                'keterangan' => 'PPH Pasal 26'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 135,

                'kode' => '227.000.0000',
                'nama' => 'Pajak Keluaran',
                'keterangan' => 'Pajak Keluaran'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 136,

                'kode' => '228.000.0000',
                'nama' => 'PPH Final Rekanan',
                'keterangan' => 'PPH Final Rekanan'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 137,

                'kode' => '229.000.0000',
                'nama' => 'Utang PPN',
                'keterangan' => 'Utang PPN'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 141,

                'kode' => '22D.000.0000',
                'nama' => 'Utang PPH Final',
                'keterangan' => 'Utang PPH Final'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 142,

                'kode' => '230.000.0000',
                'nama' => 'Biaya Yang Akan Dibayar',
                'keterangan' => 'Biaya Yang Akan Dibayar'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 143,

                'kode' => '231.000.0000',
                'nama' => 'Pendapatan Yg Diterima Dimuka',
                'keterangan' => 'Pendapatan Yg Diterima Dimuka'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 144,

                'kode' => '232.000.0000',
                'nama' => 'Hutang Bunga Bank',
                'keterangan' => 'Hutang Bunga Bank'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 145,

                'kode' => '233.000.0000',
                'nama' => 'Cadangan Insentif',
                'keterangan' => 'Cadangan Insentif'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 150,

                'kode' => '250.000.0000',
                'nama' => 'Hutang Bank',
                'keterangan' => 'Hutang Bank'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 160,

                'kode' => '260.000.0000',
                'nama' => 'Pos Silang Kas-Bank',
                'keterangan' => 'Pos Silang Kas-Bank'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 161,

                'kode' => '261.000.0000',
                'nama' => 'Pos Silang Antar Bank',
                'keterangan' => 'Pos Silang Antar Bank'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 162,

                'kode' => '262.000.0000',
                'nama' => 'Pos Silang Kas Pel.-Bank',
                'keterangan' => 'Pos Silang Kas Pel.-Bank'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 163,

                'kode' => '263.000.0000',
                'nama' => 'Pos Silang Bank-Kas Pel.',
                'keterangan' => 'Pos Silang Bank-Kas Pel.'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 166,

                'kode' => '271.000.0000',
                'nama' => 'R/K Cabang Dengan Kantor Pusat',
                'keterangan' => 'R/K Cabang Dengan Kantor Pusat'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 167,

                'kode' => '272.000.0000',
                'nama' => 'R/K Kantor Pusat Dengan Cabang',
                'keterangan' => 'R/K Kantor Pusat Dengan Cabang'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 173,

                'kode' => '300.000.0000',
                'nama' => 'Modal Dasar',
                'keterangan' => 'Modal Dasar'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 174,

                'kode' => '301.000.0000',
                'nama' => 'Agio / Disagio',
                'keterangan' => 'Agio / Disagio'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 175,

                'kode' => '302.000.0000',
                'nama' => 'Modal Dalam Pesanan',
                'keterangan' => 'Modal Dalam Pesanan'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 176,

                'kode' => '303.000.0000',
                'nama' => 'Cadangan',
                'keterangan' => 'Cadangan'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 179,

                'kode' => '306.000.0000',
                'nama' => 'Selisih Penilaian Aktiva',
                'keterangan' => 'Selisih Penilaian Aktiva'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 180,

                'kode' => '310.000.0000',
                'nama' => 'Saldo Laba Tahun Lalu',
                'keterangan' => 'Saldo Laba Tahun Lalu'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 181,

                'kode' => '320.000.0000',
                'nama' => 'Saldo Laba Tahun Berjalan',
                'keterangan' => 'Saldo Laba Tahun Berjalan'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 182,

                'kode' => '400.000.0000',
                'nama' => 'Pendapatan Usaha Konstruksi',
                'keterangan' => 'Pendapatan Usaha Konstruksi'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 187,

                'kode' => '410.000.0000',
                'nama' => 'Pendapatan Usaha Konstruksi JO',
                'keterangan' => 'Pendapatan Usaha Konstruksi JO'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 196,

                'kode' => '420.000.0000',
                'nama' => 'Hasil Penjualan Property',
                'keterangan' => 'Hasil Penjualan Property'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 197,

                'kode' => '430.000.0000',
                'nama' => 'Hasil Penjualan Barang / Trading',
                'keterangan' => 'Hasil Penjualan Barang / Trading'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 198,

                'kode' => '440.000.0000',
                'nama' => 'Hasil Usaha Sewa Property / Peralatan',
                'keterangan' => 'Hasil Usaha Sewa Property / Peralatan'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 199,

                'kode' => '500.000.0000',
                'nama' => 'Biaya Bahan',
                'keterangan' => 'Biaya Bahan'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 200,

                'kode' => '501.000.0000',
                'nama' => 'Biaya Upah',
                'keterangan' => 'Biaya Upah'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 201,

                'kode' => '502.000.0000',
                'nama' => 'Biaya Peralatan',
                'keterangan' => 'Biaya Peralatan'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 202,

                'kode' => '503.000.0000',
                'nama' => 'Biaya Sub Kontraktor',
                'keterangan' => 'Biaya Sub Kontraktor'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 203,

                'kode' => '504.000.0000',
                'nama' => 'Biaya Bank',
                'keterangan' => 'Biaya Bank'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 205,

                'kode' => '506.000.0000',
                'nama' => 'Biaya Penyusutan Aktiva Tetap',
                'keterangan' => 'Biaya Penyusutan Aktiva Tetap'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 206,

                'kode' => '507.000.0000',
                'nama' => 'Biaya Umum Kantor Pusat',
                'keterangan' => 'Biaya Umum Kantor Pusat'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 207,

                'kode' => '508.000.0000',
                'nama' => 'Biaya PPH Final',
                'keterangan' => 'Biaya PPH Final'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 235,

                'kode' => '600.000.0000',
                'nama' => 'Beban Pemasaran',
                'keterangan' => 'Beban Pemasaran'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 236,

                'kode' => '601.000.0000',
                'nama' => 'Gaji Pegawai',
                'keterangan' => 'Gaji Pegawai'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 237,

                'kode' => '602.000.0000',
                'nama' => 'Biaya Jasa Produksi',
                'keterangan' => 'Biaya Jasa Produksi'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 238,

                'kode' => '603.000.0000',
                'nama' => 'Perlengkapan Kantor',
                'keterangan' => 'Perlengkapan Kantor'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 239,

                'kode' => '604.000.0000',
                'nama' => 'Biaya Perjalanan Dinas',
                'keterangan' => 'Biaya Perjalanan Dinas'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 240,

                'kode' => '605.000.0000',
                'nama' => 'Biaya Pengembangan Sistem dan Usaha',
                'keterangan' => 'Biaya Pengembangan Sistem dan Usaha'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 241,

                'kode' => '606.000.0000',
                'nama' => 'Biaya Raker/Rakor',
                'keterangan' => 'Biaya Raker/Rakor'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 242,

                'kode' => '607.000.0000',
                'nama' => 'Penyusutan Gedung',
                'keterangan' => 'Penyusutan Gedung'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 243,

                'kode' => '700.000.0000',
                'nama' => 'Hasil Iuran Wajib',
                'keterangan' => 'Hasil Iuran Wajib'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 244,

                'kode' => '701.000.0000',
                'nama' => 'Hasil Lain-Lain',
                'keterangan' => 'Hasil Lain-Lain'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 247,

                'kode' => '704.000.0000',
                'nama' => 'Pendapatan Jasa Bunga',
                'keterangan' => 'Pendapatan Jasa Bunga'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 248,

                'kode' => '705.000.0000',
                'nama' => 'Pendapatan Sewa Gedung',
                'keterangan' => 'Pendapatan Sewa Gedung'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 249,

                'kode' => '710.000.0000',
                'nama' => 'Pendapatan Luar Biasa',
                'keterangan' => 'Pendapatan Luar Biasa'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 250,

                'kode' => '800.000.0000',
                'nama' => 'Biaya Adm dan Provisi Bank',
                'keterangan' => 'Biaya Adm dan Provisi Bank'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 251,

                'kode' => '801.000.0000',
                'nama' => 'Biaya Luar Biasa',
                'keterangan' => 'Biaya Luar Biasa'
            ], [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 254,

                'kode' => '804.000.0000',
                'nama' => 'Biaya Bunga Bank',
                'keterangan' => 'Biaya Bunga Bank'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 256,

                'kode' => '810.000.0000',
                'nama' => 'OCI - Selisih Penilaian Kembali Aset Tetap',
                'keterangan' => 'OCI - Selisih Penilaian Kembali Aset Tetap'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 258,

                'kode' => '830.000.0000',
                'nama' => 'Pajak PPH Badan',
                'keterangan' => 'Pajak PPH Badan'
            ],
            [
                'id_cabang' => 1,
                'id_proyek' => 0,
                'id_group_account' => 259,

                'kode' => '900.000.0000',
                'nama' => 'Laba / Rugi Tahun Berjalan',
                'keterangan' => 'Laba / Rugi Tahun Berjalan'
            ],

            // cabang SAM ------------------------
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 1,

                'kode' => '100.010.0000',
                'nama' => 'Kas Kantor',
                'keterangan' => 'Kas Kantor Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 2,

                'kode' => '101.010.0000',
                'nama' => 'Kas Pelaksana Kantor',
                'keterangan' => 'Kas Pelaksana Kantor Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 6,

                'kode' => '110.010.0000',
                'nama' => 'Bank Mandiri',
                'keterangan' => 'Bank Mandiri Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 7,

                'kode' => '111.010.0000',
                'nama' => 'BNI',
                'keterangan' => 'BNI Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 11,

                'kode' => '115.010.0000',
                'nama' => 'BPD',
                'keterangan' => 'BPD Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 12,

                'kode' => '116.010.0000',
                'nama' => 'BRI',
                'keterangan' => 'BRI Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 15,

                'kode' => '119.010.0000',
                'nama' => 'BSI',
                'keterangan' => 'BSI Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 16,

                'kode' => '11A.010.0000',
                'nama' => 'BII',
                'keterangan' => 'BII Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 17,

                'kode' => '11B.010.0000',
                'nama' => 'BCA',
                'keterangan' => 'BCA Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 18,

                'kode' => '11C.010.0000',
                'nama' => 'Bank CIMB Niaga',
                'keterangan' => 'Bank CIMB Niaga Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 19,

                'kode' => '11D.010.0000',
                'nama' => 'Bank Tabungan Negara',
                'keterangan' => 'Bank Tabungan Negara Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 20,

                'kode' => '11E.010.0000',
                'nama' => 'Bank Bukopin',
                'keterangan' => 'Bank Bukopin Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 22,

                'kode' => '11G.010.0000',
                'nama' => 'Bank Finconesia',
                'keterangan' => 'Bank Finconesia Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 23,

                'kode' => '11H.010.0000',
                'nama' => 'Bank Danamon',
                'keterangan' => 'Bank Danamon Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 25,

                'kode' => '11J.010.0000',
                'nama' => 'Bank Permata',
                'keterangan' => 'Bank Permata Rekening Cabangs'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 26,

                'kode' => '11K.010.0000',
                'nama' => 'Bank Panin',
                'keterangan' => 'Bank Panin Rekening Cabang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 27,

                'kode' => '120.010.0000',
                'nama' => 'Piutang Pekerjaan',
                'keterangan' => 'Piutang Pekerjaan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 28,

                'kode' => '121.010.0000',
                'nama' => 'Piutang Retensi Pekerjaan',
                'keterangan' => 'Piutang Retensi Pekerjaan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 29,

                'kode' => '122.010.0000',
                'nama' => 'Uang Muka Leveransir',
                'keterangan' => 'Uang Muka Leveransir'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 30,

                'kode' => '123.010.0000',
                'nama' => 'Uang Muka Sub Kontraktor',
                'keterangan' => 'Uang Muka Sub Kontraktor'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 31,

                'kode' => '124.010.0000',
                'nama' => 'Panjar Pelaksana',
                'keterangan' => 'Panjar Pelaksana'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 32,

                'kode' => '125.010.0000',
                'nama' => 'Piutang Jaminan',
                'keterangan' => 'Piutang Jaminan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 33,

                'kode' => '126.010.0000',
                'nama' => 'Piutang Pegawai',
                'keterangan' => 'Piutang Pegawai'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 34,

                'kode' => '127.010.0000',
                'nama' => 'Piutang Joint Operation',
                'keterangan' => 'Piutang Joint Operation'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 35,

                'kode' => '128.010.0000',
                'nama' => 'Piutang Lain-Lain',
                'keterangan' => 'Piutang Lain-Lain'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 36,

                'kode' => '129.010.0000',
                'nama' => 'Penyisihan Piutang',
                'keterangan' => 'Penyisihan Piutang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 37,

                'kode' => '12C.010.0000',
                'nama' => 'Piutang PPN',
                'keterangan' => 'Piutang PPN'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 38,

                'kode' => '130.010.0000',
                'nama' => 'PPH Badan Untuk Tahun Lalu',
                'keterangan' => 'PPH Badan Untuk Tahun Lalu'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 39,

                'kode' => '131.010.0000',
                'nama' => 'PPH Final',
                'keterangan' => 'PPH Final'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 40,

                'kode' => '132.010.0000',
                'nama' => 'PPH Pasal 22',
                'keterangan' => 'PPH Pasal 22'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 41,

                'kode' => '133.010.0000',
                'nama' => 'PPH Pasal 23',
                'keterangan' => 'PPH Pasal 23'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 42,

                'kode' => '134.010.0000',
                'nama' => 'PPH Pasal 24',
                'keterangan' => 'PPH Pasal 24'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 42,

                'kode' => '134.010.0000',
                'nama' => 'PPH Pasal 24',
                'keterangan' => 'PPH Pasal 24'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 43,

                'kode' => '135.010.0000',
                'nama' => 'PPH Pasal 25',
                'keterangan' => 'PPH Pasal 25'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 44,

                'kode' => '136.010.0000',
                'nama' => 'PPN Atas Uang Muka',
                'keterangan' => 'PPN Atas Uang Muka'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 45,

                'kode' => '137.010.0000',
                'nama' => 'Pajak Masukan (PM)',
                'keterangan' => 'Pajak Masukan (PM)'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 46,

                'kode' => '138.010.0000',
                'nama' => 'Piutang PPN',
                'keterangan' => 'Piutang PPN'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 47,

                'kode' => '139.010.0000',
                'nama' => 'PPH Pasal 29',
                'keterangan' => 'PPH Pasal 29'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 48,

                'kode' => '13A.010.0000',
                'nama' => 'PM Untuk PPN Yg Belum Terbit FP',
                'keterangan' => 'PM Untuk PPN Yg Belum Terbit FP'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 49,

                'kode' => '140.010.0000',
                'nama' => 'Persediaan Bahan / Material',
                'keterangan' => 'Persediaan Bahan / Material'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 50,

                'kode' => '141.010.0000',
                'nama' => 'Persediaan Spareparts / Suku Cadang',
                'keterangan' => 'Persediaan Spareparts / Suku Cadang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 51,

                'kode' => '142.010.0000',
                'nama' => 'Koreksi Persediaan Bahan',
                'keterangan' => 'Koreksi Persediaan Bahan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 52,

                'kode' => '143.010.0000',
                'nama' => 'Koreksi Persediaan Spareparts',
                'keterangan' => 'Koreksi Persediaan Spareparts'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 53,

                'kode' => '144.010.0000',
                'nama' => 'Perbedaan Harga Bahan',
                'keterangan' => 'Perbedaan Harga Bahan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 54,

                'kode' => '145.010.0000',
                'nama' => 'Bangunan Dalam Proses',
                'keterangan' => 'Bangunan Dalam Proses'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 55,

                'kode' => '146.010.0000',
                'nama' => 'Bangunan Selesai',
                'keterangan' => 'Bangunan Selesai'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 56,

                'kode' => '147.010.0000',
                'nama' => 'Persediaan AMP',
                'keterangan' => 'Persediaan AMP'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 57,

                'kode' => '148.010.0000',
                'nama' => 'Persediaan Bahan Batching Plant',
                'keterangan' => 'Persediaan Bahan Batching Plant'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 58,

                'kode' => '150.010.0000',
                'nama' => 'PDP. Kontrak Induk',
                'keterangan' => 'PDP. Kontrak Induk'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 59,

                'kode' => '151.010.0000',
                'nama' => 'PDP. Kontrak Tambah',
                'keterangan' => 'PDP. Kontrak Tambah'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 60,

                'kode' => '152.010.0000',
                'nama' => 'PDP. Eskalasi',
                'keterangan' => 'PDP. Eskalasi'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 61,

                'kode' => '153.010.0000',
                'nama' => 'PDP. Selisih Kurs',
                'keterangan' => 'PDP. Selisih Kurs'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 62,

                'kode' => '160.010.0000',
                'nama' => 'Biaya Yg Dibayar Dimuka',
                'keterangan' => 'Biaya Yg Dibayar Dimuka'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 63,

                'kode' => '161.010.0000',
                'nama' => 'Pendapatan Yg Akan Diterima',
                'keterangan' => 'Pendapatan Yg Akan Diterima'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 64,

                'kode' => '162.010.0000',
                'nama' => 'Uang Muka Pembagian Laba',
                'keterangan' => 'Uang Muka Pembagian Laba'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 65,

                'kode' => '163.010.0000',
                'nama' => 'Rumah & Bangunan Yg Disewakan',
                'keterangan' => 'Rumah & Bangunan Yg Disewakan'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 66,

                'kode' => '164.010.0000',
                'nama' => 'Piutang Jangka Panjang',
                'keterangan' => 'Piutang Jangka Panjang'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 67,

                'kode' => '170.010.0000',
                'nama' => 'Penyertaan Saham',
                'keterangan' => 'Penyertaan Saham'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 68,

                'kode' => '171.010.0000',
                'nama' => 'Piutang Pemegang Saham',
                'keterangan' => 'Piutang Pemegang Saham'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 69,

                'kode' => '172.010.0000',
                'nama' => 'Inv. Pada Ventura Bersama',
                'keterangan' => 'Inv. Pada Ventura Bersama'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 70,

                'kode' => '180.010.0000',
                'nama' => 'Tanah',
                'keterangan' => 'Tanah'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 71,

                'kode' => '181.010.0000',
                'nama' => 'Gedung',
                'keterangan' => 'Gedung'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 72,

                'kode' => '182.010.0000',
                'nama' => 'Mesin / Alat',
                'keterangan' => 'Mesin / Alat'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 73,

                'kode' => '183.010.0000',
                'nama' => 'Alat Angkut / Kendaraan',
                'keterangan' => 'Alat Angkut / Kendaraan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 74,

                'kode' => '184.010.0000',
                'nama' => 'Kantor',
                'keterangan' => 'Kantor'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 75,

                'kode' => '185.010.0000',
                'nama' => 'Mess',
                'keterangan' => 'Mess'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 79,

                'kode' => '190.010.0000',
                'nama' => 'Hak Pengelolaan',
                'keterangan' => 'Hak Pengelolaan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 81,

                'kode' => '1A0.010.0000',
                'nama' => 'Hak Patent',
                'keterangan' => 'Hak Patent'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 95,

                'kode' => '1B9.010.0000',
                'nama' => 'Aktiva Lain-Lain',
                'keterangan' => 'Aktiva Lain-Lain'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 98,

                'kode' => '200.010.0000',
                'nama' => 'Utang Pada Leveransir',
                'keterangan' => 'Utang Pada Leveransir'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 99,

                'kode' => '201.010.0000',
                'nama' => 'Utang Pada Sub Kontraktor',
                'keterangan' => 'Utang Pada Sub Kontraktor'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 100,

                'kode' => '202.010.0000',
                'nama' => 'Uang Muka Bowheer',
                'keterangan' => 'Uang Muka Bowheer'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 101,

                'kode' => '203.010.0000',
                'nama' => 'Utang Deviden / DPS',
                'keterangan' => 'Utang Deviden / DPS'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 102,

                'kode' => '204.010.0000',
                'nama' => 'Utang Tantiem',
                'keterangan' => 'Utang Tantiem'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 103,

                'kode' => '205.010.0000',
                'nama' => 'Utang Leasing',
                'keterangan' => 'Utang Leasing'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 104,

                'kode' => '206.010.0000',
                'nama' => 'Utang Jangka Panjang Lain Yg Lancar',
                'keterangan' => 'Utang Jangka Panjang Lain Yg Lancar'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 105,

                'kode' => '207.010.0000',
                'nama' => 'Utang Astek / THT',
                'keterangan' => 'Utang Astek / THT'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 106,

                'kode' => '208.010.0000',
                'nama' => 'Utang Dana Jasa Produksi',
                'keterangan' => 'Utang Dana Jasa Produksi'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 107,

                'kode' => '209.010.0000',
                'nama' => 'Utang Lain-Lain',
                'keterangan' => 'Utang Lain-Lain'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 108,

                'kode' => '20A.010.0000',
                'nama' => 'Utang PPN Leveransir',
                'keterangan' => 'Utang PPN Leveransir'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 129,

                'kode' => '221.010.0000',
                'nama' => 'PPH Pasal 21',
                'keterangan' => 'PPH Pasal 21'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 130,

                'kode' => '222.010.0000',
                'nama' => 'PPH Pasal 22',
                'keterangan' => 'PPH Pasal 22'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 131,

                'kode' => '223.010.0000',
                'nama' => 'PPH Pasal 23',
                'keterangan' => 'PPH Pasal 23'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 132,

                'kode' => '224.010.0000',
                'nama' => 'PPN Yang Dihitung',
                'keterangan' => 'PPN Yang Dihitung'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 133,

                'kode' => '225.010.0000',
                'nama' => 'PPH Pasal 25',
                'keterangan' => 'PPH Pasal 25'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 134,

                'kode' => '226.010.0000',
                'nama' => 'PPH Pasal 26',
                'keterangan' => 'PPH Pasal 26'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 135,

                'kode' => '227.010.0000',
                'nama' => 'Pajak Keluaran',
                'keterangan' => 'Pajak Keluaran'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 136,

                'kode' => '228.010.0000',
                'nama' => 'PPH Final Rekanan',
                'keterangan' => 'PPH Final Rekanan'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 137,

                'kode' => '229.010.0000',
                'nama' => 'Utang PPN',
                'keterangan' => 'Utang PPN'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 141,

                'kode' => '22D.010.0000',
                'nama' => 'Utang PPH Final',
                'keterangan' => 'Utang PPH Final'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 142,

                'kode' => '230.010.0000',
                'nama' => 'Biaya Yang Akan Dibayar',
                'keterangan' => 'Biaya Yang Akan Dibayar'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 143,

                'kode' => '231.010.0000',
                'nama' => 'Pendapatan Yg Diterima Dimuka',
                'keterangan' => 'Pendapatan Yg Diterima Dimuka'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 144,

                'kode' => '232.010.0000',
                'nama' => 'Hutang Bunga Bank',
                'keterangan' => 'Hutang Bunga Bank'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 145,

                'kode' => '233.010.0000',
                'nama' => 'Cadangan Insentif',
                'keterangan' => 'Cadangan Insentif'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 150,

                'kode' => '250.010.0000',
                'nama' => 'Hutang Bank',
                'keterangan' => 'Hutang Bank'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 160,

                'kode' => '260.010.0000',
                'nama' => 'Pos Silang Kas-Bank',
                'keterangan' => 'Pos Silang Kas-Bank'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 161,

                'kode' => '261.010.0000',
                'nama' => 'Pos Silang Antar Bank',
                'keterangan' => 'Pos Silang Antar Bank'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 162,

                'kode' => '262.010.0000',
                'nama' => 'Pos Silang Kas Pel.-Bank',
                'keterangan' => 'Pos Silang Kas Pel.-Bank'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 163,

                'kode' => '263.010.0000',
                'nama' => 'Pos Silang Bank-Kas Pel.',
                'keterangan' => 'Pos Silang Bank-Kas Pel.'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 166,

                'kode' => '271.010.0000',
                'nama' => 'R/K Cabang Dengan Kantor Pusat',
                'keterangan' => 'R/K Cabang Dengan Kantor Pusat'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 167,

                'kode' => '272.010.0000',
                'nama' => 'R/K Kantor Pusat Dengan Cabang',
                'keterangan' => 'R/K Kantor Pusat Dengan Cabang'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 173,

                'kode' => '300.010.0000',
                'nama' => 'Modal Dasar',
                'keterangan' => 'Modal Dasar'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 174,

                'kode' => '301.010.0000',
                'nama' => 'Agio / Disagio',
                'keterangan' => 'Agio / Disagio'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 175,

                'kode' => '302.010.0000',
                'nama' => 'Modal Dalam Pesanan',
                'keterangan' => 'Modal Dalam Pesanan'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 176,

                'kode' => '303.010.0000',
                'nama' => 'Cadangan',
                'keterangan' => 'Cadangan'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 179,

                'kode' => '306.010.0000',
                'nama' => 'Selisih Penilaian Aktiva',
                'keterangan' => 'Selisih Penilaian Aktiva'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 180,

                'kode' => '310.010.0000',
                'nama' => 'Saldo Laba Tahun Lalu',
                'keterangan' => 'Saldo Laba Tahun Lalu'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 181,

                'kode' => '320.010.0000',
                'nama' => 'Saldo Laba Tahun Berjalan',
                'keterangan' => 'Saldo Laba Tahun Berjalan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 182,

                'kode' => '400.010.0000',
                'nama' => 'Pendapatan Usaha Konstruksi',
                'keterangan' => 'Pendapatan Usaha Konstruksi'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 187,

                'kode' => '410.010.0000',
                'nama' => 'Pendapatan Usaha Konstruksi JO',
                'keterangan' => 'Pendapatan Usaha Konstruksi JO'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 196,

                'kode' => '420.010.0000',
                'nama' => 'Hasil Penjualan Property',
                'keterangan' => 'Hasil Penjualan Property'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 197,

                'kode' => '430.010.0000',
                'nama' => 'Hasil Penjualan Barang / Trading',
                'keterangan' => 'Hasil Penjualan Barang / Trading'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 198,

                'kode' => '440.010.0000',
                'nama' => 'Hasil Usaha Sewa Property / Peralatan',
                'keterangan' => 'Hasil Usaha Sewa Property / Peralatan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 199,

                'kode' => '500.010.0000',
                'nama' => 'Biaya Bahan',
                'keterangan' => 'Biaya Bahan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 200,

                'kode' => '501.010.0000',
                'nama' => 'Biaya Upah',
                'keterangan' => 'Biaya Upah'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 201,

                'kode' => '502.010.0000',
                'nama' => 'Biaya Peralatan',
                'keterangan' => 'Biaya Peralatan'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 202,

                'kode' => '503.010.0000',
                'nama' => 'Biaya Sub Kontraktor',
                'keterangan' => 'Biaya Sub Kontraktor'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 203,

                'kode' => '504.010.0000',
                'nama' => 'Biaya Bank',
                'keterangan' => 'Biaya Bank'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 205,

                'kode' => '506.010.0000',
                'nama' => 'Biaya Penyusutan Aktiva Tetap',
                'keterangan' => 'Biaya Penyusutan Aktiva Tetap'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 206,

                'kode' => '507.010.0000',
                'nama' => 'Biaya Umum Kantor Pusat',
                'keterangan' => 'Biaya Umum Kantor Pusat'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 207,

                'kode' => '508.010.0000',
                'nama' => 'Biaya PPH Final',
                'keterangan' => 'Biaya PPH Final'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 235,

                'kode' => '600.010.0000',
                'nama' => 'Beban Pemasaran',
                'keterangan' => 'Beban Pemasaran'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 236,

                'kode' => '601.010.0000',
                'nama' => 'Gaji Pegawai',
                'keterangan' => 'Gaji Pegawai'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 237,

                'kode' => '602.010.0000',
                'nama' => 'Biaya Jasa Produksi',
                'keterangan' => 'Biaya Jasa Produksi'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 238,

                'kode' => '603.010.0000',
                'nama' => 'Perlengkapan Kantor',
                'keterangan' => 'Perlengkapan Kantor'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 239,

                'kode' => '604.010.0000',
                'nama' => 'Biaya Perjalanan Dinas',
                'keterangan' => 'Biaya Perjalanan Dinas'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 240,

                'kode' => '605.010.0000',
                'nama' => 'Biaya Pengembangan Sistem dan Usaha',
                'keterangan' => 'Biaya Pengembangan Sistem dan Usaha'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 241,

                'kode' => '606.010.0000',
                'nama' => 'Biaya Raker/Rakor',
                'keterangan' => 'Biaya Raker/Rakor'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 242,

                'kode' => '607.010.0000',
                'nama' => 'Penyusutan Gedung',
                'keterangan' => 'Penyusutan Gedung'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 243,

                'kode' => '700.010.0000',
                'nama' => 'Hasil Iuran Wajib',
                'keterangan' => 'Hasil Iuran Wajib'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 244,

                'kode' => '701.010.0000',
                'nama' => 'Hasil Lain-Lain',
                'keterangan' => 'Hasil Lain-Lain'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 247,

                'kode' => '704.010.0000',
                'nama' => 'Pendapatan Jasa Bunga',
                'keterangan' => 'Pendapatan Jasa Bunga'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 248,

                'kode' => '705.010.0000',
                'nama' => 'Pendapatan Sewa Gedung',
                'keterangan' => 'Pendapatan Sewa Gedung'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 249,

                'kode' => '710.010.0000',
                'nama' => 'Pendapatan Luar Biasa',
                'keterangan' => 'Pendapatan Luar Biasa'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 250,

                'kode' => '800.010.0000',
                'nama' => 'Biaya Adm dan Provisi Bank',
                'keterangan' => 'Biaya Adm dan Provisi Bank'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 251,

                'kode' => '801.010.0000',
                'nama' => 'Biaya Luar Biasa',
                'keterangan' => 'Biaya Luar Biasa'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 254,

                'kode' => '804.010.0000',
                'nama' => 'Biaya Bunga Bank',
                'keterangan' => 'Biaya Bunga Bank'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 256,

                'kode' => '810.010.0000',
                'nama' => 'OCI - Selisih Penilaian Kembali Aset Tetap',
                'keterangan' => 'OCI - Selisih Penilaian Kembali Aset Tetap'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 258,

                'kode' => '830.010.0000',
                'nama' => 'Pajak PPH Badan',
                'keterangan' => 'Pajak PPH Badan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 0,
                'id_group_account' => 259,

                'kode' => '900.010.0000',
                'nama' => 'Laba / Rugi Tahun Berjalan',
                'keterangan' => 'Laba / Rugi Tahun Berjalan'
            ],

            // ------------------------------- PROYEK PT SAM ------------------
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 1,
                'kode' => '100.010.0000',
                'nama' => 'Kas Proyek',
                'keterangan' => 'Kas Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 2,
                'kode' => '101.010.0000',
                'nama' => 'Kas Pelaksana Proyek',
                'keterangan' => 'Kas Pelaksana Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 6,
                'kode' => '110.010.0000',
                'nama' => 'Bank Mandiri Proyek',
                'keterangan' => 'Bank Mandiri Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 7,
                'kode' => '111.010.0000',
                'nama' => 'BNI Proyek',
                'keterangan' => 'BNI Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 11,

                'kode' => '115.010.0000',
                'nama' => 'BPD Proyek',
                'keterangan' => 'BPD Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 12,
                'kode' => '116.010.0000',
                'nama' => 'BRI Proyek',
                'keterangan' => 'BRI Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 15,

                'kode' => '119.010.0000',
                'nama' => 'BSI Proyek',
                'keterangan' => 'BSI Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 16,

                'kode' => '11A.010.0000',
                'nama' => 'BII Proyek',
                'keterangan' => 'BII Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 17,
                'kode' => '11B.010.0000',
                'nama' => 'BCA Proyek',
                'keterangan' => 'BCA Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 18,
                'kode' => '11C.010.0000',
                'nama' => 'Bank CIMB Niaga Proyek',
                'keterangan' => 'Bank CIMB Niaga Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 19,
                'kode' => '11D.010.0000',
                'nama' => 'Bank Tabungan Negara Proyek',
                'keterangan' => 'Bank Tabungan Negara Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 20,
                'kode' => '11E.010.0000',
                'nama' => 'Bank Bukopin Proyek',
                'keterangan' => 'Bank Bukopin Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 22,
                'kode' => '11G.010.0000',
                'nama' => 'Bank Finconesia Proyek',
                'keterangan' => 'Bank Finconesia Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 23,
                'kode' => '11H.010.0000',
                'nama' => 'Bank Danamon Proyek',
                'keterangan' => 'Bank Danamon Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 25,
                'kode' => '11J.010.0000',
                'nama' => 'Bank Permata Proyek',
                'keterangan' => 'Bank Permata Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 26,
                'kode' => '11K.010.0000',
                'nama' => 'Bank Panin Proyek',
                'keterangan' => 'Bank Panin Rekening Proyek'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 27,
                'kode' => '120.010.0000',
                'nama' => 'Piutang Pekerjaan',
                'keterangan' => 'Piutang Pekerjaan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 28,
                'kode' => '121.010.0000',
                'nama' => 'Piutang Retensi Pekerjaan',
                'keterangan' => 'Piutang Retensi Pekerjaan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 29,
                'kode' => '122.010.0000',
                'nama' => 'Uang Muka Leveransir',
                'keterangan' => 'Uang Muka Leveransir'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 30,
                'kode' => '123.010.0000',
                'nama' => 'Uang Muka Sub Kontraktor',
                'keterangan' => 'Uang Muka Sub Kontraktor'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 31,
                'kode' => '124.010.0000',
                'nama' => 'Panjar Pelaksana',
                'keterangan' => 'Panjar Pelaksana'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 32,
                'kode' => '125.010.0000',
                'nama' => 'Piutang Jaminan',
                'keterangan' => 'Piutang Jaminan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 33,
                'kode' => '126.010.0000',
                'nama' => 'Piutang Pegawai',
                'keterangan' => 'Piutang Pegawai'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 34,
                'kode' => '127.010.0000',
                'nama' => 'Piutang Joint Operation',
                'keterangan' => 'Piutang Joint Operation'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 35,
                'kode' => '128.010.0000',
                'nama' => 'Piutang Lain-Lain',
                'keterangan' => 'Piutang Lain-Lain'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 36,

                'kode' => '129.010.0000',
                'nama' => 'Penyisihan Piutang',
                'keterangan' => 'Penyisihan Piutang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 37,

                'kode' => '12C.010.0000',
                'nama' => 'Piutang PPN',
                'keterangan' => 'Piutang PPN'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 38,
                'kode' => '130.010.0000',
                'nama' => 'PPH Badan Untuk Tahun Lalu',
                'keterangan' => 'PPH Badan Untuk Tahun Lalu'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 39,
                'kode' => '131.010.0000',
                'nama' => 'PPH Final',
                'keterangan' => 'PPH Final'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 40,
                'kode' => '132.010.0000',
                'nama' => 'PPH Pasal 22',
                'keterangan' => 'PPH Pasal 22'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 41,
                'kode' => '133.010.0000',
                'nama' => 'PPH Pasal 23',
                'keterangan' => 'PPH Pasal 23'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 42,
                'kode' => '134.010.0000',
                'nama' => 'PPH Pasal 24',
                'keterangan' => 'PPH Pasal 24'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 42,
                'kode' => '134.010.0000',
                'nama' => 'PPH Pasal 24',
                'keterangan' => 'PPH Pasal 24'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 43,
                'kode' => '135.010.0000',
                'nama' => 'PPH Pasal 25',
                'keterangan' => 'PPH Pasal 25'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 44,

                'kode' => '136.010.0000',
                'nama' => 'PPN Atas Uang Muka',
                'keterangan' => 'PPN Atas Uang Muka'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 45,

                'kode' => '137.010.0000',
                'nama' => 'Pajak Masukan (PM)',
                'keterangan' => 'Pajak Masukan (PM)'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 46,

                'kode' => '138.010.0000',
                'nama' => 'Piutang PPN',
                'keterangan' => 'Piutang PPN'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 47,

                'kode' => '139.010.0000',
                'nama' => 'PPH Pasal 29',
                'keterangan' => 'PPH Pasal 29'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 48,

                'kode' => '13A.010.0000',
                'nama' => 'PM Untuk PPN Yg Belum Terbit FP',
                'keterangan' => 'PM Untuk PPN Yg Belum Terbit FP'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 49,

                'kode' => '140.010.0000',
                'nama' => 'Persediaan Bahan / Material',
                'keterangan' => 'Persediaan Bahan / Material'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 50,

                'kode' => '141.010.0000',
                'nama' => 'Persediaan Spareparts / Suku Cadang',
                'keterangan' => 'Persediaan Spareparts / Suku Cadang'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 51,

                'kode' => '142.010.0000',
                'nama' => 'Koreksi Persediaan Bahan',
                'keterangan' => 'Koreksi Persediaan Bahan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 52,

                'kode' => '143.010.0000',
                'nama' => 'Koreksi Persediaan Spareparts',
                'keterangan' => 'Koreksi Persediaan Spareparts'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 53,

                'kode' => '144.010.0000',
                'nama' => 'Perbedaan Harga Bahan',
                'keterangan' => 'Perbedaan Harga Bahan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 54,

                'kode' => '145.010.0000',
                'nama' => 'Bangunan Dalam Proses',
                'keterangan' => 'Bangunan Dalam Proses'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 55,

                'kode' => '146.010.0000',
                'nama' => 'Bangunan Selesai',
                'keterangan' => 'Bangunan Selesai'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 56,

                'kode' => '147.010.0000',
                'nama' => 'Persediaan AMP',
                'keterangan' => 'Persediaan AMP'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 57,

                'kode' => '148.010.0000',
                'nama' => 'Persediaan Bahan Batching Plant',
                'keterangan' => 'Persediaan Bahan Batching Plant'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 58,

                'kode' => '150.010.0000',
                'nama' => 'PDP. Kontrak Induk',
                'keterangan' => 'PDP. Kontrak Induk'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 59,

                'kode' => '151.010.0000',
                'nama' => 'PDP. Kontrak Tambah',
                'keterangan' => 'PDP. Kontrak Tambah'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 60,

                'kode' => '152.010.0000',
                'nama' => 'PDP. Eskalasi',
                'keterangan' => 'PDP. Eskalasi'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 61,

                'kode' => '153.010.0000',
                'nama' => 'PDP. Selisih Kurs',
                'keterangan' => 'PDP. Selisih Kurs'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 62,

                'kode' => '160.010.0000',
                'nama' => 'Biaya Yg Dibayar Dimuka',
                'keterangan' => 'Biaya Yg Dibayar Dimuka'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 63,

                'kode' => '161.010.0000',
                'nama' => 'Pendapatan Yg Akan Diterima',
                'keterangan' => 'Pendapatan Yg Akan Diterima'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 64,

                'kode' => '162.010.0000',
                'nama' => 'Uang Muka Pembagian Laba',
                'keterangan' => 'Uang Muka Pembagian Laba'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 65,

                'kode' => '163.010.0000',
                'nama' => 'Rumah & Bangunan Yg Disewakan',
                'keterangan' => 'Rumah & Bangunan Yg Disewakan'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 66,

                'kode' => '164.010.0000',
                'nama' => 'Piutang Jangka Panjang',
                'keterangan' => 'Piutang Jangka Panjang'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 67,

                'kode' => '170.010.0000',
                'nama' => 'Penyertaan Saham',
                'keterangan' => 'Penyertaan Saham'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 68,

                'kode' => '171.010.0000',
                'nama' => 'Piutang Pemegang Saham',
                'keterangan' => 'Piutang Pemegang Saham'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 69,

                'kode' => '172.010.0000',
                'nama' => 'Inv. Pada Ventura Bersama',
                'keterangan' => 'Inv. Pada Ventura Bersama'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 70,

                'kode' => '180.010.0000',
                'nama' => 'Tanah',
                'keterangan' => 'Tanah'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 71,

                'kode' => '181.010.0000',
                'nama' => 'Gedung',
                'keterangan' => 'Gedung'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 72,

                'kode' => '182.010.0000',
                'nama' => 'Mesin / Alat',
                'keterangan' => 'Mesin / Alat'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 73,

                'kode' => '183.010.0000',
                'nama' => 'Alat Angkut / Kendaraan',
                'keterangan' => 'Alat Angkut / Kendaraan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 74,

                'kode' => '184.010.0000',
                'nama' => 'Kantor',
                'keterangan' => 'Kantor'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 75,

                'kode' => '185.010.0000',
                'nama' => 'Mess',
                'keterangan' => 'Mess'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 79,

                'kode' => '190.010.0000',
                'nama' => 'Hak Pengelolaan',
                'keterangan' => 'Hak Pengelolaan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 81,

                'kode' => '1A0.010.0000',
                'nama' => 'Hak Patent',
                'keterangan' => 'Hak Patent'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 95,

                'kode' => '1B9.010.0000',
                'nama' => 'Aktiva Lain-Lain',
                'keterangan' => 'Aktiva Lain-Lain'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 98,

                'kode' => '200.010.0000',
                'nama' => 'Utang Pada Leveransir',
                'keterangan' => 'Utang Pada Leveransir'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 99,

                'kode' => '201.010.0000',
                'nama' => 'Utang Pada Sub Kontraktor',
                'keterangan' => 'Utang Pada Sub Kontraktor'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 100,

                'kode' => '202.010.0000',
                'nama' => 'Uang Muka Bowheer',
                'keterangan' => 'Uang Muka Bowheer'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 101,

                'kode' => '203.010.0000',
                'nama' => 'Utang Deviden / DPS',
                'keterangan' => 'Utang Deviden / DPS'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 102,

                'kode' => '204.010.0000',
                'nama' => 'Utang Tantiem',
                'keterangan' => 'Utang Tantiem'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 103,

                'kode' => '205.010.0000',
                'nama' => 'Utang Leasing',
                'keterangan' => 'Utang Leasing'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 104,

                'kode' => '206.010.0000',
                'nama' => 'Utang Jangka Panjang Lain Yg Lancar',
                'keterangan' => 'Utang Jangka Panjang Lain Yg Lancar'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 105,

                'kode' => '207.010.0000',
                'nama' => 'Utang Astek / THT',
                'keterangan' => 'Utang Astek / THT'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 106,

                'kode' => '208.010.0000',
                'nama' => 'Utang Dana Jasa Produksi',
                'keterangan' => 'Utang Dana Jasa Produksi'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 107,

                'kode' => '209.010.0000',
                'nama' => 'Utang Lain-Lain',
                'keterangan' => 'Utang Lain-Lain'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 108,

                'kode' => '20A.010.0000',
                'nama' => 'Utang PPN Leveransir',
                'keterangan' => 'Utang PPN Leveransir'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 129,

                'kode' => '221.010.0000',
                'nama' => 'PPH Pasal 21',
                'keterangan' => 'PPH Pasal 21'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 130,

                'kode' => '222.010.0000',
                'nama' => 'PPH Pasal 22',
                'keterangan' => 'PPH Pasal 22'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 131,

                'kode' => '223.010.0000',
                'nama' => 'PPH Pasal 23',
                'keterangan' => 'PPH Pasal 23'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 132,

                'kode' => '224.010.0000',
                'nama' => 'PPN Yang Dihitung',
                'keterangan' => 'PPN Yang Dihitung'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 133,

                'kode' => '225.010.0000',
                'nama' => 'PPH Pasal 25',
                'keterangan' => 'PPH Pasal 25'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 134,

                'kode' => '226.010.0000',
                'nama' => 'PPH Pasal 26',
                'keterangan' => 'PPH Pasal 26'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 135,

                'kode' => '227.010.0000',
                'nama' => 'Pajak Keluaran',
                'keterangan' => 'Pajak Keluaran'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 136,

                'kode' => '228.010.0000',
                'nama' => 'PPH Final Rekanan',
                'keterangan' => 'PPH Final Rekanan'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 137,

                'kode' => '229.010.0000',
                'nama' => 'Utang PPN',
                'keterangan' => 'Utang PPN'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 141,

                'kode' => '22D.010.0000',
                'nama' => 'Utang PPH Final',
                'keterangan' => 'Utang PPH Final'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 142,

                'kode' => '230.010.0000',
                'nama' => 'Biaya Yang Akan Dibayar',
                'keterangan' => 'Biaya Yang Akan Dibayar'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 143,

                'kode' => '231.010.0000',
                'nama' => 'Pendapatan Yg Diterima Dimuka',
                'keterangan' => 'Pendapatan Yg Diterima Dimuka'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 144,

                'kode' => '232.010.0000',
                'nama' => 'Hutang Bunga Bank',
                'keterangan' => 'Hutang Bunga Bank'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 145,

                'kode' => '233.010.0000',
                'nama' => 'Cadangan Insentif',
                'keterangan' => 'Cadangan Insentif'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 150,

                'kode' => '250.010.0000',
                'nama' => 'Hutang Bank',
                'keterangan' => 'Hutang Bank'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 160,

                'kode' => '260.010.0000',
                'nama' => 'Pos Silang Kas-Bank',
                'keterangan' => 'Pos Silang Kas-Bank'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 161,

                'kode' => '261.010.0000',
                'nama' => 'Pos Silang Antar Bank',
                'keterangan' => 'Pos Silang Antar Bank'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 162,

                'kode' => '262.010.0000',
                'nama' => 'Pos Silang Kas Pel.-Bank',
                'keterangan' => 'Pos Silang Kas Pel.-Bank'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 163,

                'kode' => '263.010.0000',
                'nama' => 'Pos Silang Bank-Kas Pel.',
                'keterangan' => 'Pos Silang Bank-Kas Pel.'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 166,

                'kode' => '271.010.0000',
                'nama' => 'R/K Cabang Dengan Kantor Pusat',
                'keterangan' => 'R/K Cabang Dengan Kantor Pusat'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 167,

                'kode' => '272.010.0000',
                'nama' => 'R/K Kantor Pusat Dengan Cabang',
                'keterangan' => 'R/K Kantor Pusat Dengan Cabang'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 173,

                'kode' => '300.010.0000',
                'nama' => 'Modal Dasar',
                'keterangan' => 'Modal Dasar'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 174,

                'kode' => '301.010.0000',
                'nama' => 'Agio / Disagio',
                'keterangan' => 'Agio / Disagio'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 175,

                'kode' => '302.010.0000',
                'nama' => 'Modal Dalam Pesanan',
                'keterangan' => 'Modal Dalam Pesanan'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 176,

                'kode' => '303.010.0000',
                'nama' => 'Cadangan',
                'keterangan' => 'Cadangan'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 179,

                'kode' => '306.010.0000',
                'nama' => 'Selisih Penilaian Aktiva',
                'keterangan' => 'Selisih Penilaian Aktiva'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 180,

                'kode' => '310.010.0000',
                'nama' => 'Saldo Laba Tahun Lalu',
                'keterangan' => 'Saldo Laba Tahun Lalu'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 181,

                'kode' => '320.010.0000',
                'nama' => 'Saldo Laba Tahun Berjalan',
                'keterangan' => 'Saldo Laba Tahun Berjalan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 182,

                'kode' => '400.010.0000',
                'nama' => 'Pendapatan Usaha Konstruksi',
                'keterangan' => 'Pendapatan Usaha Konstruksi'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 187,

                'kode' => '410.010.0000',
                'nama' => 'Pendapatan Usaha Konstruksi JO',
                'keterangan' => 'Pendapatan Usaha Konstruksi JO'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 196,

                'kode' => '420.010.0000',
                'nama' => 'Hasil Penjualan Property',
                'keterangan' => 'Hasil Penjualan Property'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 197,

                'kode' => '430.010.0000',
                'nama' => 'Hasil Penjualan Barang / Trading',
                'keterangan' => 'Hasil Penjualan Barang / Trading'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 198,

                'kode' => '440.010.0000',
                'nama' => 'Hasil Usaha Sewa Property / Peralatan',
                'keterangan' => 'Hasil Usaha Sewa Property / Peralatan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 199,

                'kode' => '500.010.0000',
                'nama' => 'Biaya Bahan',
                'keterangan' => 'Biaya Bahan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 200,

                'kode' => '501.010.0000',
                'nama' => 'Biaya Upah',
                'keterangan' => 'Biaya Upah'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 201,

                'kode' => '502.010.0000',
                'nama' => 'Biaya Peralatan',
                'keterangan' => 'Biaya Peralatan'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 202,

                'kode' => '503.010.0000',
                'nama' => 'Biaya Sub Kontraktor',
                'keterangan' => 'Biaya Sub Kontraktor'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 203,

                'kode' => '504.010.0000',
                'nama' => 'Biaya Bank',
                'keterangan' => 'Biaya Bank'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 205,

                'kode' => '506.010.0000',
                'nama' => 'Biaya Penyusutan Aktiva Tetap',
                'keterangan' => 'Biaya Penyusutan Aktiva Tetap'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 206,

                'kode' => '507.010.0000',
                'nama' => 'Biaya Umum Kantor Pusat',
                'keterangan' => 'Biaya Umum Kantor Pusat'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 207,

                'kode' => '508.010.0000',
                'nama' => 'Biaya PPH Final',
                'keterangan' => 'Biaya PPH Final'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 235,

                'kode' => '600.010.0000',
                'nama' => 'Beban Pemasaran',
                'keterangan' => 'Beban Pemasaran'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 236,

                'kode' => '601.010.0000',
                'nama' => 'Gaji Pegawai',
                'keterangan' => 'Gaji Pegawai'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 237,

                'kode' => '602.010.0000',
                'nama' => 'Biaya Jasa Produksi',
                'keterangan' => 'Biaya Jasa Produksi'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 238,

                'kode' => '603.010.0000',
                'nama' => 'Perlengkapan Kantor',
                'keterangan' => 'Perlengkapan Kantor'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 239,

                'kode' => '604.010.0000',
                'nama' => 'Biaya Perjalanan Dinas',
                'keterangan' => 'Biaya Perjalanan Dinas'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 240,

                'kode' => '605.010.0000',
                'nama' => 'Biaya Pengembangan Sistem dan Usaha',
                'keterangan' => 'Biaya Pengembangan Sistem dan Usaha'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 241,

                'kode' => '606.010.0000',
                'nama' => 'Biaya Raker/Rakor',
                'keterangan' => 'Biaya Raker/Rakor'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 242,

                'kode' => '607.010.0000',
                'nama' => 'Penyusutan Gedung',
                'keterangan' => 'Penyusutan Gedung'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 243,

                'kode' => '700.010.0000',
                'nama' => 'Hasil Iuran Wajib',
                'keterangan' => 'Hasil Iuran Wajib'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 244,

                'kode' => '701.010.0000',
                'nama' => 'Hasil Lain-Lain',
                'keterangan' => 'Hasil Lain-Lain'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 247,

                'kode' => '704.010.0000',
                'nama' => 'Pendapatan Jasa Bunga',
                'keterangan' => 'Pendapatan Jasa Bunga'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 248,

                'kode' => '705.010.0000',
                'nama' => 'Pendapatan Sewa Gedung',
                'keterangan' => 'Pendapatan Sewa Gedung'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 249,

                'kode' => '710.010.0000',
                'nama' => 'Pendapatan Luar Biasa',
                'keterangan' => 'Pendapatan Luar Biasa'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 250,

                'kode' => '800.010.0000',
                'nama' => 'Biaya Adm dan Provisi Bank',
                'keterangan' => 'Biaya Adm dan Provisi Bank'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 251,

                'kode' => '801.010.0000',
                'nama' => 'Biaya Luar Biasa',
                'keterangan' => 'Biaya Luar Biasa'
            ], [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 254,

                'kode' => '804.010.0000',
                'nama' => 'Biaya Bunga Bank',
                'keterangan' => 'Biaya Bunga Bank'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 256,

                'kode' => '810.010.0000',
                'nama' => 'OCI - Selisih Penilaian Kembali Aset Tetap',
                'keterangan' => 'OCI - Selisih Penilaian Kembali Aset Tetap'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 258,

                'kode' => '830.010.0000',
                'nama' => 'Pajak PPH Badan',
                'keterangan' => 'Pajak PPH Badan'
            ],
            [
                'id_cabang' => 2,
                'id_proyek' => 1,
                'id_group_account' => 259,

                'kode' => '900.010.0000',
                'nama' => 'Laba / Rugi Tahun Berjalan',
                'keterangan' => 'Laba / Rugi Tahun Berjalan'
            ],
            // ------------------------------- END PROYEK PT SAM -------------

            // nimo cabang
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 1,

                'kode' => '100.020.0000',
                'nama' => 'Kas Kantor',
                'keterangan' => 'Kas Kantor Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 2,

                'kode' => '101.020.0000',
                'nama' => 'Kas Pelaksana Kantor',
                'keterangan' => 'Kas Pelaksana Kantor Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 6,

                'kode' => '110.020.0000',
                'nama' => 'Bank Mandiri',
                'keterangan' => 'Bank Mandiri Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 7,

                'kode' => '111.020.0000',
                'nama' => 'BNI',
                'keterangan' => 'BNI Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 11,

                'kode' => '115.020.0000',
                'nama' => 'BPD',
                'keterangan' => 'BPD Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 12,

                'kode' => '116.020.0000',
                'nama' => 'BRI',
                'keterangan' => 'BRI Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 15,

                'kode' => '119.020.0000',
                'nama' => 'BSI',
                'keterangan' => 'BSI Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 16,

                'kode' => '11A.020.0000',
                'nama' => 'BII',
                'keterangan' => 'BII Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 17,

                'kode' => '11B.020.0000',
                'nama' => 'BCA',
                'keterangan' => 'BCA Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 18,

                'kode' => '11C.020.0000',
                'nama' => 'Bank CIMB Niaga',
                'keterangan' => 'Bank CIMB Niaga Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 19,

                'kode' => '11D.020.0000',
                'nama' => 'Bank Tabungan Negara',
                'keterangan' => 'Bank Tabungan Negara Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 20,

                'kode' => '11E.020.0000',
                'nama' => 'Bank Bukopin',
                'keterangan' => 'Bank Bukopin Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 22,

                'kode' => '11G.020.0000',
                'nama' => 'Bank Finconesia',
                'keterangan' => 'Bank Finconesia Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 23,

                'kode' => '11H.020.0000',
                'nama' => 'Bank Danamon',
                'keterangan' => 'Bank Danamon Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 25,

                'kode' => '11J.020.0000',
                'nama' => 'Bank Permata',
                'keterangan' => 'Bank Permata Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 26,

                'kode' => '11K.020.0000',
                'nama' => 'Bank Panin',
                'keterangan' => 'Bank Panin Rekening Cabang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 27,

                'kode' => '120.020.0000',
                'nama' => 'Piutang Pekerjaan',
                'keterangan' => 'Piutang Pekerjaan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 28,

                'kode' => '121.020.0000',
                'nama' => 'Piutang Retensi Pekerjaan',
                'keterangan' => 'Piutang Retensi Pekerjaan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 29,

                'kode' => '122.020.0000',
                'nama' => 'Uang Muka Leveransir',
                'keterangan' => 'Uang Muka Leveransir'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 30,

                'kode' => '123.020.0000',
                'nama' => 'Uang Muka Sub Kontraktor',
                'keterangan' => 'Uang Muka Sub Kontraktor'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 31,

                'kode' => '124.020.0000',
                'nama' => 'Panjar Pelaksana',
                'keterangan' => 'Panjar Pelaksana'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 32,

                'kode' => '125.020.0000',
                'nama' => 'Piutang Jaminan',
                'keterangan' => 'Piutang Jaminan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 33,

                'kode' => '126.020.0000',
                'nama' => 'Piutang Pegawai',
                'keterangan' => 'Piutang Pegawai'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 34,

                'kode' => '127.020.0000',
                'nama' => 'Piutang Joint Operation',
                'keterangan' => 'Piutang Joint Operation'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 35,

                'kode' => '128.020.0000',
                'nama' => 'Piutang Lain-Lain',
                'keterangan' => 'Piutang Lain-Lain'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 36,

                'kode' => '129.020.0000',
                'nama' => 'Penyisihan Piutang',
                'keterangan' => 'Penyisihan Piutang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 37,

                'kode' => '12C.020.0000',
                'nama' => 'Piutang PPN',
                'keterangan' => 'Piutang PPN'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 38,

                'kode' => '130.020.0000',
                'nama' => 'PPH Badan Untuk Tahun Lalu',
                'keterangan' => 'PPH Badan Untuk Tahun Lalu'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 39,

                'kode' => '131.020.0000',
                'nama' => 'PPH Final',
                'keterangan' => 'PPH Final'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 40,

                'kode' => '132.020.0000',
                'nama' => 'PPH Pasal 22',
                'keterangan' => 'PPH Pasal 22'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 41,

                'kode' => '133.020.0000',
                'nama' => 'PPH Pasal 23',
                'keterangan' => 'PPH Pasal 23'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 42,

                'kode' => '134.020.0000',
                'nama' => 'PPH Pasal 24',
                'keterangan' => 'PPH Pasal 24'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 42,

                'kode' => '134.020.0000',
                'nama' => 'PPH Pasal 24',
                'keterangan' => 'PPH Pasal 24'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 43,

                'kode' => '135.020.0000',
                'nama' => 'PPH Pasal 25',
                'keterangan' => 'PPH Pasal 25'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 44,

                'kode' => '136.020.0000',
                'nama' => 'PPN Atas Uang Muka',
                'keterangan' => 'PPN Atas Uang Muka'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 45,

                'kode' => '137.020.0000',
                'nama' => 'Pajak Masukan (PM)',
                'keterangan' => 'Pajak Masukan (PM)'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 46,

                'kode' => '138.020.0000',
                'nama' => 'Piutang PPN',
                'keterangan' => 'Piutang PPN'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 47,

                'kode' => '139.020.0000',
                'nama' => 'PPH Pasal 29',
                'keterangan' => 'PPH Pasal 29'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 48,

                'kode' => '13A.020.0000',
                'nama' => 'PM Untuk PPN Yg Belum Terbit FP',
                'keterangan' => 'PM Untuk PPN Yg Belum Terbit FP'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 49,

                'kode' => '140.020.0000',
                'nama' => 'Persediaan Bahan / Material',
                'keterangan' => 'Persediaan Bahan / Material'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 50,

                'kode' => '141.020.0000',
                'nama' => 'Persediaan Spareparts / Suku Cadang',
                'keterangan' => 'Persediaan Spareparts / Suku Cadang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 51,

                'kode' => '142.020.0000',
                'nama' => 'Koreksi Persediaan Bahan',
                'keterangan' => 'Koreksi Persediaan Bahan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 52,

                'kode' => '143.020.0000',
                'nama' => 'Koreksi Persediaan Spareparts',
                'keterangan' => 'Koreksi Persediaan Spareparts'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 53,

                'kode' => '144.020.0000',
                'nama' => 'Perbedaan Harga Bahan',
                'keterangan' => 'Perbedaan Harga Bahan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 54,

                'kode' => '145.020.0000',
                'nama' => 'Bangunan Dalam Proses',
                'keterangan' => 'Bangunan Dalam Proses'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 55,

                'kode' => '146.020.0000',
                'nama' => 'Bangunan Selesai',
                'keterangan' => 'Bangunan Selesai'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 56,

                'kode' => '147.020.0000',
                'nama' => 'Persediaan AMP',
                'keterangan' => 'Persediaan AMP'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 57,

                'kode' => '148.020.0000',
                'nama' => 'Persediaan Bahan Batching Plant',
                'keterangan' => 'Persediaan Bahan Batching Plant'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 58,

                'kode' => '150.020.0000',
                'nama' => 'PDP. Kontrak Induk',
                'keterangan' => 'PDP. Kontrak Induk'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 59,

                'kode' => '151.020.0000',
                'nama' => 'PDP. Kontrak Tambah',
                'keterangan' => 'PDP. Kontrak Tambah'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 60,

                'kode' => '152.020.0000',
                'nama' => 'PDP. Eskalasi',
                'keterangan' => 'PDP. Eskalasi'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 61,

                'kode' => '153.020.0000',
                'nama' => 'PDP. Selisih Kurs',
                'keterangan' => 'PDP. Selisih Kurs'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 62,

                'kode' => '160.020.0000',
                'nama' => 'Biaya Yg Dibayar Dimuka',
                'keterangan' => 'Biaya Yg Dibayar Dimuka'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 63,

                'kode' => '161.020.0000',
                'nama' => 'Pendapatan Yg Akan Diterima',
                'keterangan' => 'Pendapatan Yg Akan Diterima'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 64,

                'kode' => '162.020.0000',
                'nama' => 'Uang Muka Pembagian Laba',
                'keterangan' => 'Uang Muka Pembagian Laba'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 65,

                'kode' => '163.020.0000',
                'nama' => 'Rumah & Bangunan Yg Disewakan',
                'keterangan' => 'Rumah & Bangunan Yg Disewakan'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 66,

                'kode' => '164.020.0000',
                'nama' => 'Piutang Jangka Panjang',
                'keterangan' => 'Piutang Jangka Panjang'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 67,

                'kode' => '170.020.0000',
                'nama' => 'Penyertaan Saham',
                'keterangan' => 'Penyertaan Saham'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 68,

                'kode' => '171.020.0000',
                'nama' => 'Piutang Pemegang Saham',
                'keterangan' => 'Piutang Pemegang Saham'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 69,

                'kode' => '172.020.0000',
                'nama' => 'Inv. Pada Ventura Bersama',
                'keterangan' => 'Inv. Pada Ventura Bersama'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 70,

                'kode' => '180.020.0000',
                'nama' => 'Tanah',
                'keterangan' => 'Tanah'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 71,

                'kode' => '181.020.0000',
                'nama' => 'Gedung',
                'keterangan' => 'Gedung'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 72,

                'kode' => '182.020.0000',
                'nama' => 'Mesin / Alat',
                'keterangan' => 'Mesin / Alat'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 73,

                'kode' => '183.020.0000',
                'nama' => 'Alat Angkut / Kendaraan',
                'keterangan' => 'Alat Angkut / Kendaraan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 74,

                'kode' => '184.020.0000',
                'nama' => 'Kantor',
                'keterangan' => 'Kantor'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 75,

                'kode' => '185.020.0000',
                'nama' => 'Mess',
                'keterangan' => 'Mess'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 79,

                'kode' => '190.020.0000',
                'nama' => 'Hak Pengelolaan',
                'keterangan' => 'Hak Pengelolaan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 81,

                'kode' => '1A0.020.0000',
                'nama' => 'Hak Patent',
                'keterangan' => 'Hak Patent'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 95,

                'kode' => '1B9.020.0000',
                'nama' => 'Aktiva Lain-Lain',
                'keterangan' => 'Aktiva Lain-Lain'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 98,

                'kode' => '200.020.0000',
                'nama' => 'Utang Pada Leveransir',
                'keterangan' => 'Utang Pada Leveransir'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 99,

                'kode' => '201.020.0000',
                'nama' => 'Utang Pada Sub Kontraktor',
                'keterangan' => 'Utang Pada Sub Kontraktor'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 100,

                'kode' => '202.020.0000',
                'nama' => 'Uang Muka Bowheer',
                'keterangan' => 'Uang Muka Bowheer'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 101,

                'kode' => '203.020.0000',
                'nama' => 'Utang Deviden / DPS',
                'keterangan' => 'Utang Deviden / DPS'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 102,

                'kode' => '204.020.0000',
                'nama' => 'Utang Tantiem',
                'keterangan' => 'Utang Tantiem'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 103,

                'kode' => '205.020.0000',
                'nama' => 'Utang Leasing',
                'keterangan' => 'Utang Leasing'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 104,

                'kode' => '206.020.0000',
                'nama' => 'Utang Jangka Panjang Lain Yg Lancar',
                'keterangan' => 'Utang Jangka Panjang Lain Yg Lancar'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 105,

                'kode' => '207.020.0000',
                'nama' => 'Utang Astek / THT',
                'keterangan' => 'Utang Astek / THT'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 106,

                'kode' => '208.020.0000',
                'nama' => 'Utang Dana Jasa Produksi',
                'keterangan' => 'Utang Dana Jasa Produksi'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 107,

                'kode' => '209.020.0000',
                'nama' => 'Utang Lain-Lain',
                'keterangan' => 'Utang Lain-Lain'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 108,

                'kode' => '20A.020.0000',
                'nama' => 'Utang PPN Leveransir',
                'keterangan' => 'Utang PPN Leveransir'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 129,

                'kode' => '221.020.0000',
                'nama' => 'PPH Pasal 21',
                'keterangan' => 'PPH Pasal 21'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 130,

                'kode' => '222.020.0000',
                'nama' => 'PPH Pasal 22',
                'keterangan' => 'PPH Pasal 22'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 131,

                'kode' => '223.020.0000',
                'nama' => 'PPH Pasal 23',
                'keterangan' => 'PPH Pasal 23'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 132,

                'kode' => '224.020.0000',
                'nama' => 'PPN Yang Dihitung',
                'keterangan' => 'PPN Yang Dihitung'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 133,

                'kode' => '225.020.0000',
                'nama' => 'PPH Pasal 25',
                'keterangan' => 'PPH Pasal 25'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 134,

                'kode' => '226.020.0000',
                'nama' => 'PPH Pasal 26',
                'keterangan' => 'PPH Pasal 26'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 135,

                'kode' => '227.020.0000',
                'nama' => 'Pajak Keluaran',
                'keterangan' => 'Pajak Keluaran'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 136,

                'kode' => '228.020.0000',
                'nama' => 'PPH Final Rekanan',
                'keterangan' => 'PPH Final Rekanan'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 137,

                'kode' => '229.020.0000',
                'nama' => 'Utang PPN',
                'keterangan' => 'Utang PPN'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 141,

                'kode' => '22D.020.0000',
                'nama' => 'Utang PPH Final',
                'keterangan' => 'Utang PPH Final'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 142,

                'kode' => '230.020.0000',
                'nama' => 'Biaya Yang Akan Dibayar',
                'keterangan' => 'Biaya Yang Akan Dibayar'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 143,

                'kode' => '231.020.0000',
                'nama' => 'Pendapatan Yg Diterima Dimuka',
                'keterangan' => 'Pendapatan Yg Diterima Dimuka'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 144,

                'kode' => '232.020.0000',
                'nama' => 'Hutang Bunga Bank',
                'keterangan' => 'Hutang Bunga Bank'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 145,

                'kode' => '233.020.0000',
                'nama' => 'Cadangan Insentif',
                'keterangan' => 'Cadangan Insentif'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 150,

                'kode' => '250.020.0000',
                'nama' => 'Hutang Bank',
                'keterangan' => 'Hutang Bank'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 160,

                'kode' => '260.020.0000',
                'nama' => 'Pos Silang Kas-Bank',
                'keterangan' => 'Pos Silang Kas-Bank'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 161,

                'kode' => '261.020.0000',
                'nama' => 'Pos Silang Antar Bank',
                'keterangan' => 'Pos Silang Antar Bank'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 162,

                'kode' => '262.020.0000',
                'nama' => 'Pos Silang Kas Pel.-Bank',
                'keterangan' => 'Pos Silang Kas Pel.-Bank'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 163,

                'kode' => '263.020.0000',
                'nama' => 'Pos Silang Bank-Kas Pel.',
                'keterangan' => 'Pos Silang Bank-Kas Pel.'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 166,

                'kode' => '271.020.0000',
                'nama' => 'R/K Cabang Dengan Kantor Pusat',
                'keterangan' => 'R/K Cabang Dengan Kantor Pusat'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 167,

                'kode' => '272.020.0000',
                'nama' => 'R/K Kantor Pusat Dengan Cabang',
                'keterangan' => 'R/K Kantor Pusat Dengan Cabang'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 173,

                'kode' => '300.020.0000',
                'nama' => 'Modal Dasar',
                'keterangan' => 'Modal Dasar'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 174,

                'kode' => '301.020.0000',
                'nama' => 'Agio / Disagio',
                'keterangan' => 'Agio / Disagio'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 175,

                'kode' => '302.020.0000',
                'nama' => 'Modal Dalam Pesanan',
                'keterangan' => 'Modal Dalam Pesanan'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 176,

                'kode' => '303.020.0000',
                'nama' => 'Cadangan',
                'keterangan' => 'Cadangan'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 179,

                'kode' => '306.020.0000',
                'nama' => 'Selisih Penilaian Aktiva',
                'keterangan' => 'Selisih Penilaian Aktiva'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 180,

                'kode' => '310.020.0000',
                'nama' => 'Saldo Laba Tahun Lalu',
                'keterangan' => 'Saldo Laba Tahun Lalu'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 181,

                'kode' => '320.020.0000',
                'nama' => 'Saldo Laba Tahun Berjalan',
                'keterangan' => 'Saldo Laba Tahun Berjalan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 182,

                'kode' => '400.020.0000',
                'nama' => 'Pendapatan Usaha Konstruksi',
                'keterangan' => 'Pendapatan Usaha Konstruksi'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 187,

                'kode' => '410.020.0000',
                'nama' => 'Pendapatan Usaha Konstruksi JO',
                'keterangan' => 'Pendapatan Usaha Konstruksi JO'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 196,

                'kode' => '420.020.0000',
                'nama' => 'Hasil Penjualan Property',
                'keterangan' => 'Hasil Penjualan Property'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 197,

                'kode' => '430.020.0000',
                'nama' => 'Hasil Penjualan Barang / Trading',
                'keterangan' => 'Hasil Penjualan Barang / Trading'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 198,

                'kode' => '440.020.0000',
                'nama' => 'Hasil Usaha Sewa Property / Peralatan',
                'keterangan' => 'Hasil Usaha Sewa Property / Peralatan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 199,

                'kode' => '500.020.0000',
                'nama' => 'Biaya Bahan',
                'keterangan' => 'Biaya Bahan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 200,

                'kode' => '501.020.0000',
                'nama' => 'Biaya Upah',
                'keterangan' => 'Biaya Upah'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 201,

                'kode' => '502.020.0000',
                'nama' => 'Biaya Peralatan',
                'keterangan' => 'Biaya Peralatan'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 202,

                'kode' => '503.020.0000',
                'nama' => 'Biaya Sub Kontraktor',
                'keterangan' => 'Biaya Sub Kontraktor'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 203,

                'kode' => '504.020.0000',
                'nama' => 'Biaya Bank',
                'keterangan' => 'Biaya Bank'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 205,

                'kode' => '506.020.0000',
                'nama' => 'Biaya Penyusutan Aktiva Tetap',
                'keterangan' => 'Biaya Penyusutan Aktiva Tetap'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 206,

                'kode' => '507.020.0000',
                'nama' => 'Biaya Umum Kantor Pusat',
                'keterangan' => 'Biaya Umum Kantor Pusat'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 207,

                'kode' => '508.020.0000',
                'nama' => 'Biaya PPH Final',
                'keterangan' => 'Biaya PPH Final'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 235,

                'kode' => '600.020.0000',
                'nama' => 'Beban Pemasaran',
                'keterangan' => 'Beban Pemasaran'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 236,

                'kode' => '601.020.0000',
                'nama' => 'Gaji Pegawai',
                'keterangan' => 'Gaji Pegawai'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 237,

                'kode' => '602.020.0000',
                'nama' => 'Biaya Jasa Produksi',
                'keterangan' => 'Biaya Jasa Produksi'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 238,

                'kode' => '603.020.0000',
                'nama' => 'Perlengkapan Kantor',
                'keterangan' => 'Perlengkapan Kantor'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 239,

                'kode' => '604.020.0000',
                'nama' => 'Biaya Perjalanan Dinas',
                'keterangan' => 'Biaya Perjalanan Dinas'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 240,

                'kode' => '605.020.0000',
                'nama' => 'Biaya Pengembangan Sistem dan Usaha',
                'keterangan' => 'Biaya Pengembangan Sistem dan Usaha'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 241,

                'kode' => '606.020.0000',
                'nama' => 'Biaya Raker/Rakor',
                'keterangan' => 'Biaya Raker/Rakor'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 242,

                'kode' => '607.020.0000',
                'nama' => 'Penyusutan Gedung',
                'keterangan' => 'Penyusutan Gedung'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 243,

                'kode' => '700.020.0000',
                'nama' => 'Hasil Iuran Wajib',
                'keterangan' => 'Hasil Iuran Wajib'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 244,

                'kode' => '701.020.0000',
                'nama' => 'Hasil Lain-Lain',
                'keterangan' => 'Hasil Lain-Lain'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 247,

                'kode' => '704.020.0000',
                'nama' => 'Pendapatan Jasa Bunga',
                'keterangan' => 'Pendapatan Jasa Bunga'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 248,

                'kode' => '705.020.0000',
                'nama' => 'Pendapatan Sewa Gedung',
                'keterangan' => 'Pendapatan Sewa Gedung'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 249,

                'kode' => '710.020.0000',
                'nama' => 'Pendapatan Luar Biasa',
                'keterangan' => 'Pendapatan Luar Biasa'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 250,

                'kode' => '800.020.0000',
                'nama' => 'Biaya Adm dan Provisi Bank',
                'keterangan' => 'Biaya Adm dan Provisi Bank'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 251,

                'kode' => '801.020.0000',
                'nama' => 'Biaya Luar Biasa',
                'keterangan' => 'Biaya Luar Biasa'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 254,

                'kode' => '804.020.0000',
                'nama' => 'Biaya Bunga Bank',
                'keterangan' => 'Biaya Bunga Bank'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 256,

                'kode' => '810.020.0000',
                'nama' => 'OCI - Selisih Penilaian Kembali Aset Tetap',
                'keterangan' => 'OCI - Selisih Penilaian Kembali Aset Tetap'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 258,

                'kode' => '830.020.0000',
                'nama' => 'Pajak PPH Badan',
                'keterangan' => 'Pajak PPH Badan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 0,
                'id_group_account' => 259,

                'kode' => '900.020.0000',
                'nama' => 'Laba / Rugi Tahun Berjalan',
                'keterangan' => 'Laba / Rugi Tahun Berjalan'
            ],

            // PROYEK NIMO
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 1,

                'kode' => '100.020.0000',
                'nama' => 'Kas Proyek',
                'keterangan' => 'Kas Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 2,

                'kode' => '101.020.0000',
                'nama' => 'Kas Pelaksana Proyek',
                'keterangan' => 'Kas Pelaksana Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 6,

                'kode' => '110.020.0000',
                'nama' => 'Bank Mandiri Proyek',
                'keterangan' => 'Bank Mandiri Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 7,

                'kode' => '111.020.0000',
                'nama' => 'BNI Proyek',
                'keterangan' => 'BNI Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 11,

                'kode' => '115.020.0000',
                'nama' => 'BPD Proyek',
                'keterangan' => 'BPD Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 12,

                'kode' => '116.020.0000',
                'nama' => 'BRI Proyek',
                'keterangan' => 'BRI Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 15,

                'kode' => '119.020.0000',
                'nama' => 'BSI Proyek',
                'keterangan' => 'BSI Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 16,

                'kode' => '11A.020.0000',
                'nama' => 'BII Proyek',
                'keterangan' => 'BII Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 17,

                'kode' => '11B.020.0000',
                'nama' => 'BCA Proyek',
                'keterangan' => 'BCA Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 18,

                'kode' => '11C.020.0000',
                'nama' => 'Bank CIMB Niaga Proyek',
                'keterangan' => 'Bank CIMB Niaga Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 19,

                'kode' => '11D.020.0000',
                'nama' => 'Bank Tabungan Negara Proyek',
                'keterangan' => 'Bank Tabungan Negara Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 20,

                'kode' => '11E.020.0000',
                'nama' => 'Bank Bukopin Proyek',
                'keterangan' => 'Bank Bukopin Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 22,

                'kode' => '11G.020.0000',
                'nama' => 'Bank Finconesia Proyek',
                'keterangan' => 'Bank Finconesia Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 23,

                'kode' => '11H.020.0000',
                'nama' => 'Bank Danamon Proyek',
                'keterangan' => 'Bank Danamon Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 25,

                'kode' => '11J.020.0000',
                'nama' => 'Bank Permata Proyek',
                'keterangan' => 'Bank Permata Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 26,

                'kode' => '11K.020.0000',
                'nama' => 'Bank Panin Proyek',
                'keterangan' => 'Bank Panin Rekening Proyek'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 27,

                'kode' => '120.020.0000',
                'nama' => 'Piutang Pekerjaan',
                'keterangan' => 'Piutang Pekerjaan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 28,

                'kode' => '121.020.0000',
                'nama' => 'Piutang Retensi Pekerjaan',
                'keterangan' => 'Piutang Retensi Pekerjaan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 29,

                'kode' => '122.020.0000',
                'nama' => 'Uang Muka Leveransir',
                'keterangan' => 'Uang Muka Leveransir'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 30,

                'kode' => '123.020.0000',
                'nama' => 'Uang Muka Sub Kontraktor',
                'keterangan' => 'Uang Muka Sub Kontraktor'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 31,

                'kode' => '124.020.0000',
                'nama' => 'Panjar Pelaksana',
                'keterangan' => 'Panjar Pelaksana'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 32,

                'kode' => '125.020.0000',
                'nama' => 'Piutang Jaminan',
                'keterangan' => 'Piutang Jaminan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 33,

                'kode' => '126.020.0000',
                'nama' => 'Piutang Pegawai',
                'keterangan' => 'Piutang Pegawai'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 34,

                'kode' => '127.020.0000',
                'nama' => 'Piutang Joint Operation',
                'keterangan' => 'Piutang Joint Operation'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 35,

                'kode' => '128.020.0000',
                'nama' => 'Piutang Lain-Lain',
                'keterangan' => 'Piutang Lain-Lain'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 36,

                'kode' => '129.020.0000',
                'nama' => 'Penyisihan Piutang',
                'keterangan' => 'Penyisihan Piutang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 37,

                'kode' => '12C.020.0000',
                'nama' => 'Piutang PPN',
                'keterangan' => 'Piutang PPN'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 38,

                'kode' => '130.020.0000',
                'nama' => 'PPH Badan Untuk Tahun Lalu',
                'keterangan' => 'PPH Badan Untuk Tahun Lalu'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 39,

                'kode' => '131.020.0000',
                'nama' => 'PPH Final',
                'keterangan' => 'PPH Final'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 40,

                'kode' => '132.020.0000',
                'nama' => 'PPH Pasal 22',
                'keterangan' => 'PPH Pasal 22'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 41,

                'kode' => '133.020.0000',
                'nama' => 'PPH Pasal 23',
                'keterangan' => 'PPH Pasal 23'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 42,

                'kode' => '134.020.0000',
                'nama' => 'PPH Pasal 24',
                'keterangan' => 'PPH Pasal 24'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 42,

                'kode' => '134.020.0000',
                'nama' => 'PPH Pasal 24',
                'keterangan' => 'PPH Pasal 24'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 43,

                'kode' => '135.020.0000',
                'nama' => 'PPH Pasal 25',
                'keterangan' => 'PPH Pasal 25'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 44,

                'kode' => '136.020.0000',
                'nama' => 'PPN Atas Uang Muka',
                'keterangan' => 'PPN Atas Uang Muka'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 45,

                'kode' => '137.020.0000',
                'nama' => 'Pajak Masukan (PM)',
                'keterangan' => 'Pajak Masukan (PM)'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 46,

                'kode' => '138.020.0000',
                'nama' => 'Piutang PPN',
                'keterangan' => 'Piutang PPN'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 47,

                'kode' => '139.020.0000',
                'nama' => 'PPH Pasal 29',
                'keterangan' => 'PPH Pasal 29'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 48,

                'kode' => '13A.020.0000',
                'nama' => 'PM Untuk PPN Yg Belum Terbit FP',
                'keterangan' => 'PM Untuk PPN Yg Belum Terbit FP'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 49,

                'kode' => '140.020.0000',
                'nama' => 'Persediaan Bahan / Material',
                'keterangan' => 'Persediaan Bahan / Material'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 50,

                'kode' => '141.020.0000',
                'nama' => 'Persediaan Spareparts / Suku Cadang',
                'keterangan' => 'Persediaan Spareparts / Suku Cadang'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 51,

                'kode' => '142.020.0000',
                'nama' => 'Koreksi Persediaan Bahan',
                'keterangan' => 'Koreksi Persediaan Bahan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 52,

                'kode' => '143.020.0000',
                'nama' => 'Koreksi Persediaan Spareparts',
                'keterangan' => 'Koreksi Persediaan Spareparts'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 53,

                'kode' => '144.020.0000',
                'nama' => 'Perbedaan Harga Bahan',
                'keterangan' => 'Perbedaan Harga Bahan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 54,

                'kode' => '145.020.0000',
                'nama' => 'Bangunan Dalam Proses',
                'keterangan' => 'Bangunan Dalam Proses'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 55,

                'kode' => '146.020.0000',
                'nama' => 'Bangunan Selesai',
                'keterangan' => 'Bangunan Selesai'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 56,

                'kode' => '147.020.0000',
                'nama' => 'Persediaan AMP',
                'keterangan' => 'Persediaan AMP'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 57,

                'kode' => '148.020.0000',
                'nama' => 'Persediaan Bahan Batching Plant',
                'keterangan' => 'Persediaan Bahan Batching Plant'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 58,

                'kode' => '150.020.0000',
                'nama' => 'PDP. Kontrak Induk',
                'keterangan' => 'PDP. Kontrak Induk'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 59,

                'kode' => '151.020.0000',
                'nama' => 'PDP. Kontrak Tambah',
                'keterangan' => 'PDP. Kontrak Tambah'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 60,

                'kode' => '152.020.0000',
                'nama' => 'PDP. Eskalasi',
                'keterangan' => 'PDP. Eskalasi'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 61,

                'kode' => '153.020.0000',
                'nama' => 'PDP. Selisih Kurs',
                'keterangan' => 'PDP. Selisih Kurs'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 62,

                'kode' => '160.020.0000',
                'nama' => 'Biaya Yg Dibayar Dimuka',
                'keterangan' => 'Biaya Yg Dibayar Dimuka'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 63,

                'kode' => '161.020.0000',
                'nama' => 'Pendapatan Yg Akan Diterima',
                'keterangan' => 'Pendapatan Yg Akan Diterima'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 64,

                'kode' => '162.020.0000',
                'nama' => 'Uang Muka Pembagian Laba',
                'keterangan' => 'Uang Muka Pembagian Laba'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 65,

                'kode' => '163.020.0000',
                'nama' => 'Rumah & Bangunan Yg Disewakan',
                'keterangan' => 'Rumah & Bangunan Yg Disewakan'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 66,

                'kode' => '164.020.0000',
                'nama' => 'Piutang Jangka Panjang',
                'keterangan' => 'Piutang Jangka Panjang'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 67,

                'kode' => '170.020.0000',
                'nama' => 'Penyertaan Saham',
                'keterangan' => 'Penyertaan Saham'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 68,

                'kode' => '171.020.0000',
                'nama' => 'Piutang Pemegang Saham',
                'keterangan' => 'Piutang Pemegang Saham'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 69,

                'kode' => '172.020.0000',
                'nama' => 'Inv. Pada Ventura Bersama',
                'keterangan' => 'Inv. Pada Ventura Bersama'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 70,

                'kode' => '180.020.0000',
                'nama' => 'Tanah',
                'keterangan' => 'Tanah'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 71,

                'kode' => '181.020.0000',
                'nama' => 'Gedung',
                'keterangan' => 'Gedung'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 72,

                'kode' => '182.020.0000',
                'nama' => 'Mesin / Alat',
                'keterangan' => 'Mesin / Alat'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 73,

                'kode' => '183.020.0000',
                'nama' => 'Alat Angkut / Kendaraan',
                'keterangan' => 'Alat Angkut / Kendaraan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 74,

                'kode' => '184.020.0000',
                'nama' => 'Kantor',
                'keterangan' => 'Kantor'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 75,

                'kode' => '185.020.0000',
                'nama' => 'Mess',
                'keterangan' => 'Mess'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 79,

                'kode' => '190.020.0000',
                'nama' => 'Hak Pengelolaan',
                'keterangan' => 'Hak Pengelolaan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 81,

                'kode' => '1A0.020.0000',
                'nama' => 'Hak Patent',
                'keterangan' => 'Hak Patent'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 95,

                'kode' => '1B9.020.0000',
                'nama' => 'Aktiva Lain-Lain',
                'keterangan' => 'Aktiva Lain-Lain'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 98,

                'kode' => '200.020.0000',
                'nama' => 'Utang Pada Leveransir',
                'keterangan' => 'Utang Pada Leveransir'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 99,

                'kode' => '201.020.0000',
                'nama' => 'Utang Pada Sub Kontraktor',
                'keterangan' => 'Utang Pada Sub Kontraktor'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 100,

                'kode' => '202.020.0000',
                'nama' => 'Uang Muka Bowheer',
                'keterangan' => 'Uang Muka Bowheer'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 101,

                'kode' => '203.020.0000',
                'nama' => 'Utang Deviden / DPS',
                'keterangan' => 'Utang Deviden / DPS'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 102,

                'kode' => '204.020.0000',
                'nama' => 'Utang Tantiem',
                'keterangan' => 'Utang Tantiem'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 103,

                'kode' => '205.020.0000',
                'nama' => 'Utang Leasing',
                'keterangan' => 'Utang Leasing'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 104,

                'kode' => '206.020.0000',
                'nama' => 'Utang Jangka Panjang Lain Yg Lancar',
                'keterangan' => 'Utang Jangka Panjang Lain Yg Lancar'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 105,

                'kode' => '207.020.0000',
                'nama' => 'Utang Astek / THT',
                'keterangan' => 'Utang Astek / THT'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 106,

                'kode' => '208.020.0000',
                'nama' => 'Utang Dana Jasa Produksi',
                'keterangan' => 'Utang Dana Jasa Produksi'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 107,

                'kode' => '209.020.0000',
                'nama' => 'Utang Lain-Lain',
                'keterangan' => 'Utang Lain-Lain'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 108,

                'kode' => '20A.020.0000',
                'nama' => 'Utang PPN Leveransir',
                'keterangan' => 'Utang PPN Leveransir'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 129,

                'kode' => '221.020.0000',
                'nama' => 'PPH Pasal 21',
                'keterangan' => 'PPH Pasal 21'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 130,

                'kode' => '222.020.0000',
                'nama' => 'PPH Pasal 22',
                'keterangan' => 'PPH Pasal 22'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 131,

                'kode' => '223.020.0000',
                'nama' => 'PPH Pasal 23',
                'keterangan' => 'PPH Pasal 23'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 132,

                'kode' => '224.020.0000',
                'nama' => 'PPN Yang Dihitung',
                'keterangan' => 'PPN Yang Dihitung'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 133,

                'kode' => '225.020.0000',
                'nama' => 'PPH Pasal 25',
                'keterangan' => 'PPH Pasal 25'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 134,

                'kode' => '226.020.0000',
                'nama' => 'PPH Pasal 26',
                'keterangan' => 'PPH Pasal 26'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 135,

                'kode' => '227.020.0000',
                'nama' => 'Pajak Keluaran',
                'keterangan' => 'Pajak Keluaran'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 136,

                'kode' => '228.020.0000',
                'nama' => 'PPH Final Rekanan',
                'keterangan' => 'PPH Final Rekanan'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 137,

                'kode' => '229.020.0000',
                'nama' => 'Utang PPN',
                'keterangan' => 'Utang PPN'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 141,

                'kode' => '22D.020.0000',
                'nama' => 'Utang PPH Final',
                'keterangan' => 'Utang PPH Final'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 142,

                'kode' => '230.020.0000',
                'nama' => 'Biaya Yang Akan Dibayar',
                'keterangan' => 'Biaya Yang Akan Dibayar'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 143,

                'kode' => '231.020.0000',
                'nama' => 'Pendapatan Yg Diterima Dimuka',
                'keterangan' => 'Pendapatan Yg Diterima Dimuka'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 144,

                'kode' => '232.020.0000',
                'nama' => 'Hutang Bunga Bank',
                'keterangan' => 'Hutang Bunga Bank'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 145,

                'kode' => '233.020.0000',
                'nama' => 'Cadangan Insentif',
                'keterangan' => 'Cadangan Insentif'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 150,

                'kode' => '250.020.0000',
                'nama' => 'Hutang Bank',
                'keterangan' => 'Hutang Bank'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 160,

                'kode' => '260.020.0000',
                'nama' => 'Pos Silang Kas-Bank',
                'keterangan' => 'Pos Silang Kas-Bank'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 161,

                'kode' => '261.020.0000',
                'nama' => 'Pos Silang Antar Bank',
                'keterangan' => 'Pos Silang Antar Bank'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 162,

                'kode' => '262.020.0000',
                'nama' => 'Pos Silang Kas Pel.-Bank',
                'keterangan' => 'Pos Silang Kas Pel.-Bank'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 163,

                'kode' => '263.020.0000',
                'nama' => 'Pos Silang Bank-Kas Pel.',
                'keterangan' => 'Pos Silang Bank-Kas Pel.'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 166,

                'kode' => '271.020.0000',
                'nama' => 'R/K Cabang Dengan Kantor Pusat',
                'keterangan' => 'R/K Cabang Dengan Kantor Pusat'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 167,

                'kode' => '272.020.0000',
                'nama' => 'R/K Kantor Pusat Dengan Cabang',
                'keterangan' => 'R/K Kantor Pusat Dengan Cabang'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 173,

                'kode' => '300.020.0000',
                'nama' => 'Modal Dasar',
                'keterangan' => 'Modal Dasar'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 174,

                'kode' => '301.020.0000',
                'nama' => 'Agio / Disagio',
                'keterangan' => 'Agio / Disagio'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 175,

                'kode' => '302.020.0000',
                'nama' => 'Modal Dalam Pesanan',
                'keterangan' => 'Modal Dalam Pesanan'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 176,

                'kode' => '303.020.0000',
                'nama' => 'Cadangan',
                'keterangan' => 'Cadangan'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 179,

                'kode' => '306.020.0000',
                'nama' => 'Selisih Penilaian Aktiva',
                'keterangan' => 'Selisih Penilaian Aktiva'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 180,

                'kode' => '310.020.0000',
                'nama' => 'Saldo Laba Tahun Lalu',
                'keterangan' => 'Saldo Laba Tahun Lalu'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 181,

                'kode' => '320.020.0000',
                'nama' => 'Saldo Laba Tahun Berjalan',
                'keterangan' => 'Saldo Laba Tahun Berjalan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 182,

                'kode' => '400.020.0000',
                'nama' => 'Pendapatan Usaha Konstruksi',
                'keterangan' => 'Pendapatan Usaha Konstruksi'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 187,

                'kode' => '410.020.0000',
                'nama' => 'Pendapatan Usaha Konstruksi JO',
                'keterangan' => 'Pendapatan Usaha Konstruksi JO'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 196,

                'kode' => '420.020.0000',
                'nama' => 'Hasil Penjualan Property',
                'keterangan' => 'Hasil Penjualan Property'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 197,

                'kode' => '430.020.0000',
                'nama' => 'Hasil Penjualan Barang / Trading',
                'keterangan' => 'Hasil Penjualan Barang / Trading'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 198,

                'kode' => '440.020.0000',
                'nama' => 'Hasil Usaha Sewa Property / Peralatan',
                'keterangan' => 'Hasil Usaha Sewa Property / Peralatan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 199,

                'kode' => '500.020.0000',
                'nama' => 'Biaya Bahan',
                'keterangan' => 'Biaya Bahan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 200,

                'kode' => '501.020.0000',
                'nama' => 'Biaya Upah',
                'keterangan' => 'Biaya Upah'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 201,

                'kode' => '502.020.0000',
                'nama' => 'Biaya Peralatan',
                'keterangan' => 'Biaya Peralatan'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 202,

                'kode' => '503.020.0000',
                'nama' => 'Biaya Sub Kontraktor',
                'keterangan' => 'Biaya Sub Kontraktor'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 203,

                'kode' => '504.020.0000',
                'nama' => 'Biaya Bank',
                'keterangan' => 'Biaya Bank'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 205,

                'kode' => '506.020.0000',
                'nama' => 'Biaya Penyusutan Aktiva Tetap',
                'keterangan' => 'Biaya Penyusutan Aktiva Tetap'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 206,

                'kode' => '507.020.0000',
                'nama' => 'Biaya Umum Kantor Pusat',
                'keterangan' => 'Biaya Umum Kantor Pusat'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 207,

                'kode' => '508.020.0000',
                'nama' => 'Biaya PPH Final',
                'keterangan' => 'Biaya PPH Final'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 235,

                'kode' => '600.020.0000',
                'nama' => 'Beban Pemasaran',
                'keterangan' => 'Beban Pemasaran'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 236,

                'kode' => '601.020.0000',
                'nama' => 'Gaji Pegawai',
                'keterangan' => 'Gaji Pegawai'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 237,

                'kode' => '602.020.0000',
                'nama' => 'Biaya Jasa Produksi',
                'keterangan' => 'Biaya Jasa Produksi'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 238,

                'kode' => '603.020.0000',
                'nama' => 'Perlengkapan Kantor',
                'keterangan' => 'Perlengkapan Kantor'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 239,

                'kode' => '604.020.0000',
                'nama' => 'Biaya Perjalanan Dinas',
                'keterangan' => 'Biaya Perjalanan Dinas'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 240,

                'kode' => '605.020.0000',
                'nama' => 'Biaya Pengembangan Sistem dan Usaha',
                'keterangan' => 'Biaya Pengembangan Sistem dan Usaha'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 241,

                'kode' => '606.020.0000',
                'nama' => 'Biaya Raker/Rakor',
                'keterangan' => 'Biaya Raker/Rakor'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 242,

                'kode' => '607.020.0000',
                'nama' => 'Penyusutan Gedung',
                'keterangan' => 'Penyusutan Gedung'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 243,

                'kode' => '700.020.0000',
                'nama' => 'Hasil Iuran Wajib',
                'keterangan' => 'Hasil Iuran Wajib'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 244,

                'kode' => '701.020.0000',
                'nama' => 'Hasil Lain-Lain',
                'keterangan' => 'Hasil Lain-Lain'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 247,

                'kode' => '704.020.0000',
                'nama' => 'Pendapatan Jasa Bunga',
                'keterangan' => 'Pendapatan Jasa Bunga'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 248,

                'kode' => '705.020.0000',
                'nama' => 'Pendapatan Sewa Gedung',
                'keterangan' => 'Pendapatan Sewa Gedung'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 249,

                'kode' => '710.020.0000',
                'nama' => 'Pendapatan Luar Biasa',
                'keterangan' => 'Pendapatan Luar Biasa'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 250,

                'kode' => '800.020.0000',
                'nama' => 'Biaya Adm dan Provisi Bank',
                'keterangan' => 'Biaya Adm dan Provisi Bank'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 251,

                'kode' => '801.020.0000',
                'nama' => 'Biaya Luar Biasa',
                'keterangan' => 'Biaya Luar Biasa'
            ], [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 254,

                'kode' => '804.020.0000',
                'nama' => 'Biaya Bunga Bank',
                'keterangan' => 'Biaya Bunga Bank'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 256,

                'kode' => '810.020.0000',
                'nama' => 'OCI - Selisih Penilaian Kembali Aset Tetap',
                'keterangan' => 'OCI - Selisih Penilaian Kembali Aset Tetap'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 258,

                'kode' => '830.020.0000',
                'nama' => 'Pajak PPH Badan',
                'keterangan' => 'Pajak PPH Badan'
            ],
            [
                'id_cabang' => 3,
                'id_proyek' => 2,
                'id_group_account' => 259,

                'kode' => '900.020.0000',
                'nama' => 'Laba / Rugi Tahun Berjalan',
                'keterangan' => 'Laba / Rugi Tahun Berjalan'
            ],
        ];

        foreach ($kodePerkiraans as $kodePerkiraan) {
            KodePerkiraan::create($kodePerkiraan);
        }
    }
}
