<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $table = 'footer';

    protected $fillable = [
        'footer_home_heading',
        'footer_home_subheading',
        'footer_home_button',
        'footer_product_heading',
        'footer_product_subheading',
        'footer_product_button',
    ];
}