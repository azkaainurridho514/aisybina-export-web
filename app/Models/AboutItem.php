<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AboutItem extends Model
{
    use HasUuids;

    protected $table = 'about_item';

    protected $fillable = [
        'icon',
        'title',
        'description',
    ];
}