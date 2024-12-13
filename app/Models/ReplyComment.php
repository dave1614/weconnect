<?php

namespace App\Models;

use App\Functions\UsefulFunctions;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReplyComment extends Model
{
    use HasFactory;

    protected $appends = ['relative_time', 'show_more', 'liked', 'likes_num', 'html_reply' , 'deleting_loading'];



    protected $fillable = [
        'user_id',
        'post_id',
        'likes_num',
        'comment',
        'comment_short',
        'replied_to',
    ];

    public function deletingLoading(): Attribute {
        return Attribute::make(
            get: fn () => false
        );
    }

    public function htmlReply(): Attribute {
        $functions = new UsefulFunctions();
        return Attribute::make(
            get: fn () => $functions->searchTextForHashTags($functions->searchTextForUserTags($this->comment))
        );
    }

    public function likesNum(): Attribute {
        return Attribute::make(
            get: fn () => $this->likes(true)->count()
        );
    }


    public function replyLike(){
        return $this->liked() ? ReplyCommentLike::where('user_id', auth()->id())->where('reply_comment_id', $this->id)->first() : false;
        // return Attribute::make(
        //     get: fn () =>
        // );
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

        if($all){
            return  $this->hasMany(ReplyCommentLike::class);
        }else if(!$all && $last_id == 0){
            return $this->hasMany(ReplyCommentLike::class)->orderBy('id', 'DESC')->limit(10);
        }else{
            return $this->hasMany(ReplyCommentLike::class)->where('id', '<', $last_id)->orderBy('id', 'DESC')->limit(10);
        }
    }


    public function comment(): BelongsTo{
        return $this->belongsTo(Comment::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
