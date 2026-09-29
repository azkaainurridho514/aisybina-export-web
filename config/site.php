<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public root
    |--------------------------------------------------------------------------
    | Folder fisik tempat file publik (assets, images) berada.
    | - Lokal: kosongkan, otomatis memakai public_path().
    | - Produksi (shared hosting): isi PUBLIC_ROOT=/home/aisy8672/public_html
    |
    | Nilai ini menggantikan path produksi yang sekarang ditulis manual
    | di banyak controller. Dipakai juga oleh pengelola upload gambar nanti.
    */
    'public_root' => env('PUBLIC_ROOT'),

];
