<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

/**
 * PETA CACHE
 * ---------------------------------------------------------------------------
 * Satu tempat untuk: (1) nama kunci cache, dan (2) kunci apa yang harus
 * dihapus ketika sebuah data diubah admin.
 *
 * Sisi guest WAJIB memakai konstanta di bawah ini sebagai nama kunci:
 *
 *   Cache::rememberForever(SiteCache::CATEGORIES, fn () => Category::...);
 *
 * Driver "file" tidak mendukung cache tags, jadi daftar kunci per grup ditulis
 * eksplisit di MAP. Saat menambah kunci baru, daftarkan juga di MAP.
 */
class SiteCache
{
    // ---- Data master publik (cache lama, dihapus saat admin ubah) ----------
    public const CATEGORIES     = 'site.categories';
    public const CATALOG        = 'site.catalog';        // kategori + produk + foto (halaman Products)
    public const MASTER         = 'site.master';
    public const ABOUT          = 'site.about';
    public const ASK_US         = 'site.ask_us';
    public const GLOBAL_REACH   = 'site.global_reach';
    public const FOOTER         = 'site.footer';
    public const CONTACT        = 'site.contact';
    public const ABOUT_ITEMS    = 'site.about_items';
    public const MISSIONS       = 'site.missions';
    public const OUR_VALUES     = 'site.our_values';
    public const PROCESS        = 'site.process';
    public const CHOOSE_US      = 'site.choose_us';
    public const BUSINESS_HOURS = 'site.business_hours';

    // ---- Statistik admin (cache pendek 5-15 menit, juga dihapus saat berubah)
    public const STATS = 'admin.stats';

    /**
     * Grup data yang diubah  =>  kunci yang dihapus.
     */
    public const MAP = [
        'categories'     => [self::CATEGORIES, self::CATALOG, self::STATS],
        'products'       => [self::CATALOG, self::STATS],
        'inquiries'      => [self::STATS],
        'our_mission'    => [self::MISSIONS],
        'our_value'      => [self::OUR_VALUES],
        'our_process'    => [self::PROCESS, self::STATS],
        'choose_us'      => [self::CHOOSE_US],
        'about_item'     => [self::ABOUT_ITEMS],
        'business_hours' => [self::BUSINESS_HOURS],

        // Site Content (6 tabel singleton)
        'site_content.master'       => [self::MASTER],
        'site_content.about'        => [self::ABOUT],
        'site_content.ask_us'       => [self::ASK_US],
        'site_content.global_reach' => [self::GLOBAL_REACH],
        'site_content.footer'       => [self::FOOTER],
        'site_content.contact'      => [self::CONTACT],
    ];

    /**
     * Hapus semua cache yang terkait satu grup data.
     * Grup yang tidak dikenal dilempar sebagai error agar salah ketik
     * tidak diam-diam membuat cache tidak pernah terhapus.
     */
    public static function forget(string $group): void
    {
        if (! array_key_exists($group, self::MAP)) {
            throw new \InvalidArgumentException("Grup cache tidak dikenal: {$group}");
        }

        foreach (self::MAP[$group] as $key) {
            Cache::forget($key);
        }

        self::clearPageCache();
    }

    /**
     * Bersihkan cache halaman penuh (spatie/laravel-responsecache)
     * bila paketnya terpasang. Tidak melakukan apa pun bila belum ada.
     */
    private static function clearPageCache(): void
    {
        $facade = '\\Spatie\\ResponseCache\\Facades\\ResponseCache';

        if (class_exists($facade)) {
            $facade::clear();
        }
    }
}
