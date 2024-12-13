<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'ward_id',
        'logo',
        'cover_photo',
        'history',
        'gallery',
    ];
}
