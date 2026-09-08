<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class InquiryForm extends Model
{
    use HasUuids;

    protected $table = 'inquiry_forms';

    protected $fillable = [
        'fullname',
        'company_name',
        'email',
        'whatsapp',
        'country',
        'product_interested',
        'estimated_quantity',
        'message',
    ];
}