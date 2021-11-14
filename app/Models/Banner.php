<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'subtitle',
        'link',
        'image',
        'button_text',
        'icon',
        'logo',
        'status',
    ];

    public function getImageAttribute($value)
    {
        return Storage::url("banner/" . $value);
    }

    public function getLogoAttribute($value)
    {
        return Storage::url("logo/" . $value);
    }
}
