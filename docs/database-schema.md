# Database Schema - SIMAK

## Daftar Tabel

### 1. users
Tabel untuk menyimpan data pengguna sistem.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| name | varchar(255) | Nama user |
| email | varchar(255) | Email (unique) |
| password | varchar(255) | Password (hashed) |
| id_group_user | int | Foreign key ke group_users |
| id_cabang | int | Foreign key ke cabangs |
| id_proyek | int | Foreign key ke proyeks |
| phone | varchar(20) | Nomor telepon |
| alamat | text | Alamat lengkap |
| photo | varchar(255) | Path foto profil |
| email_verified_at | timestamp | Waktu verifikasi email |
| remember_token | varchar(100) | Token remember me |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Relasi:**
- belongsTo: `Cabang` (id_cabang)
- belongsTo: `GroupUser` (id_group_user)
- belongsToMany: `Proyek` through `UserProyek`

### 2. group_users
Tabel untuk menyimpan kelompok user (role).

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| nama | varchar(255) | Nama group (Admin, Cabang Manager, Project User) |
| keterangan | text | Deskripsi group |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Default Groups:**
1. Admin
2. Cabang Manager
3. Project User

### 3. user_permissions
Tabel untuk menyimpan permission per group user.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| id_group_user | int | Foreign key ke group_users |
| nama_menu | varchar(255) | Nama menu |
| hak_akses | enum | admin, read, none |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

### 4. cabangs
Tabel untuk menyimpan data cabang.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| kode | varchar(50) | Kode cabang (unique) |
| nama | varchar(255) | Nama cabang |
| alamat | text | Alamat cabang |
| telepon | varchar(20) | Nomor telepon |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

### 5. proyeks
Tabel untuk menyimpan data proyek.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| id_cabang | int | Foreign key ke cabangs |
| kode | varchar(50) | Kode proyek |
| nama | varchar(255) | Nama proyek |
| tanggal_mulai | date | Tanggal mulai proyek |
| tanggal_selesai | date | Tanggal selesai proyek |
| status | enum | active, completed, on-hold |
| keterangan | text | Deskripsi proyek |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Relasi:**
- belongsTo: `Cabang` (id_cabang)

### 6. user_proyeks
Tabel pivot untuk relasi many-to-many antara users dan proyeks.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| id_user | int | Foreign key ke users |
| id_proyek | int | Foreign key ke proyeks |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

### 7. kode_buktis
Tabel untuk menyimpan master kode bukti transaksi.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| kode | varchar(10) | Kode bukti (BKK, BKM, BBK, dll) |
| nama | varchar(255) | Nama bukti |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Contoh Data:**
- BKK: Bukti Kas Keluar
- BKM: Bukti Kas Masuk
- BBK: Bukti Bank Keluar
- BBM: Bukti Bank Masuk
- MJ: Memorial Jurnal

### 8. group_accounts
Tabel untuk menyimpan kelompok akun.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| kode | varchar(10) | Kode group (1xx, 2xx, dll) |
| nama | varchar(255) | Nama group account |
| jenis | enum | ASET, LIABILITAS, EKUITAS, PENDAPATAN, BEBAN |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Struktur Kode:**
- 1xx: ASET
- 2xx: LIABILITAS
- 3xx: EKUITAS
- 4xx: PENDAPATAN
- 5xx: BEBAN

### 9. kode_perkiraans
Tabel untuk menyimpan chart of accounts (CoA).

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| id_cabang | int | Foreign key ke cabangs |
| id_group_account | int | Foreign key ke group_accounts |
| id_proyek | int | Foreign key ke proyeks (0 = all) |
| kode | varchar(50) | Kode perkiraan |
| nama | varchar(255) | Nama perkiraan |
| keterangan | text | Deskripsi |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Relasi:**
- belongsTo: `Cabang` (id_cabang)
- belongsTo: `GroupAccount` (id_group_account)
- belongsTo: `Proyek` (id_proyek)

**Index:**
- id_cabang, id_proyek (untuk performance query)

### 10. transaksis
Tabel untuk menyimpan header transaksi jurnal.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| id_cabang | int | Foreign key ke cabangs |
| id_proyek | int | Foreign key ke proyeks |
| id_kode_bukti | int | Foreign key ke kode_buktis |
| tgl | date | Tanggal transaksi |
| no_bukti | varchar(50) | Nomor bukti (format: KODE-YYYYMM-XXXX) |
| no_urut_bukti | varchar(10) | Nomor urut |
| no_urut_jurnal | varchar(10) | Nomor urut jurnal |
| keterangan | text | Keterangan transaksi |
| file_dokumen | varchar(255) | Path file dokumen pendukung |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Relasi:**
- belongsTo: `Cabang` (id_cabang)
- belongsTo: `Proyek` (id_proyek)
- belongsTo: `KodeBukti` (id_kode_bukti)
- hasMany: `TransaksiDetail`

**Index:**
- tgl, id_cabang, id_proyek

### 11. transaksi_details
Tabel untuk menyimpan detail transaksi (debit/kredit).

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| id_transaksi | bigint | Foreign key ke transaksis |
| id_kode_perkiraan | int | Foreign key ke kode_perkiraans |
| debit | decimal(15,2) | Jumlah debit |
| kredit | decimal(15,2) | Jumlah kredit |
| keterangan | text | Keterangan detail |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Relasi:**
- belongsTo: `Transaksi` (id_transaksi)
- belongsTo: `KodePerkiraan` (id_kode_perkiraan)

**Constraint:**
- Debit dan Kredit tidak boleh keduanya terisi atau kosong
- Harus salah satu saja yang terisi

### 12. saldo_akuns
Tabel untuk menyimpan saldo bulanan per akun.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| id_cabang | int | Foreign key ke cabangs |
| id_proyek | int | Foreign key ke proyeks |
| id_kode_perkiraan | int | Foreign key ke kode_perkiraans |
| bulan | int | Bulan (1-12) |
| tahun | int | Tahun (YYYY) |
| saldo_awal_debit | decimal(15,2) | Saldo awal debit |
| saldo_awal_kredit | decimal(15,2) | Saldo awal kredit |
| mutasi_debit | decimal(15,2) | Total mutasi debit |
| mutasi_kredit | decimal(15,2) | Total mutasi kredit |
| saldo_akhir_debit | decimal(15,2) | Saldo akhir debit |
| saldo_akhir_kredit | decimal(15,2) | Saldo akhir kredit |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Index:**
- bulan, tahun, id_cabang, id_proyek
- Unique: id_cabang, id_proyek, id_kode_perkiraan, bulan, tahun

**Note:**
- Tabel ini di-update oleh proses bulanan
- Digunakan untuk generate laporan

### 13. kunci_transaksis
Tabel untuk lock periode transaksi.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| id_cabang | int | Foreign key ke cabangs |
| id_proyek | int | Foreign key ke proyeks |
| bulan | int | Bulan yang dikunci (1-12) |
| tahun | int | Tahun yang dikunci |
| status | enum | locked, unlocked |
| locked_by | int | User yang mengunci |
| locked_at | timestamp | Waktu dikunci |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Note:**
- Jika periode dikunci, transaksi di periode tersebut tidak bisa diedit/hapus

### 14. pedoman_mutus
Tabel untuk menyimpan dokumen pedoman mutu.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| no_dokumen | varchar(50) | Nomor dokumen |
| judul | varchar(255) | Judul pedoman |
| versi | varchar(10) | Versi dokumen |
| tanggal_berlaku | date | Tanggal berlaku |
| file_path | varchar(255) | Path file PDF |
| qr_code | varchar(255) | Path QR code |
| status | enum | active, inactive |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

### 15. catatan_mutus
Tabel untuk menyimpan catatan mutu.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| id_pedoman_mutu | int | Foreign key ke pedoman_mutus |
| no_catatan | varchar(50) | Nomor catatan |
| tanggal | date | Tanggal catatan |
| deskripsi | text | Deskripsi |
| status | enum | open, closed, in-progress |
| file_path | varchar(255) | Path file pendukung |
| created_by | int | User yang membuat |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Relasi:**
- belongsTo: `PedomanMutu` (id_pedoman_mutu)

### 16. pejabats
Tabel untuk menyimpan data pejabat perusahaan.

**Struktur:**
| Field | Type | Description |
|-------|------|-------------|
| id | bigint (PK) | Primary key |
| id_cabang | int | Foreign key ke cabangs |
| nama | varchar(255) | Nama pejabat |
| jabatan | varchar(255) | Jabatan |
| nip | varchar(50) | NIP/NIK |
| phone | varchar(20) | Nomor telepon |
| email | varchar(100) | Email |
| tanda_tangan | varchar(255) | Path file tanda tangan |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

**Note:**
- Digunakan untuk keperluan penandatanganan laporan

## Entity Relationship Diagram (ERD)

```
users ----< user_proyeks >---- proyeks
  |                              |
  |                           cabangs
  |                              |
  +--- group_users               +--- kode_perkiraans
  |                              |         |
  |                              |         +--- group_accounts
  |                              |
  +--- cabangs                   +--- transaksis
                                 |         |
                                 |         +--- kode_buktis
                                 |         |
                                 |         +--- transaksi_details
                                 |                   |
                                 |                   +--- kode_perkiraans
                                 |
                                 +--- saldo_akuns
                                 |
                                 +--- kunci_transaksis
                                 |
                                 +--- pejabats
```

## Indexes

Untuk performa optimal, berikut adalah index yang direkomendasikan:

### transaksis
- `idx_transaksis_tgl` (tgl)
- `idx_transaksis_cabang_proyek` (id_cabang, id_proyek)
- `idx_transaksis_no_bukti` (no_bukti)

### transaksi_details
- `idx_transaksi_details_transaksi` (id_transaksi)
- `idx_transaksi_details_kode_perkiraan` (id_kode_perkiraan)

### saldo_akuns
- `idx_saldo_akuns_periode` (bulan, tahun, id_cabang, id_proyek)
- `unique_saldo_akuns` (id_cabang, id_proyek, id_kode_perkiraan, bulan, tahun)

### kode_perkiraans
- `idx_kode_perkiraans_cabang_proyek` (id_cabang, id_proyek)

## Seeder Data

### GroupUserSeeder
Default groups:
1. Admin
2. Cabang Manager
3. Project User

### UserPermissionSeeder
Permissions untuk setiap group user terhadap menu-menu sistem.

### CabangSeeder
Contoh data cabang untuk development.

### ProyekSeeder
Contoh data proyek untuk development.

### KodeBuktiSeeder
Data standar kode bukti: BKK, BKM, BBK, BBM, MJ, dll.

### GroupAccountSeeder
Data group account standard (1xx-5xx).

### KodePerkiraanSeeder
Chart of accounts standar.

### UserSeeder
Default users untuk testing:
- admin@example.com (Admin)
- manager@example.com (Cabang Manager)
- user@example.com (Project User)

## Migration Notes

Urutan migrasi harus mengikuti dependency:
1. group_users
2. cabangs
3. users
4. proyeks
5. user_proyeks
6. kode_buktis
7. group_accounts
8. kode_perkiraans
9. transaksis
10. transaksi_details
11. saldo_akuns
12. kunci_transaksis
13. pedoman_mutus
14. catatan_mutus
15. pejabats

## Backup Strategy

### Daily Backup
- Full database dump setiap hari
- Backup folder storage/app (dokumen transaksi)

### Weekly Backup
- Full backup database + files
- Export ke external storage

### Monthly Backup
- Archive backup bulanan
- Simpan untuk audit

## Maintenance

### Regular Cleanup
- Archive transaksi tahun lama
- Cleanup file temporary
- Optimize tables

### Index Optimization
```sql
ANALYZE TABLE transaksis;
OPTIMIZE TABLE transaksi_details;
ANALYZE TABLE saldo_akuns;
```

### Check Table Integrity
```sql
CHECK TABLE transaksis;
CHECK TABLE transaksi_details;
CHECK TABLE saldo_akuns;
```

