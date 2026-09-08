<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';

    protected $fillable = [
        'heading',
        'subheading',
        'whatsapp',
        'email',
        'tiktok',
        'instagram',
        'facebook',
        'youtube',
        'location',
    ];
}