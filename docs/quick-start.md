# Quick Start Guide - SIMAK

Panduan cepat untuk memulai menggunakan SIMAK dalam 10 menit.

## Prerequisites

Pastikan sudah terinstall:
- PHP 8.1+
- Composer
- MySQL/MariaDB
- Node.js & NPM

## Langkah 1: Setup Project (2 menit)

```bash
# Clone atau extract project
cd laravel-simak

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
```

## Langkah 2: Konfigurasi Database (2 menit)

Edit file `.env`:

```env
DB_DATABASE=simak_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

Buat database:

```bash
mysql -u root -p
```

```sql
CREATE DATABASE simak_db;
EXIT;
```

## Langkah 3: Migrasi & Seed (2 menit)

```bash
# Jalankan migration dan seeder
php artisan migrate --seed
```

Ini akan membuat:
- Semua tabel database
- Data default (cabang, proyek, user, dll)
- 3 user test dengan password "password"

## Langkah 4: Setup Storage (1 menit)

```bash
# Buat symbolic link untuk storage
php artisan storage:link

# Set permission (Linux/Mac)
chmod -R 775 storage bootstrap/cache
```

## Langkah 5: Jalankan Server (1 menit)

```bash
# Development server
php artisan serve
```

Akses aplikasi di: **http://localhost:8000**

## Langkah 6: Login (1 menit)

Gunakan salah satu akun berikut:

### Admin (Akses Penuh)
- Email: `admin@example.com`
- Password: `password`

### Cabang Manager
- Email: `manager@example.com`
- Password: `password`

### Project User
- Email: `user@example.com`
- Password: `password`

## Langkah 7: Explore Fitur (1 menit)

### Admin - Fitur yang Bisa Diakses:
1. **Master Data:**
   - Cabang, Proyek, Kode Bukti, Group Account
   
2. **User Management:**
   - Kelola user dan permission

3. **Kode Perkiraan:**
   - Chart of Accounts (CoA)

4. **Transaksi:**
   - Input jurnal
   - Proses data

5. **Laporan:**
   - Neraca, Laba/Rugi, General Ledger

## Quick Tutorial: Input Transaksi Pertama

### 1. Buka Transaksi Jurnal
- Klik menu "**Transaksi Jurnal**" di sidebar

### 2. Tambah Transaksi Baru
- Klik tombol "**Add New Transaction**"

### 3. Isi Header Transaksi
- **Cabang:** Pilih cabang
- **Proyek:** Pilih proyek
- **Kode Bukti:** Pilih (contoh: BKM - Bukti Kas Masuk)
- **Tanggal:** Pilih tanggal
- **Keterangan:** "Penerimaan kas dari customer"

### 4. Tambah Detail (Debit)
- Klik "**Add Detail**"
- **Kode Perkiraan:** Pilih "1101 - Kas"
- **Debit:** 1,000,000
- **Keterangan:** "Penerimaan kas"
- Klik "Save Detail"

### 5. Tambah Detail (Kredit)
- Klik "**Add Detail**" lagi
- **Kode Perkiraan:** Pilih "4101 - Pendapatan"
- **Kredit:** 1,000,000
- **Keterangan:** "Pendapatan jasa"
- Klik "Save Detail"

### 6. Submit Transaksi
- Pastikan **Total Debit = Total Kredit**
- Klik "**Submit Transaction**"
- Transaksi berhasil disimpan!

## Quick Tutorial: Lihat Laporan

### 1. Buka Menu Report
- Klik "**Report Akuntansi**" > "**Laporan Neraca**"

### 2. Set Filter
- **Cabang:** Pilih cabang
- **Proyek:** Pilih proyek
- **Bulan & Tahun:** Pilih periode
- Klik "**View**"

### 3. Lihat Hasil
- Laporan neraca akan ditampilkan
- Klik "**Export Excel**" untuk download

## Common First-Time Tasks

### Setup Data Master

1. **Tambah Cabang Baru:**
   - Menu: Master > Cabang
   - Klik "Add New"
   - Isi kode dan nama cabang

2. **Tambah Proyek:**
   - Menu: Master > Proyek
   - Klik "Add New"
   - Pilih cabang dan isi data proyek

3. **Tambah Kode Perkiraan:**
   - Menu: Kode Perkiraan
   - Klik "Add New"
   - Pilih cabang, group account, dan isi kode/nama

### Setup User Baru

1. **Buka User Management:**
   - Menu: User Management

2. **Tambah User:**
   - Klik "Add New"
   - Isi nama, email, password
   - Pilih group user (role)
   - Pilih cabang
   - Assign proyek yang bisa diakses

### Set Saldo Awal

1. **Buka Menu Set Saldo Awal:**
   - Menu: Set Saldo Awal

2. **Pilih Parameter:**
   - Cabang, Proyek, Bulan, Tahun
   - Klik "Search"

3. **Input Saldo:**
   - Isi saldo awal untuk setiap akun
   - Pastikan balance (Total Debit = Total Kredit)
   - Klik "Submit"

## Tips untuk Pemula

### 1. Pahami Struktur
- **Cabang** → **Proyek** → **Kode Perkiraan** → **Transaksi**
- Hirarki ini penting untuk pemisahan data

### 2. Gunakan Filter
- Hampir semua menu punya filter
- Filter membantu menemukan data dengan cepat

### 3. Export Data
- Semua laporan bisa di-export (Excel/PDF)
- Gunakan untuk backup atau analisis

### 4. Cek Total
- Transaksi harus balance: **Debit = Kredit**
- Sistem akan validasi sebelum simpan

### 5. Gunakan Penguncian
- Lock periode yang sudah selesai
- Mencegah perubahan tidak sengaja

## Troubleshooting Cepat

### Tidak bisa login?
```bash
# Reset password via tinker
php artisan tinker
$user = User::where('email', 'admin@example.com')->first();
$user->password = Hash::make('password');
$user->save();
exit;
```

### Error 500?
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Database error?
```bash
# Re-migrate (WARNING: hapus semua data!)
php artisan migrate:fresh --seed
```

### Permission error?
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache

# Windows (Run as Admin)
icacls storage /grant Users:F /t
```

## Next Steps

Setelah setup awal, lanjutkan dengan:

1. **Baca User Guide:**
   - [User Guide](./user-guide.md) untuk panduan lengkap

2. **Setup Data Master:**
   - Input cabang, proyek, dan kode perkiraan sesuai kebutuhan

3. **Input Saldo Awal:**
   - Set saldo awal untuk semua akun

4. **Mulai Transaksi:**
   - Input transaksi harian

5. **Proses Bulanan:**
   - Jalankan proses data bulanan setiap akhir bulan

6. **Generate Laporan:**
   - Buat laporan keuangan secara berkala

## Keyboard Shortcuts (Future)

| Shortcut | Action |
|----------|--------|
| Ctrl + N | New Transaction |
| Ctrl + S | Save |
| Ctrl + F | Search |
| Esc | Close Modal |

*Note: Shortcuts belum fully implemented*

## Video Tutorial

*Coming soon:*
- Installation video
- Basic usage walkthrough
- Transaction entry demo
- Report generation guide

## Help & Support

### Documentation
- [Full User Guide](./user-guide.md)
- [Installation Guide](./installation.md)
- [Troubleshooting](./troubleshooting.md)

### System Information
```bash
# Check version
php artisan --version

# Check environment
php artisan env

# List routes
php artisan route:list
```

## Checklist Setup

- [ ] PHP & Composer installed
- [ ] MySQL/MariaDB installed
- [ ] Dependencies installed (`composer install`)
- [ ] Environment configured (`.env`)
- [ ] Database created
- [ ] Migrations run (`php artisan migrate`)
- [ ] Seeders run (`php artisan db:seed`)
- [ ] Storage link created
- [ ] Permissions set
- [ ] Server running
- [ ] Login successful
- [ ] First transaction created
- [ ] First report generated

## Selamat! 🎉

Anda sudah siap menggunakan SIMAK. Explore fitur-fitur lainnya dan jangan ragu untuk membaca dokumentasi lengkap jika ada yang kurang jelas.

**Happy Accounting!** 📊

