<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FooterViewComposer
{
    private const COLUMNS = [
        'home' => ['footer_home_heading', 'footer_home_subheading', 'footer_home_button'],
        'products' => ['footer_product_heading', 'footer_product_subheading', 'footer_product_button'],
    ];

    public function compose(View $view): void
    {
        $name = $view->name();

        $footer = Cache::remember(self::cacheKey($name), 3600, function () use ($name) {
            $columns = self::COLUMNS[$name] ?? ['*'];

            return DB::table('footer')->select($columns)->first();
        });

        $view->with('footer', $footer);
    }

    public static function cacheKey(string $name): string
    {
        return 'footer_view_data_' . $name;
    }

    public static function clearCache(): void
    {
        foreach (array_keys(self::COLUMNS) as $name) {
            Cache::forget(self::cacheKey($name));
        }
    }
}