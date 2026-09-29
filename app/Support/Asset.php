<?php

namespace App\Support;

class Asset
{
    /**
     * URL aset dengan parameter versi dari waktu ubah file.
     * Browser memuat ulang file hanya ketika isinya berubah.
     *
     *   Asset::v('assets/css/style-admin.css')
     *   => https://situs.com/assets/css/style-admin.css?v=1790000000
     */
    public static function v(string $path): string
    {
        $path = ltrim($path, '/');
        $root = rtrim(config('site.public_root') ?: public_path(), '/');
        $file = $root . '/' . $path;

        $version = is_file($file) ? filemtime($file) : null;

        return asset($path) . ($version ? '?v=' . $version : '');
    }
}
