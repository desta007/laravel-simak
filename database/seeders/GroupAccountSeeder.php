<?php

namespace Database\Seeders;

use App\Models\GroupAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groupAccounts = [
            [
                'kode' => '100',
                'nama' => 'Kas Kantor',
                'jenis' => 'D'
            ],
            [
                'kode' => '101',
                'nama' => 'Kas Pelaksana',
                'jenis' => 'D'
            ],
            [
                'kode' => '102',
                'nama' => 'Selisih Kas Kantor',
                'jenis' => 'D'
            ],
            [
                'kode' => '103',
                'nama' => 'Selisih Kas Pelaksana',
                'jenis' => 'D'
            ],
            [
                'kode' => '106',
                'nama' => 'Uang Dalam Perjalanan',
                'jenis' => 'D'
            ],
            [
                'kode' => '110',
                'nama' => 'Bank Mandiri',
                'jenis' => 'D'
            ],
            [
                'kode' => '111',
                'nama' => 'Bank Negara Indonesia-46',
                'jenis' => 'D'
            ],
            [
                'kode' => '112',
                'nama' => 'Bank Mandiri Eks. BBD',
                'jenis' => 'D'
            ],
            [
                'kode' => '113',
                'nama' => 'Bank Mandiri Eks. BDN',
                'jenis' => 'D'
            ],
            [
                'kode' => '114',
                'nama' => 'Bank Mandiri Eks. Exim',
                'jenis' => 'D'
            ],
            [
                'kode' => '115',
                'nama' => 'Bank Pembangunan Daerah',
                'jenis' => 'D'
            ],
            [
                'kode' => '116',
                'nama' => 'Bank Rakyat Indonesia',
                'jenis' => 'D'
            ],
            [
                'kode' => '117',
                'nama' => 'Surat Berharga',
                'jenis' => 'D'
            ],
            [
                'kode' => '118',
                'nama' => 'Deposito Jangka Pendek',
                'jenis' => 'D'
            ],
            [
                'kode' => '119',
                'nama' => 'Bank Syariah Indonesia',
                'jenis' => 'D'
            ],
            [
                'kode' => '11A',
                'nama' => 'Bank Internasional Indonesia',
                'jenis' => 'D'
            ],
            [
                'kode' => '11B',
                'nama' => 'Bank Central Asia',
                'jenis' => 'D'
            ],
            [
                'kode' => '11C',
                'nama' => 'Bank CIMB Niaga',
                'jenis' => 'D'
            ],
            [
                'kode' => '11D',
                'nama' => 'Bank Tabungan Negara',
                'jenis' => 'D'
            ],
            [
                'kode' => '11E',
                'nama' => 'Bank Bukopin',
                'jenis' => 'D'
            ],
            [
                'kode' => '11F',
                'nama' => 'Bank Dagang Bali',
                'jenis' => 'D'
            ],
            [
                'kode' => '11G',
                'nama' => 'Bank Finconesia',
                'jenis' => 'D'
            ],
            [
                'kode' => '11H',
                'nama' => 'Bank Danamon',
                'jenis' => 'D'
            ],
            [
                'kode' => '11I',
                'nama' => 'Bank Bukopin-Pasif',
                'jenis' => 'D'
            ],
            [
                'kode' => '11J',
                'nama' => 'Bank Permata',
                'jenis' => 'D'
            ],
            [
                'kode' => '11K',
                'nama' => 'Bank Panin',
                'jenis' => 'D'
            ],
            [
                'kode' => '120',
                'nama' => 'Piutang Pekerjaan',
                'jenis' => 'D'
            ],
            [
                'kode' => '121',
                'nama' => 'Piutang Retensi Pekerjaan',
                'jenis' => 'D'
            ],
            [
                'kode' => '122',
                'nama' => 'Uang Muka Leveransir',
                'jenis' => 'D'
            ],
            [
                'kode' => '123',
                'nama' => 'Uang Muka Sub Kontraktor',
                'jenis' => 'D'
            ],
            [
                'kode' => '124',
                'nama' => 'Panjar Pelaksana',
                'jenis' => 'D'
            ],
            [
                'kode' => '125',
                'nama' => 'Piutang Jaminan',
                'jenis' => 'D'
            ],
            [
                'kode' => '126',
                'nama' => 'Piutang Pegawai',
                'jenis' => 'D'
            ],
            [
                'kode' => '127',
                'nama' => 'Piutang Joint Operation',
                'jenis' => 'D'
            ],
            [
                'kode' => '128',
                'nama' => 'Piutang Lain-Lain',
                'jenis' => 'D'
            ],
            [
                'kode' => '129',
                'nama' => 'Penyisihan Piutang',
                'jenis' => 'D'
            ],
            [
                'kode' => '12C',
                'nama' => 'Piutang PPN',
                'jenis' => 'D'
            ],
            [
                'kode' => '130',
                'nama' => 'PPH Badan Untuk Tahun Lalu',
                'jenis' => 'D'
            ],
            [
                'kode' => '131',
                'nama' => 'PPH Final',
                'jenis' => 'D'
            ],
            [
                'kode' => '132',
                'nama' => 'PPH Pasal 22',
                'jenis' => 'D'
            ],
            [
                'kode' => '133',
                'nama' => 'PPH Pasal 23',
                'jenis' => 'D'
            ],
            [
                'kode' => '134',
                'nama' => 'PPH Pasal 24',
                'jenis' => 'D'
            ],
            [
                'kode' => '135',
                'nama' => 'PPH Pasal 25',
                'jenis' => 'D'
            ],
            [
                'kode' => '136',
                'nama' => 'PPN Atas Uang Muka',
                'jenis' => 'D'
            ],
            [
                'kode' => '137',
                'nama' => 'Pajak Masukan (PM)',
                'jenis' => 'D'
            ],
            [
                'kode' => '138',
                'nama' => 'Piutang PPN',
                'jenis' => 'D'
            ],
            [
                'kode' => '139',
                'nama' => 'PPH Pasal 29',
                'jenis' => 'D'
            ],
            [
                'kode' => '13A',
                'nama' => 'PM Untuk PPN Yg Belum Terbit FP',
                'jenis' => 'D'
            ],
            [
                'kode' => '140',
                'nama' => 'Persediaan Bahan / Material',
                'jenis' => 'D'
            ],
            [
                'kode' => '141',
                'nama' => 'Persediaan Spareparts / Suku Cadang',
                'jenis' => 'D'
            ],
            [
                'kode' => '142',
                'nama' => 'Koreksi Persediaan Bahan',
                'jenis' => 'D'
            ],
            [
                'kode' => '143',
                'nama' => 'Koreksi Persediaan Spareparts',
                'jenis' => 'D'
            ],
            [
                'kode' => '144',
                'nama' => 'Perbedaan Harga Bahan',
                'jenis' => 'D'
            ],
            [
                'kode' => '145',
                'nama' => 'Bangunan Dalam Proses',
                'jenis' => 'D'
            ],
            [
                'kode' => '146',
                'nama' => 'Bangunan Selesai',
                'jenis' => 'D'
            ],
            [
                'kode' => '147',
                'nama' => 'Persediaan AMP',
                'jenis' => 'D'
            ],
            [
                'kode' => '148',
                'nama' => 'Persediaan Bahan Batching Plant',
                'jenis' => 'D'
            ],
            [
                'kode' => '150',
                'nama' => 'PDP. Kontrak Induk',
                'jenis' => 'D'
            ],
            [
                'kode' => '151',
                'nama' => 'PDP. Kontrak Tambah',
                'jenis' => 'D'
            ],
            [
                'kode' => '152',
                'nama' => 'PDP. Eskalasi',
                'jenis' => 'D'
            ],
            [
                'kode' => '153',
                'nama' => 'PDP. Selisih Kurs',
                'jenis' => 'D'
            ],
            [
                'kode' => '160',
                'nama' => 'Biaya Yg Dibayar Dimuka',
                'jenis' => 'D'
            ],
            [
                'kode' => '161',
                'nama' => 'Pendapatan Yg Akan Diterima',
                'jenis' => 'D'
            ],
            [
                'kode' => '162',
                'nama' => 'Uang Muka Pembagian Laba',
                'jenis' => 'D'
            ],
            [
                'kode' => '163',
                'nama' => 'Rumah & Bangunan Yg Disewakan',
                'jenis' => 'D'
            ],
            [
                'kode' => '164',
                'nama' => 'Piutang Jangka Panjang',
                'jenis' => 'D'
            ],
            [
                'kode' => '170',
                'nama' => 'Penyertaan Saham',
                'jenis' => 'D'
            ],
            [
                'kode' => '171',
                'nama' => 'Piutang Pemegang Saham',
                'jenis' => 'D'
            ],
            [
                'kode' => '172',
                'nama' => 'Inv. Pada Ventura Bersama',
                'jenis' => 'D'
            ],
            [
                'kode' => '180',
                'nama' => 'Tanah',
                'jenis' => 'D'
            ],
            [
                'kode' => '181',
                'nama' => 'Gedung',
                'jenis' => 'D'
            ],
            [
                'kode' => '182',
                'nama' => 'Mesin / Alat',
                'jenis' => 'D'
            ],
            [
                'kode' => '183',
                'nama' => 'Alat Angkut / Kendaraan',
                'jenis' => 'D'
            ],
            [
                'kode' => '184',
                'nama' => 'Kantor',
                'jenis' => 'D'
            ],
            [
                'kode' => '185',
                'nama' => 'Mess',
                'jenis' => 'D'
            ],
            [
                'kode' => '186',
                'nama' => 'Mesin / Alat Dlm Leasing',
                'jenis' => 'D'
            ],
            [
                'kode' => '187',
                'nama' => 'Kendaraan Dlm Leasing / Angsuran',
                'jenis' => 'D'
            ],
            [
                'kode' => '188',
                'nama' => 'Investasi Dlm Pelaksanaan',
                'jenis' => 'D'
            ],
            [
                'kode' => '190',
                'nama' => 'Hak Pengelolaan',
                'jenis' => 'D'
            ],
            [
                'kode' => '191',
                'nama' => 'Aset Dalam Proses',
                'jenis' => 'D'
            ],
            [
                'kode' => '1A0',
                'nama' => 'Hak Patent',
                'jenis' => 'D'
            ],

            [
                'kode' => '1A1',
                'nama' => 'Franchise',
                'jenis' => 'D'
            ],
            [
                'kode' => '1A2',
                'nama' => 'Goodwill',
                'jenis' => 'D'
            ],
            [
                'kode' => '1A3',
                'nama' => 'Hak Konsesi',
                'jenis' => 'D'
            ],
            [
                'kode' => '1A4',
                'nama' => 'Software',
                'jenis' => 'D'
            ],
            [
                'kode' => '1B0',
                'nama' => 'Biaya Pendirian',
                'jenis' => 'D'
            ],
            [
                'kode' => '1B1',
                'nama' => 'Biaya Penelitian',
                'jenis' => 'D'
            ],
            [
                'kode' => '1B2',
                'nama' => 'Persediaan Properti',
                'jenis' => 'D'
            ],
            [
                'kode' => '1B3',
                'nama' => 'Aktiva Tetap Yg Diafkir',
                'jenis' => 'D'
            ],
            [
                'kode' => '1B4',
                'nama' => 'Set Jam Listrik, Air, Dll',
                'jenis' => 'D'
            ],
            [
                'kode' => '1B5',
                'nama' => 'Properti Investasi',
                'jenis' => 'D'
            ],

            // ---
            [
                'kode' => '1B6',
                'nama' => 'Dana Talangan YDP',
                'jenis' => 'D'
            ],
            [
                'kode' => '1B7',
                'nama' => 'Persediaan Tdk Bermanfaat',
                'jenis' => 'D'
            ],
            [
                'kode' => '1B8',
                'nama' => 'Biaya Perencanaan Gedung',
                'jenis' => 'D'
            ],
            [
                'kode' => '1B9',
                'nama' => 'Aktiva Lain-Lain',
                'jenis' => 'D'
            ],
            [
                'kode' => '1BA',
                'nama' => 'Biaya Ditangguhkan',
                'jenis' => 'D'
            ],
            [
                'kode' => '1BI',
                'nama' => 'Aktiva Pajak Tangguhan',
                'jenis' => 'D'
            ],
            [
                'kode' => '200',
                'nama' => 'Utang Pada Leveransir',
                'jenis' => 'K'
            ],
            [
                'kode' => '201',
                'nama' => 'Utang Pada Sub Kontraktor',
                'jenis' => 'K'
            ],
            [
                'kode' => '202',
                'nama' => 'Uang Muka Bowheer',
                'jenis' => 'K'
            ],
            [
                'kode' => '203',
                'nama' => 'Utang Deviden / DPS',
                'jenis' => 'K'
            ],
            [
                'kode' => '204',
                'nama' => 'Utang Tantiem',
                'jenis' => 'K'
            ],

            [
                'kode' => '205',
                'nama' => 'Utang Leasing',
                'jenis' => 'K'
            ],
            [
                'kode' => '206',
                'nama' => 'Utang Jangka Panjang Lain Yg Lancar',
                'jenis' => 'K'
            ],
            [
                'kode' => '207',
                'nama' => 'Utang Astek / THT',
                'jenis' => 'K'
            ],
            [
                'kode' => '208',
                'nama' => 'Utang Dana Jasa Produksi',
                'jenis' => 'K'
            ],
            [
                'kode' => '209',
                'nama' => 'Utang Lain-Lain',
                'jenis' => 'K'
            ],
            [
                'kode' => '20A',
                'nama' => 'Utang PPN Leveransir',
                'jenis' => 'K'
            ],
            [
                'kode' => '20B',
                'nama' => 'Utang PPN Subkontraktor',
                'jenis' => 'K'
            ],
            [
                'kode' => '20P',
                'nama' => 'Utang PPN MGGR 10 / Sdh Lapor',
                'jenis' => 'K'
            ],
            [
                'kode' => '210',
                'nama' => 'Kredit Bank Pembangunan Indonesia',
                'jenis' => 'K'
            ],
            [
                'kode' => '211',
                'nama' => 'Kredit BNI 46',
                'jenis' => 'K'
            ],
            [
                'kode' => '212',
                'nama' => 'Kredit PT. SMI',
                'jenis' => 'K'
            ],
            [
                'kode' => '213',
                'nama' => 'Kredit Bank Mandiri',
                'jenis' => 'K'
            ],
            [
                'kode' => '214',
                'nama' => 'Kredit Bank Ekspor Impor Indonesia',
                'jenis' => 'K'
            ],
            [
                'kode' => '215',
                'nama' => 'Kredit BPD',
                'jenis' => 'K'
            ],
            [
                'kode' => '216',
                'nama' => 'Kredit Bank Rakyat Indonesia',
                'jenis' => 'K'
            ],
            [
                'kode' => '217',
                'nama' => 'Kredit Non Bank',
                'jenis' => 'K'
            ],
            [
                'kode' => '218',
                'nama' => 'Kredit Bank Agris',
                'jenis' => 'K'
            ],
            [
                'kode' => '219',
                'nama' => 'Kredit Bank Niaga',
                'jenis' => 'K'
            ],
            [
                'kode' => '21A',
                'nama' => 'Kredit Bank Internasional Indonesia',
                'jenis' => 'K'
            ],
            [
                'kode' => '21B',
                'nama' => 'Kredit Danareksa',
                'jenis' => 'K'
            ],
            [
                'kode' => '21C',
                'nama' => 'Kredit PPA Finance',
                'jenis' => 'K'
            ],
            [
                'kode' => '21D',
                'nama' => 'Kredit Bank BTN',
                'jenis' => 'K'
            ],
            [
                'kode' => '21E',
                'nama' => 'Kredit PPA',
                'jenis' => 'K'
            ],
            [
                'kode' => '21F',
                'nama' => 'Kredit Bank Syariah',
                'jenis' => 'K'
            ],
            [
                'kode' => '21I',
                'nama' => 'Kredit Bank Bukopin',
                'jenis' => 'K'
            ],
            [
                'kode' => '220',
                'nama' => 'Cadangan PPH Badan',
                'jenis' => 'K'
            ],
            [
                'kode' => '221',
                'nama' => 'PPH Pasal 21',
                'jenis' => 'K'
            ],
            [
                'kode' => '222',
                'nama' => 'PPH Pasal 22',
                'jenis' => 'K'
            ],
            [
                'kode' => '223',
                'nama' => 'PPH Pasal 23',
                'jenis' => 'K'
            ],
            [
                'kode' => '224',
                'nama' => 'PPN Yang Dihitung',
                'jenis' => 'K'
            ],
            [
                'kode' => '225',
                'nama' => 'PPH Pasal 25',
                'jenis' => 'K'
            ],
            [
                'kode' => '226',
                'nama' => 'PPH Pasal 26',
                'jenis' => 'K'
            ],
            [
                'kode' => '227',
                'nama' => 'Pajak Keluaran',
                'jenis' => 'K'
            ],
            [
                'kode' => '228',
                'nama' => 'PPH Final Rekanan',
                'jenis' => 'K'
            ],
            [
                'kode' => '229',
                'nama' => 'Utang PPN',
                'jenis' => 'K'
            ],
            [
                'kode' => '22A',
                'nama' => 'Utang PPN Rekanan',
                'jenis' => 'K'
            ],
            [
                'kode' => '22B',
                'nama' => 'Utang PPN Sub Kontraktor',
                'jenis' => 'K'
            ],
            [
                'kode' => '22C',
                'nama' => 'PPH 22 Ditg. Pem. Yg Dihitung',
                'jenis' => 'K'
            ],
            [
                'kode' => '22D',
                'nama' => 'Utang PPH Final',
                'jenis' => 'K'
            ],
            [
                'kode' => '230',
                'nama' => 'Biaya Yang Akan Dibayar',
                'jenis' => 'K'
            ],
            [
                'kode' => '231',
                'nama' => 'Pendapatan Yg Diterima Dimuka',
                'jenis' => 'K'
            ],
            [
                'kode' => '232',
                'nama' => 'Hutang Bunga Bank',
                'jenis' => 'K'
            ],
            [
                'kode' => '233',
                'nama' => 'Cadangan Insentif',
                'jenis' => 'K'
            ],
            [
                'kode' => '234',
                'nama' => 'Cadangan KAP & Konsinyering',
                'jenis' => 'K'
            ],
            [
                'kode' => '240',
                'nama' => 'Utang Lain-Lain (Jangka Pendek)',
                'jenis' => 'K'
            ],
            [
                'kode' => '241',
                'nama' => 'Hutang Retensi Subkontraktor',
                'jenis' => 'K'
            ],
            [
                'kode' => '242',
                'nama' => 'Hutang Pada Ventura Bersama',
                'jenis' => 'K'
            ],
            [
                'kode' => '250',
                'nama' => 'Kredit Bank Jangka Panjang',
                'jenis' => 'K'
            ],
            [
                'kode' => '251',
                'nama' => 'Kredit Bank',
                'jenis' => 'K'
            ],
            [
                'kode' => '252',
                'nama' => 'Utang Leasing',
                'jenis' => 'K'
            ],
            [
                'kode' => '253',
                'nama' => 'Obligasi',
                'jenis' => 'K'
            ],
            [
                'kode' => '254',
                'nama' => 'Retensi Jangka Panjang',
                'jenis' => 'K'
            ],
            [
                'kode' => '255',
                'nama' => 'Hutang PIP',
                'jenis' => 'K'
            ],
            [
                'kode' => '256',
                'nama' => 'UM Jangka Panjang Lainnya',
                'jenis' => 'K'
            ],
            [
                'kode' => '257',
                'nama' => 'Imbalan Pasca Kerja',
                'jenis' => 'K'
            ],
            [
                'kode' => '258',
                'nama' => 'Liabilitas Pajak Tangguhan',
                'jenis' => 'K'
            ],
            [
                'kode' => '259',
                'nama' => 'Utang Jangka Panjang Lainnya',
                'jenis' => 'K'
            ],
            [
                'kode' => '260',
                'nama' => 'Pos Silang Kas-Bank',
                'jenis' => 'K'
            ],
            [
                'kode' => '261',
                'nama' => 'Pos Silang Antar Bank',
                'jenis' => 'K'
            ],
            [
                'kode' => '262',
                'nama' => 'Pos Silang Kas Pel.-Bank',
                'jenis' => 'K'
            ],
            [
                'kode' => '263',
                'nama' => 'Pos Silang Bank-Kas Pel.',
                'jenis' => 'K'
            ],
            [
                'kode' => '264',
                'nama' => 'Pos Perantara',
                'jenis' => 'K'
            ],
            [
                'kode' => '270',
                'nama' => 'Dana Pensiun Pegawai',
                'jenis' => 'K'
            ],
            [
                'kode' => '271',
                'nama' => 'R/K Dengan Kantor Pusat',
                'jenis' => 'K'
            ],
            [
                'kode' => '272',
                'nama' => 'R/K Wilayah/Cabang',
                'jenis' => 'K'
            ],
            [
                'kode' => '274',
                'nama' => 'Pajak Tangguhan',
                'jenis' => 'K'
            ],
            [
                'kode' => '275',
                'nama' => 'Utang Lain-Lainnya',
                'jenis' => 'K'
            ],
            [
                'kode' => '280',
                'nama' => 'Selisih Nilai Kurs',
                'jenis' => 'K'
            ],
            [
                'kode' => '281',
                'nama' => 'Selisih Nilai Tukar',
                'jenis' => 'K'
            ],
            [
                'kode' => '282',
                'nama' => 'Selisih Harga Aktiva',
                'jenis' => 'K'
            ],
            [
                'kode' => '300',
                'nama' => 'Modal Dasar',
                'jenis' => 'K'
            ],
            [
                'kode' => '301',
                'nama' => 'Agio / Disagio',
                'jenis' => 'K'
            ],
            [
                'kode' => '302',
                'nama' => 'Modal Dalam Pesanan',
                'jenis' => 'K'
            ],
            [
                'kode' => '303',
                'nama' => 'Cadangan',
                'jenis' => 'K'
            ],
            [
                'kode' => '304',
                'nama' => 'Cadangan Umum',
                'jenis' => 'K'
            ],
            [
                'kode' => '305',
                'nama' => 'Cadangan Bertujuan',
                'jenis' => 'K'
            ],
            [
                'kode' => '306',
                'nama' => 'Selisih Penilaian Aktiva',
                'jenis' => 'K'
            ],
            [
                'kode' => '310',
                'nama' => 'Saldo Laba Tahun Lalu',
                'jenis' => 'K'
            ],
            [
                'kode' => '320',
                'nama' => 'Saldo Laba Tahun Berjalan',
                'jenis' => 'K'
            ],
            [
                'kode' => '400',
                'nama' => 'Pendapatan Usaha (PU) Proyek Kontrak Induk',
                'jenis' => 'K'
            ],
            [
                'kode' => '401',
                'nama' => 'Pendapatan Usaha (PU) Proyek Kontrak Tambah',
                'jenis' => 'K'
            ],
            [
                'kode' => '402',
                'nama' => 'PU Eskalasi',
                'jenis' => 'K'
            ],
            [
                'kode' => '403',
                'nama' => 'PU Selisih Kurs',
                'jenis' => 'K'
            ],
            [
                'kode' => '404',
                'nama' => 'PU Bunga / Jasa Giro',
                'jenis' => 'K'
            ],
            [
                'kode' => '410',
                'nama' => 'Hasil Kontrak Induk Vent. Bersama',
                'jenis' => 'K'
            ],
            [
                'kode' => '411',
                'nama' => 'Hasil Pekerjaan Tambah Vent. Bersama',
                'jenis' => 'K'
            ],
            [
                'kode' => '412',
                'nama' => 'Hasil Eskalasi Vent. Bersama',
                'jenis' => 'K'
            ],
            [
                'kode' => '413',
                'nama' => 'Hasil Selisih Kurs Vent. Bersama',
                'jenis' => 'K'
            ],
            [
                'kode' => '414',
                'nama' => 'Hasil Billing Rate Vent. Bersama',
                'jenis' => 'K'
            ],
            [
                'kode' => '415',
                'nama' => 'Hasil Lain-Lain Vent. Bersama',
                'jenis' => 'K'
            ],
            [
                'kode' => '416',
                'nama' => 'Hasil Sewa Alat',
                'jenis' => 'K'
            ],
            [
                'kode' => '417',
                'nama' => 'Hasil Seconded B. Rate Trio',
                'jenis' => 'K'
            ],
            [
                'kode' => '418',
                'nama' => 'Hasil Sel. Kurs Eks. Pusat',
                'jenis' => 'K'
            ],
            [
                'kode' => '420',
                'nama' => 'Hasil Penjualan Property',
                'jenis' => 'K'
            ],
            [
                'kode' => '430',
                'nama' => 'Hasil Penjualan Barang / Trading',
                'jenis' => 'K'
            ],
            [
                'kode' => '440',
                'nama' => 'Hasil Usaha Sewa Property / Peralatan',
                'jenis' => 'K'
            ],
            [
                'kode' => '500',
                'nama' => 'Biaya Bahan',
                'jenis' => 'D'
            ],
            [
                'kode' => '501',
                'nama' => 'Biaya Upah',
                'jenis' => 'D'
            ],
            [
                'kode' => '502',
                'nama' => 'Biaya Peralatan',
                'jenis' => 'D'
            ],
            [
                'kode' => '503',
                'nama' => 'Biaya Sub Kontraktor',
                'jenis' => 'D'
            ],
            [
                'kode' => '504',
                'nama' => 'Biaya Bank',
                'jenis' => 'D'
            ],
            [
                'kode' => '505',
                'nama' => 'Biaya Umum Proyek',
                'jenis' => 'D'
            ],
            [
                'kode' => '506',
                'nama' => 'Biaya Penyusutan Aktiva Tetap',
                'jenis' => 'D'
            ],
            [
                'kode' => '507',
                'nama' => 'Biaya Umum Kantor Pusat',
                'jenis' => 'D'
            ],
            [
                'kode' => '508',
                'nama' => 'Biaya PPH Final 3%',
                'jenis' => 'D'
            ],
            [
                'kode' => '510',
                'nama' => 'Biaya Bahan JO',
                'jenis' => 'D'
            ],
            [
                'kode' => '511',
                'nama' => 'Biaya Upah JO',
                'jenis' => 'D'
            ],
            [
                'kode' => '512',
                'nama' => 'Biaya Peralatan JO',
                'jenis' => 'D'
            ],
            [
                'kode' => '513',
                'nama' => 'Biaya Sub Kontraktor JO',
                'jenis' => 'D'
            ],
            [
                'kode' => '514',
                'nama' => 'Biaya Bank JO',
                'jenis' => 'D'
            ],
            [
                'kode' => '515',
                'nama' => 'Biaya Overhead JO',
                'jenis' => 'D'
            ],
            [
                'kode' => '516',
                'nama' => 'Biaya Penyusutan JO',
                'jenis' => 'D'
            ],
            [
                'kode' => '517',
                'nama' => 'Biaya Umum Kantor Pusat JO',
                'jenis' => 'D'
            ],
            [
                'kode' => '518',
                'nama' => 'Selisih HPP Standard',
                'jenis' => 'D'
            ],
            [
                'kode' => '520',
                'nama' => 'Biaya Bahan Property',
                'jenis' => 'D'
            ],
            [
                'kode' => '521',
                'nama' => 'Biaya Upah Property',
                'jenis' => 'D'
            ],
            [
                'kode' => '522',
                'nama' => 'Biaya Peralatan Property',
                'jenis' => 'D'
            ],
            [
                'kode' => '523',
                'nama' => 'Biaya Sub Kontraktor Property',
                'jenis' => 'D'
            ],
            [
                'kode' => '524',
                'nama' => 'Biaya Bank Property',
                'jenis' => 'D'
            ],
            [
                'kode' => '525',
                'nama' => 'Biaya Overhead Property',
                'jenis' => 'D'
            ],
            [
                'kode' => '526',
                'nama' => 'Biaya Penyusutan Property',
                'jenis' => 'D'
            ],
            [
                'kode' => '527',
                'nama' => 'Biaya Umum Kantor Pusat Property',
                'jenis' => 'D'
            ],
            [
                'kode' => '528',
                'nama' => 'Selisih HPP Standard Property',
                'jenis' => 'D'
            ],
            [
                'kode' => '530',
                'nama' => 'Biaya Bahan',
                'jenis' => 'D'
            ],
            [
                'kode' => '531',
                'nama' => 'Biaya Angkutan',
                'jenis' => 'D'
            ],
            [
                'kode' => '532',
                'nama' => 'Biaya EMKL',
                'jenis' => 'D'
            ],
            [
                'kode' => '533',
                'nama' => 'Biaya Pajak / Bea Masuk',
                'jenis' => 'D'
            ],
            [
                'kode' => '534',
                'nama' => 'Biaya Bank',
                'jenis' => 'D'
            ],
            [
                'kode' => '535',
                'nama' => 'Biaya Lain-Lain',
                'jenis' => 'D'
            ],
            [
                'kode' => '536',
                'nama' => 'Biaya Penyusutan Trading',
                'jenis' => 'D'
            ],
            [
                'kode' => '537',
                'nama' => 'Biaya Alokasi Investasi Awal',
                'jenis' => 'D'
            ],
            [
                'kode' => '540',
                'nama' => 'Biaya Usaha Sewa Peralatan',
                'jenis' => 'D'
            ],
            [
                'kode' => '600',
                'nama' => 'Beban Pemasaran',
                'jenis' => 'D'
            ],
            [
                'kode' => '601',
                'nama' => 'Beban Pegawai',
                'jenis' => 'D'
            ],
            [
                'kode' => '602',
                'nama' => 'Beban Insentif',
                'jenis' => 'D'
            ],
            [
                'kode' => '603',
                'nama' => 'Beban Gedung / Kantor',
                'jenis' => 'D'
            ],
            [
                'kode' => '604',
                'nama' => 'Beban Perjalanan Dinas / Kendaraan',
                'jenis' => 'D'
            ],
            [
                'kode' => '605',
                'nama' => 'Beban Pengembangan',
                'jenis' => 'D'
            ],
            [
                'kode' => '606',
                'nama' => 'Beban Umum',
                'jenis' => 'D'
            ],
            [
                'kode' => '607',
                'nama' => 'Beban Penyusutan',
                'jenis' => 'D'
            ],
            [
                'kode' => '700',
                'nama' => 'Hasil Iuran Wajib',
                'jenis' => 'K'
            ],
            [
                'kode' => '701',
                'nama' => 'Hasil Lain-Lain',
                'jenis' => 'K'
            ],
            [
                'kode' => '702',
                'nama' => 'Penjualan Hotmix',
                'jenis' => 'K'
            ],
            [
                'kode' => '703',
                'nama' => 'Hasil Stone Cruzer',
                'jenis' => 'K'
            ],
            [
                'kode' => '704',
                'nama' => 'Hasil Jasa Bunga',
                'jenis' => 'K'
            ],
            [
                'kode' => '705',
                'nama' => 'Hasil Sewa Gedung',
                'jenis' => 'K'
            ],
            [
                'kode' => '710',
                'nama' => 'Hasil Luar Biasa',
                'jenis' => 'K'
            ],
            [
                'kode' => '800',
                'nama' => 'Biaya Lain-Lain',
                'jenis' => 'D'
            ],
            [
                'kode' => '801',
                'nama' => 'Biaya Luar Biasa',
                'jenis' => 'D'
            ],
            [
                'kode' => '802',
                'nama' => 'Biaya Unit AMP',
                'jenis' => 'D'
            ],
            [
                'kode' => '803',
                'nama' => 'Biaya Stone Cruzer',
                'jenis' => 'D'
            ],
            [
                'kode' => '804',
                'nama' => 'Biaya Bunga',
                'jenis' => 'D'
            ],
            [
                'kode' => '805',
                'nama' => 'Biaya Building',
                'jenis' => 'D'
            ],
            [
                'kode' => '810',
                'nama' => 'Pend. (Beban) Komprehensif',
                'jenis' => 'D'
            ],
            [
                'kode' => '820',
                'nama' => 'Biaya Karena Perubahan P.A.',
                'jenis' => 'D'
            ],
            [
                'kode' => '830',
                'nama' => 'Pajak Final',
                'jenis' => 'D'
            ],
            [
                'kode' => '900',
                'nama' => 'Laba / Rugi Periode Ini',
                'jenis' => 'D'
            ],
        ];

        foreach ($groupAccounts as $groupAccount) {
            GroupAccount::create($groupAccount);
        }
    }
}
