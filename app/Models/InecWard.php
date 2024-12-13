<?php

namespace App\Models;

use App\Functions\UsefulFunctions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InecWard extends Model
{
    use HasFactory;

    protected $with = ['state', 'lga'];
    protected $appends = ['total_posts_num', 'leaders_num', 'residents_num'];


    public function gallery($all = false, $last_id = 0): HasMany
    {
        if($all){
            return  $this->hasMany(CommunityGallery::class, 'ward_id');
        }else if(!$all && $last_id == 0){
            return $this->hasMany(CommunityGallery::class, 'ward_id')->orderBy('id', 'DESC')->limit(6);
        }else{
            return $this->hasMany(CommunityGallery::class, 'ward_id')->where('id', '<', $last_id)->orderBy('id', 'DESC')->limit(6);
        }
    }

    public function residents($all = false, $last_id = 0): HasMany
    {

        // return $all ? $this->hasMany(PostLike::class) : $this->hasMany(PostLike::class)->orderBy('id', 'DESC')->limit(10);

        if($all){
            return  $this->hasMany(User::class, 'ward_id');
        }else if(!$all && $last_id == 0){
            return $this->hasMany(User::class, 'ward_id')->orderBy('id', 'DESC')->limit(10);
        }else{
            return $this->hasMany(User::class, 'ward_id')->where('id', '<', $last_id)->orderBy('id', 'DESC')->limit(10);
        }
    }

    public function leadersNum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->users()->whereRaw('community_leader IS NOT NULL')->count(),
        );
    }


    public function residentsNum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->users()->count(),
        );
    }


    public function totalPostsNum(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->posts()->count(),
        );
    }

    public function posts(): HasMany {
        return $this->hasMany(Post::class, 'ward_id');
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(InecLga::class, 'inec_lga_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(InecState::class, 'inec_state_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'ward_id');
    }

    public function communityLeaderRequests(): HasMany
    {
        return $this->hasMany(CommunityHeadRequest::class, 'ward_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(CommunityGallery::class, 'ward_id');
    }

}
