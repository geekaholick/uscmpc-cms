<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class History extends Model
{
    use HasFactory;

    protected $table = 'HISTORY';

    protected $fillable =[
        'content',
        'image',
        'title'
    ];
    public function getImageAttribute($value)
    {
        return Storage::url("history/" . $value);
    }
}

