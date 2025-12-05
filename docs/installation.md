# Panduan Instalasi SIMAK

## Persyaratan Sistem

### Server Requirements
- PHP >= 8.1
- Composer
- MySQL/MariaDB >= 5.7
- Node.js & NPM (untuk frontend assets)
- Web Server (Apache/Nginx)

### PHP Extensions Required
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD PHP Extension (untuk QR Code)
- ZipArchive PHP Extension (untuk Excel)

## Langkah Instalasi

### 1. Clone atau Download Project

```bash
# Clone dari repository (jika menggunakan Git)
git clone <repository-url> laravel-simak
cd laravel-simak

# Atau extract file ZIP ke folder laravel-simak
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### 3. Konfigurasi Environment

```bash
# Copy file .env.example menjadi .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simak_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Buat Database

Buat database baru di MySQL/MariaDB:

```sql
CREATE DATABASE simak_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Migrasi dan Seeding Database

```bash
# Jalankan migrasi database
php artisan migrate

# Jalankan seeder untuk data awal
php artisan db:seed
```

### 7. Storage Link

```bash
# Buat symbolic link untuk storage
php artisan storage:link
```

### 8. Set Permissions (Linux/Mac)

```bash
# Set permission untuk folder storage dan cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Atau jika menggunakan www-data sebagai web server user
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 9. Compile Assets (Optional)

```bash
# Development
npm run dev

# Production
npm run build
```

### 10. Jalankan Server

```bash
# Development server
php artisan serve

# Akses aplikasi di: http://localhost:8000
```

## Konfigurasi Web Server

### Apache Configuration

Contoh virtual host untuk Apache:

```apache
<VirtualHost *:80>
    ServerName simak.local
    DocumentRoot /path/to/laravel-simak/public

    <Directory /path/to/laravel-simak/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/simak-error.log
    CustomLog ${APACHE_LOG_DIR}/simak-access.log combined
</VirtualHost>
```

### Nginx Configuration

Contoh konfigurasi untuk Nginx:

```nginx
server {
    listen 80;
    server_name simak.local;
    root /path/to/laravel-simak/public;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

## Default User Login

Setelah seeding database, gunakan kredensial berikut untuk login:

### Admin User
- **Email**: admin@example.com
- **Password**: password

### Cabang Manager
- **Email**: manager@example.com
- **Password**: password

### Project User
- **Email**: user@example.com
- **Password**: password

> **Note**: Segera ubah password default setelah login pertama kali!

## Konfigurasi Tambahan

### Mail Configuration

Edit konfigurasi email di file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@simak.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Session Configuration

Untuk production, disarankan menggunakan database session:

```env
SESSION_DRIVER=database
```

Kemudian jalankan:

```bash
php artisan session:table
php artisan migrate
```

### Cache Configuration

Untuk production, disarankan menggunakan Redis:

```env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Troubleshooting

### Error: "No application encryption key has been specified"

```bash
php artisan key:generate
```

### Error: Storage Link

```bash
php artisan storage:link
```

### Error: Permission Denied

```bash
# Linux/Mac
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Error: Class not found

```bash
composer dump-autoload
php artisan clear-compiled
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Error: Database Connection

Pastikan:
1. MySQL/MariaDB service berjalan
2. Kredensial database di `.env` benar
3. Database sudah dibuat
4. Port database sesuai (default: 3306)

## Optimasi untuk Production

```bash
# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

## Update Aplikasi

```bash
# Pull latest changes (jika menggunakan Git)
git pull origin main

# Update dependencies
composer install
npm install

# Run migrations
php artisan migrate

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Rebuild production assets
npm run build
```

## Backup

Selalu lakukan backup secara berkala:

```bash
# Backup database
mysqldump -u username -p simak_db > backup_simak_$(date +%Y%m%d).sql

# Backup files
tar -czf backup_simak_files_$(date +%Y%m%d).tar.gz storage/ public/
```

