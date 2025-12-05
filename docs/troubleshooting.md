# Troubleshooting Guide - SIMAK

## Daftar Isi
1. [Installation Issues](#installation-issues)
2. [Database Issues](#database-issues)
3. [Authentication Issues](#authentication-issues)
4. [Transaction Issues](#transaction-issues)
5. [Report Issues](#report-issues)
6. [Export Issues](#export-issues)
7. [Performance Issues](#performance-issues)
8. [Common Errors](#common-errors)

## Installation Issues

### Error: "No application encryption key has been specified"

**Penyebab:** Application key belum di-generate

**Solusi:**
```bash
php artisan key:generate
```

### Error: "Class 'X' not found"

**Penyebab:** Autoload belum di-regenerate

**Solusi:**
```bash
composer dump-autoload
php artisan clear-compiled
php artisan cache:clear
php artisan config:clear
```

### Error: Permission Denied pada storage/

**Penyebab:** Permission folder tidak tepat

**Solusi Linux/Mac:**
```bash
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache
```

**Solusi Windows:**
```bash
# Run as Administrator
icacls storage /grant Users:F /t
icacls bootstrap/cache /grant Users:F /t
```

### Error: "The stream or file could not be opened"

**Penyebab:** Laravel tidak bisa menulis ke log file

**Solusi:**
```bash
# Linux/Mac
chmod -R 775 storage/logs
chown -R www-data:www-data storage/logs

# Windows (Run as Admin)
icacls storage\logs /grant Users:F /t
```

### Error: npm install gagal

**Penyebab:** Node modules corrupt atau version mismatch

**Solusi:**
```bash
# Hapus node_modules dan package-lock.json
rm -rf node_modules package-lock.json

# Clear npm cache
npm cache clean --force

# Install ulang
npm install
```

## Database Issues

### Error: "SQLSTATE[HY000] [1045] Access denied for user"

**Penyebab:** Kredensial database salah

**Solusi:**
1. Cek kredensial di file `.env`
2. Pastikan user database memiliki hak akses
3. Test koneksi:
```bash
mysql -u username -p database_name
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"

**Penyebab:** MySQL service tidak berjalan

**Solusi:**
```bash
# Linux
sudo systemctl start mysql
sudo systemctl status mysql

# Mac
brew services start mysql

# Windows
net start mysql
```

### Error: Migration gagal

**Penyebab:** Migrasi sudah pernah dijalankan atau tabel sudah ada

**Solusi:**
```bash
# Reset semua migrations (HATI-HATI: akan hapus semua data!)
php artisan migrate:fresh

# Rollback migration terakhir
php artisan migrate:rollback

# Reset dan seed ulang
php artisan migrate:fresh --seed
```

### Error: "Base table or view not found"

**Penyebab:** Tabel belum dibuat atau nama tabel salah

**Solusi:**
1. Cek apakah migration sudah dijalankan:
```bash
php artisan migrate:status
```

2. Jalankan migration:
```bash
php artisan migrate
```

3. Cek nama tabel di database dan model

### Database Query Lambat

**Penyebab:** Query tidak optimal atau missing index

**Solusi:**
1. Tambahkan index pada kolom yang sering di-query
2. Gunakan eager loading untuk relasi
3. Optimize query:
```php
// Bad - N+1 problem
$transaksis = Transaksi::all();
foreach ($transaksis as $t) {
    echo $t->cabang->nama; // Query untuk setiap transaksi
}

// Good - Eager loading
$transaksis = Transaksi::with('cabang')->get();
foreach ($transaksis as $t) {
    echo $t->cabang->nama; // Sudah di-load sebelumnya
}
```

4. Analyze dan optimize table:
```sql
ANALYZE TABLE transaksis;
OPTIMIZE TABLE transaksis;
```

## Authentication Issues

### Error: Tidak bisa login

**Penyebab:** Password salah atau user tidak ada

**Solusi:**
1. Reset password via seeder atau manual:
```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'admin@example.com')->first();
$user->password = Hash::make('newpassword');
$user->save();
```

2. Cek apakah user ada di database:
```sql
SELECT * FROM users WHERE email = 'admin@example.com';
```

### Error: Session expired terus menerus

**Penyebab:** Session configuration atau cookie issue

**Solusi:**
1. Clear browser cache dan cookies
2. Cek konfigurasi session di `.env`:
```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

3. Clear Laravel cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan session:table
php artisan migrate
```

### Error: "Too Many Login Attempts"

**Penyebab:** Rate limiting aktif

**Solusi:**
Tunggu beberapa menit atau clear cache:
```bash
php artisan cache:clear
```

## Transaction Issues

### Error: "Debit dan Kredit tidak balance"

**Penyebab:** Total debit ≠ total kredit

**Solusi:**
1. Validasi di frontend sebelum submit
2. Cek perhitungan di backend
3. Pastikan tidak ada detail yang kosong

```javascript
// Validasi frontend
function validateBalance() {
    let totalDebit = 0;
    let totalKredit = 0;
    
    $('.detail-row').each(function() {
        totalDebit += parseFloat($(this).find('.debit').val() || 0);
        totalKredit += parseFloat($(this).find('.kredit').val() || 0);
    });
    
    if (totalDebit !== totalKredit) {
        alert('Debit dan Kredit harus balance!');
        return false;
    }
    return true;
}
```

### Error: "Transaksi tidak bisa diedit/dihapus"

**Penyebab:** Transaksi sudah dikunci (locked)

**Solusi:**
1. Cek tabel `kunci_transaksis`
2. Hubungi admin untuk unlock periode
3. Admin dapat unlock melalui menu "Penguncian Transaksi"

### Error: Upload dokumen gagal

**Penyebab:** File terlalu besar atau format tidak didukung

**Solusi:**
1. Cek ukuran file (max 2MB default)
2. Cek format file (pdf, jpg, png)
3. Increase upload limit di `php.ini`:
```ini
upload_max_filesize = 10M
post_max_size = 10M
```

4. Restart web server setelah ubah php.ini

### Error: Nomor bukti duplikat

**Penyebab:** Auto-generate nomor bukti error

**Solusi:**
1. Cek fungsi generate nomor bukti
2. Pastikan menggunakan lock untuk concurrency
3. Manual fix di database jika perlu

## Report Issues

### Error: Laporan kosong

**Penyebab:** Data tidak ada atau filter salah

**Solusi:**
1. Cek filter yang digunakan
2. Pastikan data transaksi sudah ada
3. Pastikan sudah running proses bulanan
4. Cek query di controller

### Error: Laporan tidak balance

**Penyebab:** Proses bulanan belum dijalankan atau data corrupt

**Solusi:**
1. Jalankan proses bulanan ulang
2. Cek konsistensi data:
```sql
-- Cek balance debit-kredit per transaksi
SELECT t.id, t.no_bukti,
    SUM(td.debit) as total_debit,
    SUM(td.kredit) as total_kredit
FROM transaksis t
JOIN transaksi_details td ON t.id = td.id_transaksi
GROUP BY t.id
HAVING total_debit != total_kredit;
```

3. Fix data yang tidak balance

### Error: Saldo awal salah

**Penyebab:** Input saldo awal tidak tepat

**Solusi:**
1. Cek tabel `saldo_akuns`
2. Re-input saldo awal via menu "Set Saldo Awal"
3. Atau update manual via database (dengan hati-hati)

### Error: Proses bulanan gagal

**Penyebab:** Data transaksi incomplete atau error

**Solusi:**
1. Cek log error: `storage/logs/laravel.log`
2. Cek transaksi yang error
3. Fix transaksi bermasalah
4. Jalankan proses ulang

## Export Issues

### Error: Export Excel gagal

**Penyebab:** Memory limit atau corrupt data

**Solusi:**
1. Increase memory limit di `.env`:
```env
MEMORY_LIMIT=512M
```

2. Atau di script PHP:
```php
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 300);
```

3. Jika data terlalu banyak, export per periode

### Error: Export PDF gagal

**Penyebab:** DomPDF error atau view error

**Solusi:**
1. Cek error di log
2. Test view secara langsung (tanpa PDF)
3. Simplify view jika terlalu complex
4. Cek ukuran data (jangan terlalu besar)

### Error: QR Code tidak muncul

**Penyebab:** Library QR Code error

**Solusi:**
1. Clear cache:
```bash
php artisan cache:clear
php artisan view:clear
```

2. Reinstall package:
```bash
composer require simplesoftwareio/simple-qrcode
```

3. Cek permission folder storage

## Performance Issues

### Aplikasi lambat

**Penyebab:** Multiple causes

**Solusi:**

1. **Enable caching:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

2. **Optimize autoloader:**
```bash
composer dump-autoload -o
```

3. **Use Redis for cache & session:**
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_HOST=127.0.0.1
```

4. **Database optimization:**
- Add indexes
- Optimize queries
- Use eager loading

5. **Enable OPcache di php.ini:**
```ini
opcache.enable=1
opcache.memory_consumption=256
```

### DataTables lambat

**Penyebab:** Data terlalu banyak

**Solusi:**
1. Gunakan server-side processing (sudah implemented)
2. Add index di kolom yang di-search/sort
3. Limit default entries
4. Use pagination

### Query timeout

**Penyebab:** Query terlalu complex atau data terlalu besar

**Solusi:**
1. Optimize query
2. Add indexes
3. Increase timeout di database config:
```php
// config/database.php
'options' => [
    PDO::ATTR_TIMEOUT => 30,
]
```

4. Break down query jadi lebih kecil

## Common Errors

### Error 500 - Internal Server Error

**Debugging:**
1. Cek log: `storage/logs/laravel.log`
2. Enable debug mode (development only):
```env
APP_DEBUG=true
```
3. Check web server error log

**Common causes:**
- Syntax error
- Missing dependency
- File permission
- Out of memory

### Error 404 - Not Found

**Penyebab:** Route tidak ditemukan

**Solusi:**
1. Cek route:
```bash
php artisan route:list
```

2. Clear route cache:
```bash
php artisan route:clear
```

3. Cek URL dan route definition

### Error 419 - Page Expired

**Penyebab:** CSRF token expired

**Solusi:**
1. Refresh halaman
2. Increase session lifetime di `.env`:
```env
SESSION_LIFETIME=120
```

3. Pastikan CSRF token ada di form:
```html
@csrf
```

### Error 403 - Forbidden

**Penyebab:** Permission denied atau tidak punya akses

**Solusi:**
1. Cek user permission
2. Login dengan user yang sesuai
3. Hubungi admin untuk set permission

### Error 422 - Validation Error

**Penyebab:** Input tidak valid

**Solusi:**
1. Cek validation rules
2. Lihat error message di response
3. Fix input sesuai requirement

## Debug Mode

### Enable Debug Mode (Development Only!)

```env
APP_DEBUG=true
APP_ENV=local
```

**WARNING:** Jangan enable di production!

### Laravel Debugbar

Install untuk development:

```bash
composer require barryvdh/laravel-debugbar --dev
```

Features:
- View SQL queries
- See memory usage
- Check route info
- View session data

## Getting Help

### Check Logs

```bash
# View latest logs
tail -f storage/logs/laravel.log

# View last 100 lines
tail -n 100 storage/logs/laravel.log
```

### Clear All Caches

```bash
php artisan optimize:clear
```

This clears:
- Application cache
- Route cache
- Config cache
- View cache
- Event cache

### Database Check

```sql
-- Check table size
SELECT 
    table_name AS "Table",
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS "Size (MB)"
FROM information_schema.TABLES
WHERE table_schema = "simak_db"
ORDER BY (data_length + index_length) DESC;

-- Check row counts
SELECT 
    table_name,
    table_rows
FROM information_schema.tables
WHERE table_schema = 'simak_db';
```

### System Information

```bash
# PHP version & modules
php -v
php -m

# Composer version
composer --version

# Laravel version
php artisan --version

# Check environment
php artisan env
```

## Contact Support

Jika masalah masih berlanjut:

1. Catat error message lengkap
2. Screenshot jika perlu
3. Catat langkah-langkah untuk reproduce error
4. Check log file
5. Hubungi administrator sistem atau developer

