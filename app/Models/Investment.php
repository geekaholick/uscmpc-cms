<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investment extends Model
{
    use HasFactory, SoftDeletes;

    public static $STATUS = [
        0 => 'inactive',
        1 => 'active',
        2 => 'removed',
    ];

    protected $fillable = [
        'title',
        'description',
        'image',
        'icon',
        'status'
    ];
    
}
