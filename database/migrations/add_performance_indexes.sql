-- SQL Script untuk menambahkan performance indexes
-- File ini ekivalen dengan migration: 2025_01_06_000001_add_performance_indexes_to_tables.php
-- 
-- Index ini akan meningkatkan performa query untuk report Neraca dan Laba Rugi

-- ============================================
-- INDEXES UNTUK TABLE: saldo_akuns
-- ============================================

-- Composite index untuk report queries
-- Order: tahun, is_saldo_awal, bulan, id_kode_perkiraan
-- Mencakup WHERE tahun=X AND is_saldo_awal=X AND bulan BETWEEN X AND Y
CREATE INDEX idx_saldo_akuns_report 
ON saldo_akuns (tahun, is_saldo_awal, bulan, id_kode_perkiraan);

-- Index untuk FK join performance
CREATE INDEX idx_saldo_akuns_kode_perkiraan 
ON saldo_akuns (id_kode_perkiraan);

-- ============================================
-- INDEXES UNTUK TABLE: kode_perkiraans
-- ============================================

-- Composite index untuk filtering by cabang, proyek, dan group_account
-- Meningkatkan performa JOIN dan WHERE clause
CREATE INDEX idx_kode_perkiraans_filters 
ON kode_perkiraans (id_cabang, id_proyek, id_group_account);

-- Index untuk group_account FK join
CREATE INDEX idx_kode_perkiraans_group 
ON kode_perkiraans (id_group_account);

-- ============================================
-- INDEXES UNTUK TABLE: group_accounts
-- ============================================

-- Index untuk kode lookups (digunakan dalam LEFT(kode,1), LEFT(kode,2) queries)
CREATE INDEX idx_group_accounts_kode 
ON group_accounts (kode);

-- ============================================
-- ANALYZE TABLE untuk update statistics query optimizer
-- ============================================

ANALYZE TABLE saldo_akuns;
ANALYZE TABLE kode_perkiraans;
ANALYZE TABLE group_accounts;

-- ============================================
-- SQL untuk DROP indexes (rollback script)
-- ============================================
-- Uncomment baris di bawah ini jika ingin menghapus indexes:

-- ALTER TABLE saldo_akuns DROP INDEX idx_saldo_akuns_report;
-- ALTER TABLE saldo_akuns DROP INDEX idx_saldo_akuns_kode_perkiraan;
-- ALTER TABLE kode_perkiraans DROP INDEX idx_kode_perkiraans_filters;
-- ALTER TABLE kode_perkiraans DROP INDEX idx_kode_perkiraans_group;
-- ALTER TABLE group_accounts DROP INDEX idx_group_accounts_kode;

