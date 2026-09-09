<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';

    protected $fillable = [
        'heading',
        'subheading',
        'product_heading',
        'product_subheading',
        'whatsapp',
        'email',
        'tiktok',
        'instagram',
        'facebook',
        'youtube',
        'location',
    ];
}