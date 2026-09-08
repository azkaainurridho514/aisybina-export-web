<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalReach extends Model
{
    protected $table = 'global_reach';

    protected $fillable = [
        'global_reach_title',
        'global_reach_description',
        'global_reach_image',
        'global_reach_item_1',
        'global_reach_item_2',
        'global_reach_item_3',
        'global_reach_icon_item_1',
        'global_reach_icon_item_2',
        'global_reach_icon_item_3',
    ];
}