<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $table = 'master';

    protected $fillable = [
        'logo',
        'website_name',
        'website_description',
        'website_slug',
        'heading',
        'image',
        'about_heading',
        'about_description',
        'category_heading',
        'category_description',
        'choose_us_heading',
        'our_process',
    ];
}