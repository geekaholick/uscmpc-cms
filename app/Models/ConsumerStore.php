<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumerStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'price_item',
        'price_batch',
        'description',
        'status',
        'effective_date',
    ];

    public static $STATUS = [
        1 => 'active',
        0 => 'inactive',
        2 => 'removed'
    ];
}
