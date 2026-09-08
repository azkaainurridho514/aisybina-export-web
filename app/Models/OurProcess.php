<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OurProcess extends Model
{
    use HasUuids;

    protected $table = 'our_process';

    protected $fillable = [
        'title',
    ];
}