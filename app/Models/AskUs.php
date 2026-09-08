<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AskUs extends Model
{
    protected $table = 'ask_us';

    protected $fillable = [
        'ask_us_title',
        'ask_us_heading',
        'ask_us_description',
        'ask_us_button',
    ];
}