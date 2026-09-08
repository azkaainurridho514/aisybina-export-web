<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model
{
    use HasUuids;

    protected $table = 'bussiness_hours';

    protected $fillable = [
        'day',
        'start_time',
        'end_time',
    ];
}