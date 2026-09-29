<?php

if (! function_exists('quill_inline')) {
    function quill_inline(?string $html): string
    {
        $html = trim($html ?? '');

        if ($html === '') {
            return '';
        }

        if (preg_match('/^<p[^>]*>(.*)<\/p>$/is', $html, $matches)) {
            return trim($matches[1]);
        }

        return $html;
    }
}