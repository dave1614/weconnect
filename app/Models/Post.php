<?php

namespace App\Models;

use App\Functions\UsefulFunctions;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'caption',
        'caption_short',
        'media',
        'ward_id'
    ];

    protected $with = ['community'];
    protected $appends = ['relative_time', 'show_more', 'liked', 'following_author', 'more_comments', 'likes_num', 'comments_num', 'last_comment', 'is_favorite', 'favorite_loading', 'html_caption', 'html_caption_short'];

    public function community(): BelongsTo {
        return $this->belongsTo(InecWard::class, 'ward_id');
    }

    public function htmlCaptionShort(): Attribute {
        $functions = new UsefulFunctions();
        return Attribute::make(
            get: fn () => !$functions->isHtml($this->caption_short) ? $functions->searchTextForUserTags($functions->searchTextForHashTags($this->caption_short)) : $this->caption_short
        );
    }

    public function htmlCaption(): Attribute {
        $functions = new UsefulFunctions();
        return Attribute::make(
            get: fn () => !$functions->isHtml($this->caption) ? $functions->searchTextForUserTags($functions->searchTextForHashTags($this->caption)) : $this->caption
        );
    }

    public function favoriteLoading(): Attribute {
        return Attribute::make(
            get: fn () => false
        );
    }

    public function isFavorite(): Attribute {
        return Attribute::make(
            get: fn () => PostFavorite::where('post_id', $this->id)->where('user_id', auth()->id())->exists()
        );
    }

    public function lastComment(): Attribute {

        return Attribute::make(
            get: fn() => $this->comments(true)->count() <= 5
        );
    }

    public function likesNum(): Attribute {
        return Attribute::make(
            get: fn () => $this->likes(true)->count()
        );
    }

    public function commentsNum(): Attribute {
        return Attribute::make(
            get: fn () => $this->comments(true)->count()
        );
    }

    public function postLike(){
        return $this->liked() ? $this->likes(true)->where('user_id', auth()->id())->first() : false;
    }

    public function moreComments(): Attribute {
        return Attribute::make(
            get: fn () => $this->comments(true)->count() > 5
        );
    }

    public function followingAuthor(): Attribute {
        return Attribute::make(
            get: fn ($value, $attributes) => User::find($attributes['user_id'])->followers()->where('follower', auth()->id())->exists()
        );
    }

    public function media(): Attribute {
        return Attribute::make(
            get: fn ($value) => json_decode($value)
        );
    }

    public function liked(): Attribute {
        return Attribute::make(
            get: fn () => $this->likes(true)->where('user_id', auth()->id())->exists()
        );
    }

    public function showMore(): Attribute {
        return Attribute::make(
            get: fn () => false
        );
    }

    public function relativeTime(): Attribute {
        return Attribute::make(
            get: fn () => $this->created_at->diffForHumans(now(), CarbonInterface::DIFF_ABSOLUTE, true)
        );
    }

    public function likes($all = false, $last_id = 0): HasMany
    {

        // return $all ? $this->hasMany(PostLike::class) : $this->hasMany(PostLike::class)->orderBy('id', 'DESC')->limit(10);

        if($all){
            return  $this->hasMany(PostLike::class);
        }else if(!$all && $last_id == 0){
            return $this->hasMany(PostLike::class)->orderBy('id', 'DESC')->limit(10);
        }else{
            return $this->hasMany(PostLike::class)->where('id', '<', $last_id)->orderBy('id', 'DESC')->limit(10);
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments($all = false, $last_id = 0): HasMany
    {
        // return $all ? $this->hasMany(Comment::class) : $this->hasMany(Comment::class)->orderBy('likes_num', 'DESC')->limit(5);


        if($all){
            return  $this->hasMany(Comment::class);
        }else if(!$all && $last_id == 0){
            return $this->hasMany(Comment::class)->orderBy('id', 'DESC')->limit(5);
        }else{
            return $this->hasMany(Comment::class)->where('id', '<', $last_id)->orderBy('id', 'DESC')->limit(5);
        }
    }

}
