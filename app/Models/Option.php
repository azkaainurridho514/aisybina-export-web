<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Option extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'options';
    protected $fillable = [
        'title',
        'description',
    ];

    public function items()
    {
        return $this->hasMany(OptionItem::class, 'option_id');
    }

    public function productOptions()
    {
        return $this->hasMany(ProductOption::class, 'option_id');
    }
}
