<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OurMission extends Model
{
    use HasUuids;

    protected $table = 'about_missions';

    protected $fillable = [
        'description',
    ];
}