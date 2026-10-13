<?php

namespace App\View\Composers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContactComposer
{
    private const COLUMNS = [
        'home' => ['email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location'],
        'about' => ['email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location'],
        'products' => ['email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location', 'product_heading', 'product_subheading',],
        'detail' => ['email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location', 'product_heading', 'product_subheading',],
        'categories' => ['email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location', 'product_heading', 'product_subheading',],
        'contact' => ['heading', 'subheading', 'email', 'whatsapp', 'tiktok', 'instagram', 'facebook', 'youtube', 'location', 'response_time'],
    ];

    public function compose(View $view): void
    {
        $name = $view->name();

        $footer = Cache::remember(self::cacheKey($name), 3600, function () use ($name) {
            $columns = self::COLUMNS[$name] ?? ['*'];

            return DB::table('contact')->select($columns)->first();
        });

        $view->with('contact', $footer);
    }

    public static function cacheKey(string $name): string
    {
        return 'contact_data_' . $name;
    }

    public static function clearCache(): void
    {
        foreach (array_keys(self::COLUMNS) as $name) {
            Cache::forget(self::cacheKey($name));
        }
    }
}