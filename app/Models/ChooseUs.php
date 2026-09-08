<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ChooseUs extends Model
{
    use HasUuids;

    protected $table = 'choose_us';

    protected $fillable = [
        'icon',
        'title',
        'description',
    ];
}