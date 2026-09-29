<?php

namespace App\Support;

use Illuminate\Support\Str;

class Text
{
    /**
     * HTML dari editor (Quill) -> teks polos, dipotong. Untuk sel tabel admin.
     */
    public static function plain(?string $html, int $limit = 60): string
    {
        $plain = trim(html_entity_decode(strip_tags((string) $html), ENT_QUOTES | ENT_HTML5));

        return $plain === '' ? '' : Str::limit($plain, $limit);
    }
}
