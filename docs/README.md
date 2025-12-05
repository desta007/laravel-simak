# SIMAK - Sistem Informasi Akuntansi Keuangan

## Deskripsi Proyek

SIMAK (Sistem Informasi Akuntansi Keuangan) adalah aplikasi berbasis web yang dibangun menggunakan Laravel Framework untuk mengelola sistem akuntansi dan keuangan perusahaan. Sistem ini mendukung manajemen multi-cabang dan multi-proyek dengan fitur lengkap untuk pencatatan transaksi keuangan, pelaporan, dan manajemen mutu.

## Fitur Utama

### 1. Manajemen Master Data
- **Cabang**: Pengelolaan data cabang perusahaan
- **Proyek**: Manajemen proyek per cabang
- **Kode Bukti**: Master kode bukti transaksi
- **Group Account**: Pengelompokan akun berdasarkan jenis (Aset, Liabilitas, Ekuitas, Pendapatan, Beban)
- **Kode Perkiraan**: Chart of Accounts (CoA) dengan struktur multi-level
- **Pejabat**: Data pejabat perusahaan untuk keperluan pelaporan

### 2. Manajemen User
- **User Management**: Pengelolaan user dengan role-based access control
- **Group User**: 
  - Admin (Group 1): Akses penuh ke semua fitur
  - Cabang Manager (Group 2): Akses terbatas untuk manajemen cabang
  - Project User (Group 3): Akses transaksi dan pelaporan proyek
- **User Permission**: Sistem permission berbasis menu dan hak akses (admin, read, none)

### 3. Transaksi Keuangan
- **Transaksi Jurnal**: Input jurnal umum dengan detail debit/kredit
- **Set Saldo Awal**: Pengaturan saldo awal akun untuk periode baru
- **Proses Data Bulanan**: Pemrosesan data keuangan bulanan dan perhitungan saldo
- **Proses Awal Tahun**: Proses penutupan tahun buku dan pembukaan tahun baru
- **Penguncian Transaksi**: Lock transaksi untuk periode tertentu
- **Upload Dokumen**: Attach file dokumen pendukung transaksi

### 4. Laporan Keuangan
- **General Ledger**: Buku besar per akun perkiraan
- **Buku Tambahan**: Laporan buku tambahan/pembantu
- **Neraca**: Laporan posisi keuangan (Balance Sheet)
- **Laba Rugi**: Laporan laba rugi (Income Statement)
- **Resume Keuangan Proyek**: Ringkasan laporan keuangan per proyek

### 5. Manajemen Mutu
- **Pedoman Mutu**: Dokumentasi pedoman mutu perusahaan
- **Catatan Mutu**: Pencatatan dan tracking dokumen mutu

### 6. Export Data
- Export laporan ke format Excel
- Export laporan ke format PDF
- Generate QR Code untuk identifikasi dokumen

## Teknologi yang Digunakan

### Backend
- **Laravel 10.x**: PHP Framework
- **PHP 8.1+**: Programming Language
- **MySQL/MariaDB**: Database Management System

### Frontend
- **AdminLTE 3**: Admin Dashboard Template
- **Bootstrap 4**: CSS Framework
- **jQuery**: JavaScript Library
- **DataTables**: Interactive Table Plugin
- **SweetAlert2**: Modern Alert Dialog

### Package & Library
- **Laravel Fortify**: Authentication System
- **Laravel Sanctum**: API Token Authentication
- **Yajra DataTables**: Server-side DataTables
- **Maatwebsite Excel**: Excel Import/Export
- **DomPDF/Laravel-DomPDF**: PDF Generation
- **Simple QRCode**: QR Code Generator

## Struktur Proyek

```
laravel-simak/
├── app/
│   ├── Actions/          # Fortify actions
│   ├── Exports/          # Excel export classes
│   ├── Http/
│   │   ├── Controllers/  # Application controllers
│   │   ├── Middleware/   # Custom middleware
│   │   └── Requests/     # Form requests
│   ├── Models/           # Eloquent models
│   └── Providers/        # Service providers
├── config/               # Configuration files
├── database/
│   ├── migrations/       # Database migrations
│   └── seeders/          # Database seeders
├── docs/                 # Documentation
├── public/               # Public assets
│   └── adminlte/        # AdminLTE assets
├── resources/
│   ├── views/           # Blade templates
│   │   ├── auth/        # Authentication views
│   │   ├── layout/      # Layout components
│   │   ├── master/      # Master data views
│   │   ├── modal/       # Modal components
│   │   ├── report/      # Report views
│   │   └── transaksi/   # Transaction views
│   ├── css/             # Custom CSS
│   └── js/              # Custom JavaScript
├── routes/
│   ├── web.php          # Web routes
│   └── api.php          # API routes
├── storage/
│   └── app/
│       ├── transaksis/  # Transaction documents
│       └── users/       # User files
└── tests/               # Unit & feature tests
```

## Model dan Relasi Database

### Models Utama
- `User`: User dan autentikasi
- `Cabang`: Data cabang
- `Proyek`: Data proyek
- `KodePerkiraan`: Chart of accounts
- `GroupAccount`: Kelompok akun
- `KodeBukti`: Kode bukti transaksi
- `Transaksi`: Header transaksi
- `TransaksiDetail`: Detail transaksi (debit/kredit)
- `SaldoAkun`: Saldo bulanan per akun
- `KunciTransaksi`: Lock periode transaksi
- `PedomanMutu`: Pedoman mutu
- `CatatanMutu`: Catatan mutu
- `Pejabat`: Data pejabat

### Relasi Database
- User belongsTo Cabang
- User belongsTo GroupUser
- User belongsToMany Proyek (through UserProyek)
- KodePerkiraan belongsTo Cabang, Proyek, GroupAccount
- Transaksi belongsTo Cabang, Proyek, KodeBukti
- Transaksi hasMany TransaksiDetail
- TransaksiDetail belongsTo KodePerkiraan

## Dokumentasi Lengkap

Untuk dokumentasi lebih detail, silakan lihat:
- [Installation Guide](./installation.md) - Panduan instalasi dan konfigurasi
- [User Guide](./user-guide.md) - Panduan penggunaan aplikasi
- [API Documentation](./api-documentation.md) - Dokumentasi API
- [Database Schema](./database-schema.md) - Skema dan struktur database
- [Development Guide](./development-guide.md) - Panduan untuk developer

## Kontributor

Proyek ini dikembangkan untuk mendukung sistem akuntansi keuangan perusahaan dengan fitur multi-cabang dan multi-proyek.

## Lisensi

MIT License

