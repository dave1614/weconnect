<?php

namespace App\Models;

use App\Functions\UsefulFunctions;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'likes_num',
        'comment',
        'comment_short',
    ];

    protected $appends = ['relative_time', 'show_more', 'liked', 'replies_num', 'total_replies_num', 'likes_num', 'loading_replies', 'html_comment', 'deleting_loading', 'html_comment', 'html_comment_short'];

    public function htmlCommentShort(): Attribute {
        $functions = new UsefulFunctions();
        return Attribute::make(
            get: fn () => !$functions->isHtml($this->comment_short) ? $functions->searchTextForUserTags($functions->searchTextForHashTags($this->comment_short)) : $this->comment_short
        );
    }

    public function htmlComment(): Attribute {
        $functions = new UsefulFunctions();
        return Attribute::make(
            get: fn () => !$functions->isHtml($this->comment) ? $functions->searchTextForUserTags($functions->searchTextForHashTags($this->comment)) : $this->comment
        );
    }

    public function deletingLoading(): Attribute {
        return Attribute::make(
            get: fn () => false
        );
    }


    public function loadingReplies(): Attribute {
        return Attribute::make(
            get: fn () => false
        );
    }

    public function commentLike(){
        return $this->liked() ? CommentLike::where('user_id', auth()->id())->where('comment_id', $this->id)->first() : false;
        // return Attribute::make(
        //     get: fn () =>
        // );
    }

    public function likesNum(): Attribute {
        return Attribute::make(
            get: fn () => $this->likes(true)->count()
        );
    }

    public function totalRepliesNum(): Attribute {
        return Attribute::make(
            get: fn () => $this->replies(true)->count()
        );
    }

    public function repliesNum(): Attribute {
        return Attribute::make(
            get: fn () => $this->replies(true)->count()
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

        if($all){
            return  $this->hasMany(CommentLike::class);
        }else if(!$all && $last_id == 0){
            return $this->hasMany(CommentLike::class)->orderBy('id', 'DESC')->limit(10);
        }else{
            return $this->hasMany(CommentLike::class)->where('id', '<', $last_id)->orderBy('id', 'DESC')->limit(10);
        }
    }


    public function replies($all = false, $last_id = 0): HasMany{
        // return $all ? $this->hasMany(ReplyComment::class, 'replied_to') : $this->hasMany(ReplyComment::class,  'replied_to')->orderBy('id', 'ASC')->limit(10);

        if($all){
            return $last_id == 0 ? $this->hasMany(ReplyComment::class, 'replied_to') : $this->hasMany(ReplyComment::class, 'replied_to')->where('id', '<', $last_id)->orderBy('id', 'DESC');
        }else if(!$all && $last_id == 0){
            return $this->hasMany(ReplyComment::class, 'replied_to')->orderBy('id', 'DESC')->limit(10);
        }else{
            return $this->hasMany(ReplyComment::class, 'replied_to')->where('id', '<', $last_id)->orderBy('id', 'DESC')->limit(10);
        }
    }

    public function post(): BelongsTo{
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
