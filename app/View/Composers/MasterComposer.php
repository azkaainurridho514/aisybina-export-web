<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MasterComposer
{
    private const COLUMNS = [
        'home' => [
            'logo', 'website_name', 'website_description',
            'heading', 'about_heading', 'about_description',
            'category_heading', 'category_description',
            'choose_us_heading', 'our_process', 'website_slug',
        ],
        'about' => [
            'logo', 'website_name', 'website_slug',
            'about_heading', 'about_description',
        ],
        'products' => ['logo', 'website_name', 'website_slug'],
        'categories' => ['logo', 'website_name', 'website_slug'],
        'detail' => ['logo', 'website_name', 'website_slug'],
        'contact'  => ['logo', 'website_name', 'website_slug'],
    ];

    public function compose(View $view): void
    {
        $name = $view->name();

        $master = Cache::remember(self::cacheKey($name), 3600, function () use ($name) {
            $columns = self::COLUMNS[$name] ?? ['*'];

            return DB::table('master')->select($columns)->first();
        });

        $view->with('master', $master);
    }

    public static function cacheKey(string $name): string
    {
        return 'master_data_' . $name;
    }

    public static function clearCache(): void
    {
        foreach (array_keys(self::COLUMNS) as $name) {
            Cache::forget(self::cacheKey($name));
        }
    }
}