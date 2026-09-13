<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutMission extends Model
{
    use HasFactory;
    protected $table = 'about_missions';

    protected $fillable = [
        'description',
    ];
}
