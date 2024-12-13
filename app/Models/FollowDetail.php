<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        "follower",
        "followed",
    ];

    protected $appends = ['follower_details', 'following_details'];

    public function followerDetails(): Attribute {
        return Attribute::make(
            get: fn() => User::find($this->follower)
        );
    }

    public function followingDetails(): Attribute {
        return Attribute::make(
            get: fn() => User::find($this->followed)
        );
    }

    // public function follower(): BelongsTo {
    //     return $this->belongsTo(User::class, 'follower');
    // }
}
