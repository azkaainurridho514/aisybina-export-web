<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;
    protected $fillable = [
        'intro_title',
        'intro_description',
        'image_intro',
        'vision_description',
        'image_vision',
        'image_mission',
        'value_description',
        'image_value',
    ];
}
