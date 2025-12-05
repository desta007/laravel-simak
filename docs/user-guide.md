# Panduan Pengguna SIMAK

## Daftar Isi
1. [Login ke Sistem](#login-ke-sistem)
2. [Dashboard](#dashboard)
3. [Master Data](#master-data)
4. [Manajemen User](#manajemen-user)
5. [Kode Perkiraan](#kode-perkiraan)
6. [Set Saldo Awal](#set-saldo-awal)
7. [Transaksi Jurnal](#transaksi-jurnal)
8. [Proses Data](#proses-data)
9. [Laporan](#laporan)
10. [Manajemen Mutu](#manajemen-mutu)

## Login ke Sistem

1. Akses URL aplikasi SIMAK di browser
2. Masukkan email dan password
3. Klik tombol "Sign In"
4. Jika berhasil, akan diarahkan ke halaman Kode Perkiraan

### Reset Password
Hubungi administrator untuk melakukan reset password jika lupa.

## Dashboard

Dashboard menampilkan ringkasan informasi sistem dan akses cepat ke menu-menu utama.

## Role dan Hak Akses

### 1. Admin (Group User 1)
Memiliki akses penuh ke seluruh fitur:
- Master Data (Cabang, Proyek, Kode Bukti, Group Account)
- User Management
- Kode Perkiraan
- Set Saldo Awal
- Pejabat
- Pedoman Mutu & Catatan Mutu
- Penguncian Transaksi
- Transaksi Jurnal
- Proses Bulanan & Awal Tahun
- Semua Laporan

### 2. Cabang Manager (Group User 2)
Akses terbatas:
- User Management (baca)
- Kode Perkiraan (baca)
- Setting Otorisasi Transaksi
- Transaksi Jurnal (baca)
- Laporan (baca)

### 3. Project User (Group User 3)
Fokus pada operasional:
- Kode Perkiraan (admin)
- Transaksi Jurnal (admin)
- Proses Bulanan & Awal Tahun (admin)
- Laporan (baca)

## Master Data

### Cabang
Menu untuk mengelola data cabang perusahaan.

**Fitur:**
- Tambah cabang baru
- Edit data cabang
- Hapus cabang
- Lihat daftar cabang

**Cara Tambah Cabang:**
1. Klik menu "Master" > "Cabang"
2. Klik tombol "Add New"
3. Isi form:
   - Kode Cabang
   - Nama Cabang
4. Klik "Save"

### Proyek
Menu untuk mengelola proyek per cabang.

**Fitur:**
- Tambah proyek baru
- Edit data proyek
- Hapus proyek
- Assign proyek ke cabang

**Cara Tambah Proyek:**
1. Klik menu "Master" > "Proyek"
2. Klik tombol "Add New"
3. Isi form:
   - Pilih Cabang
   - Kode Proyek
   - Nama Proyek
4. Klik "Save"

### Kode Bukti
Menu untuk mengelola kode bukti transaksi.

**Contoh Kode Bukti:**
- BKK: Bukti Kas Keluar
- BKM: Bukti Kas Masuk
- BBK: Bukti Bank Keluar
- BBM: Bukti Bank Masuk
- MJ: Memorial Jurnal

**Cara Tambah Kode Bukti:**
1. Klik menu "Master" > "Kode Bukti"
2. Klik "Add New"
3. Isi kode dan nama bukti
4. Klik "Save"

### Group Account
Menu untuk mengelola kelompok akun.

**Jenis Group Account:**
- **1xxx**: ASET
  - 10x-16x: Aset Lancar
  - 17x: Investasi Jangka Panjang
  - 18x: Aset Tetap
  - 19x: Hak Pengelolaan
  - 1Ax: Aset Tak Berwujud
  - 1Bx: Aset Lain-lain
- **2xxx**: LIABILITAS
  - 20x-24x: Liabilitas Jangka Pendek
  - 25x-26x: Liabilitas Jangka Panjang
  - 27x-28x: Liabilitas Lain-lain
- **3xxx**: EKUITAS
- **4xxx**: PENDAPATAN
- **5xxx**: BEBAN

## Manajemen User

Menu khusus Admin untuk mengelola user sistem.

**Fitur:**
- Tambah user baru
- Edit data user
- Reset password
- Assign cabang dan proyek
- Set group user (role)

**Cara Tambah User:**
1. Klik menu "User Management"
2. Klik "Add New"
3. Isi form:
   - Nama
   - Email
   - Password
   - Pilih Group User
   - Pilih Cabang
   - Phone & Alamat
   - Upload Photo (optional)
4. Pilih proyek yang bisa diakses user
5. Klik "Save"

## Kode Perkiraan

Menu untuk mengelola Chart of Accounts (CoA).

**Struktur Kode Perkiraan:**
- Terikat dengan Cabang
- Terikat dengan Group Account
- Dapat ditugaskan ke Proyek tertentu atau All Proyek

**Cara Tambah Kode Perkiraan:**
1. Klik menu "Kode Perkiraan"
2. Klik "Add New"
3. Isi form:
   - Pilih Cabang
   - Pilih Group Account
   - Pilih Proyek (atau pilih "All")
   - Kode Perkiraan
   - Nama Perkiraan
   - Keterangan (optional)
4. Klik "Save"

**Fitur Pencarian:**
- Filter by Cabang
- Filter by Proyek
- Search by Kode/Nama
- AJAX search untuk pencarian cepat

## Set Saldo Awal

Menu untuk mengatur saldo awal akun di awal periode.

**Cara Set Saldo Awal:**
1. Klik menu "Set Saldo Awal"
2. Pilih Cabang
3. Pilih Proyek
4. Pilih Bulan dan Tahun
5. Klik "Search"
6. Sistem akan menampilkan daftar Kode Perkiraan
7. Input saldo awal untuk setiap akun
8. Klik "Submit"

**Catatan:**
- Saldo awal harus balance (Debit = Kredit)
- Biasanya dilakukan di awal tahun buku
- Hati-hati dalam input saldo awal karena mempengaruhi laporan

## Transaksi Jurnal

Menu utama untuk input transaksi jurnal.

**Cara Input Transaksi:**
1. Klik menu "Transaksi Jurnal"
2. Klik "Add New Transaction"
3. Isi Header Transaksi:
   - Pilih Cabang
   - Pilih Proyek
   - Pilih Kode Bukti
   - Tanggal Transaksi
   - Sistem akan auto-generate No. Bukti
   - Keterangan Transaksi
   - Upload Dokumen Pendukung (optional)
4. Input Detail Transaksi:
   - Klik "Add Detail"
   - Pilih Kode Perkiraan
   - Input Debit atau Kredit
   - Keterangan Detail
   - Klik "Save Detail"
5. Ulangi step 4 untuk detail lainnya
6. Pastikan Total Debit = Total Kredit
7. Klik "Submit Transaction"

**Fitur Transaksi:**
- Auto-generate nomor bukti urut
- Upload dokumen pendukung
- Multiple detail (debit/kredit)
- Validasi balance debit-kredit
- Edit transaksi
- Delete transaksi
- View detail transaksi
- Filter dan pencarian transaksi

**Search Transaksi:**
- Filter by Cabang
- Filter by Proyek
- Filter by Periode (dari-sampai)
- Filter by Kode Bukti
- Search by Nomor Bukti

## Proses Data

### Proses Data Bulanan

Menu untuk memproses data transaksi bulanan dan menghitung saldo.

**Fungsi:**
- Menghitung saldo akhir bulan per akun
- Update tabel saldo_akuns
- Meringkas transaksi bulanan

**Cara Proses Bulanan:**
1. Klik menu "Proses Data Bulanan"
2. Pilih Cabang
3. Pilih Proyek
4. Pilih Bulan dan Tahun yang akan diproses
5. Klik "Proses"
6. Sistem akan memproses dan menampilkan hasilnya
7. Konfirmasi jika berhasil

**Catatan:**
- Lakukan proses bulanan setiap akhir bulan
- Pastikan semua transaksi bulan tersebut sudah diinput
- Proses ini mempengaruhi laporan

### Proses Awal Tahun

Menu untuk proses penutupan tahun buku dan pembukaan tahun baru.

**Fungsi:**
- Penutupan saldo laba/rugi ke laba ditahan
- Reset saldo pendapatan dan beban
- Carry forward saldo neraca ke tahun baru

**Cara Proses Awal Tahun:**
1. Klik menu "Proses Awal Tahun"
2. Pilih Cabang
3. Pilih Proyek
4. Pilih Tahun yang akan ditutup
5. Klik "Proses"
6. Sistem akan melakukan:
   - Tutup buku tahun lama
   - Generate saldo awal tahun baru
7. Konfirmasi jika berhasil

**Catatan:**
- Lakukan di awal tahun baru
- Pastikan semua transaksi tahun lalu sudah lengkap
- Backup database sebelum proses

### Penguncian Transaksi

Menu untuk mengunci periode transaksi agar tidak bisa diedit/dihapus.

**Cara Kunci Transaksi:**
1. Klik menu "Penguncian Transaksi"
2. Klik "Add New"
3. Pilih Cabang
4. Pilih Proyek
5. Pilih Bulan dan Tahun yang akan dikunci
6. Klik "Save"

**Catatan:**
- Transaksi yang terkunci tidak bisa diedit atau dihapus
- Hanya admin yang bisa unlock transaksi

## Laporan

### General Ledger

Laporan buku besar per akun perkiraan.

**Cara Generate:**
1. Klik menu "Report Akuntansi" > "General Ledger"
2. Pilih Cabang
3. Pilih Proyek
4. Pilih Periode (dari-sampai)
5. Pilih Kode Perkiraan (atau All)
6. Klik "View"
7. Laporan akan ditampilkan di layar
8. Klik "Export Excel" untuk export

**Isi Laporan:**
- Saldo awal periode
- Detail transaksi per tanggal
- Running balance
- Saldo akhir periode

### Buku Tambahan

Laporan buku tambahan/pembantu untuk akun tertentu.

**Cara Generate:**
Similar dengan General Ledger, pilih kode perkiraan yang ingin dilihat detailnya.

### Laporan Neraca

Laporan posisi keuangan (Balance Sheet).

**Cara Generate:**
1. Klik menu "Report Akuntansi" > "Laporan Neraca"
2. Pilih Cabang
3. Pilih Proyek
4. Pilih Bulan dan Tahun
5. Klik "View"

**Isi Laporan:**
- **ASET**
  - Aset Lancar
  - Investasi Jangka Panjang
  - Aset Tetap
  - Hak Pengelolaan
  - Aset Tak Berwujud
  - Aset Lain-lain
- **LIABILITAS**
  - Liabilitas Jangka Pendek
  - Liabilitas Jangka Panjang
  - Liabilitas Lain-lain
- **EKUITAS**

**Export:**
- Export to Excel
- Export to PDF

### Laporan Laba/Rugi

Laporan laba rugi (Income Statement).

**Cara Generate:**
1. Klik menu "Report Akuntansi" > "Laporan Laba/Rugi"
2. Pilih Cabang
3. Pilih Proyek
4. Pilih Bulan dan Tahun
5. Klik "View"

**Isi Laporan:**
- **PENDAPATAN** (4xxx)
- **BEBAN** (5xxx)
- **LABA/RUGI BERSIH**

**Export:**
- Export to Excel
- Export to PDF

### Resume Laporan Keuangan Proyek

Laporan ringkasan keuangan per proyek.

**Cara Generate:**
1. Klik menu "Report Akuntansi" > "Resume Lap Keu Proyek"
2. Pilih Cabang
3. Pilih Proyek
4. Pilih Periode
5. Klik "View"

**Isi Laporan:**
- Summary Neraca per Proyek
- Summary Laba Rugi per Proyek
- Perbandingan antar Proyek

## Manajemen Mutu

### Pedoman Mutu

Menu untuk mengelola dokumen pedoman mutu perusahaan.

**Fitur:**
- Upload dokumen pedoman mutu
- Generate QR Code untuk identifikasi dokumen
- Versioning dokumen
- View dan download dokumen

**Cara Tambah Pedoman Mutu:**
1. Klik menu "Pedoman Mutu"
2. Klik "Add New"
3. Isi form:
   - Judul Pedoman
   - Nomor Dokumen
   - Versi
   - Tanggal Berlaku
   - Upload File PDF
4. Sistem akan generate QR Code
5. Klik "Save"

### Catatan Mutu

Menu untuk pencatatan dokumen mutu dan tracking.

**Fitur:**
- Input catatan mutu
- Tracking status dokumen
- Upload bukti/dokumentasi
- Generate laporan mutu

**Cara Tambah Catatan Mutu:**
1. Klik menu "Catatan Mutu"
2. Klik "Add New"
3. Isi form:
   - Referensi Pedoman Mutu
   - Nomor Catatan
   - Tanggal
   - Deskripsi
   - Status
   - Upload File (optional)
4. Klik "Save"

## Tips dan Best Practices

### Input Transaksi
- Selalu double check sebelum submit
- Pastikan debit = kredit
- Upload dokumen pendukung untuk audit trail
- Input deskripsi yang jelas

### Laporan
- Lakukan proses bulanan secara rutin
- Export laporan untuk arsip
- Review laporan secara berkala
- Bandingkan dengan periode sebelumnya

### Keamanan
- Jangan share password
- Logout setelah selesai bekerja
- Ubah password secara berkala
- Hati-hati dengan hak akses

### Backup
- Admin harus backup database secara berkala
- Backup dokumen-dokumen pendukung
- Simpan backup di lokasi yang aman

## FAQ (Frequently Asked Questions)

**Q: Bagaimana cara mengubah password?**
A: Hubungi admin untuk melakukan reset password.

**Q: Saya tidak bisa menghapus transaksi, kenapa?**
A: Kemungkinan transaksi sudah dikunci atau Anda tidak memiliki hak akses.

**Q: Laporan neraca tidak balance, apa yang harus dilakukan?**
A: Cek kembali input transaksi, pastikan debit = kredit. Lakukan proses bulanan untuk update saldo.

**Q: Bagaimana cara menambah cabang/proyek baru?**
A: Hanya admin yang bisa menambah cabang/proyek melalui menu Master.

**Q: Export laporan error, kenapa?**
A: Pastikan data sudah diproses dengan benar dan tidak ada data yang corrupt.

## Kontak Support

Jika mengalami kendala atau memerlukan bantuan, hubungi administrator sistem.

