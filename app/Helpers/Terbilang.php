<?php

namespace App\Helpers;

class Terbilang
{
    private static array $satuan = [
        '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima',
        'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas',
    ];

    /**
     * Konversi angka ke terbilang Bahasa Indonesia.
     * Contoh: 3149596 -> "Tiga Juta Seratus Empat Puluh Sembilan Ribu Lima Ratus Sembilan Puluh Enam"
     * Bagian desimal diabaikan (nominal rupiah).
     */
    public static function convert($angka): string
    {
        // Numerik (int/float) -> cast ke int (buang desimal).
        // String -> buang pemisah ribuan/karakter non-digit.
        if (is_int($angka) || is_float($angka)) {
            $angka = (int) $angka;
        } else {
            $str = preg_replace('/[^\d]/', '', (string) $angka);
            $angka = (int) ($str === '' ? 0 : $str);
        }

        if ($angka === 0) {
            return 'Nol';
        }

        return trim(preg_replace('/\s+/', ' ', self::terbilang($angka)));
    }

    private static function terbilang(int $angka): string
    {
        if ($angka < 12) {
            return self::$satuan[$angka];
        }

        if ($angka < 20) {
            return self::terbilang($angka - 10) . ' Belas';
        }

        if ($angka < 100) {
            return self::terbilang(intdiv($angka, 10)) . ' Puluh ' . self::terbilang($angka % 10);
        }

        if ($angka < 200) {
            return 'Seratus ' . self::terbilang($angka - 100);
        }

        if ($angka < 1000) {
            return self::terbilang(intdiv($angka, 100)) . ' Ratus ' . self::terbilang($angka % 100);
        }

        if ($angka < 2000) {
            return 'Seribu ' . self::terbilang($angka - 1000);
        }

        if ($angka < 1000000) {
            return self::terbilang(intdiv($angka, 1000)) . ' Ribu ' . self::terbilang($angka % 1000);
        }

        if ($angka < 1000000000) {
            return self::terbilang(intdiv($angka, 1000000)) . ' Juta ' . self::terbilang($angka % 1000000);
        }

        if ($angka < 1000000000000) {
            return self::terbilang(intdiv($angka, 1000000000)) . ' Milyar ' . self::terbilang($angka % 1000000000);
        }

        if ($angka < 1000000000000000) {
            return self::terbilang(intdiv($angka, 1000000000000)) . ' Triliun ' . self::terbilang($angka % 1000000000000);
        }

        return (string) $angka;
    }
}
