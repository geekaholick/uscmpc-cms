<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherServices extends Model
{
    use HasFactory;

    public static $STATUS = [
        0 => 'inactive',
        1 => 'active',
        2 => 'removed',
    ];

    protected $fillable = [
        'title',
        'description',
        'image',
        'status', 
        'icon',
    ];

    public function getImageAttribute($value)
    {
        return Storage::url("service/" . $value);
    }

}
