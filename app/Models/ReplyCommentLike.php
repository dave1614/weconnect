<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReplyCommentLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reply_comment_id',
        'post_id',
        'comment_id',
    ];

    public function replyComment(): BelongsTo{
        return $this->belongsTo(Comment::class, 'replied_to');
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}
