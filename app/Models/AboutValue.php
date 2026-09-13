<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutValue extends Model
{
    use HasFactory;
    protected $table = 'about_values';

    protected $fillable = [
        'title',
        'description',
    ];
}
