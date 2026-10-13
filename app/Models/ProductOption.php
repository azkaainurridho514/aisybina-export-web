<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ProductOption extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'product_options';
    protected $fillable = [
        'product_id',
        'option_id',
    ];

    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }
}
