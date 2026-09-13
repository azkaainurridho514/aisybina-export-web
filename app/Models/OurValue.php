<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OurValue extends Model
{
    use HasUuids;

    protected $table = 'about_values';

    protected $fillable = [
        'title',
        'description',
    ];
}