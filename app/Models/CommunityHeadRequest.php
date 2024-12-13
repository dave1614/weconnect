<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityHeadRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ward_id',
        'community_leader_role_id',
    ];
}
