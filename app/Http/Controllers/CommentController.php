<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\CommentLike;
use App\Models\Post;
use App\Models\ReplyComment;
use App\Models\ReplyCommentLike;
use App\Models\User;
use App\Notifications\UserTaggedComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $auth_user = Auth::user();
        $auth_user = User::find($auth_user->id);
        $response = ['success'=> false, 'comment' => []];

        $request->validate([
            'comment' => 'required|min:5|max:2000'
        ]);

        $comment = $request->comment;
        // dd(substr($comment, 0, 50));
        // $comment = mb_convert_encoding($comment, 'UTF-8', 'UTF-8');
        $data = [
            'user_id' => $auth_user->id,
            'post_id' => $post->id,
            'comment' => $comment,
            'comment_short' => $comment,
        ];
        // return $data;
        $new_comment = Comment::create($data);

        if(preg_match_all("/@(\w+)/", $comment, $matches)) {
            // dd($matches);
            if(count($matches[1]) > 0){
                foreach ($matches[1] as $mention) {
                    $user = User::where('user_name', $mention)->first();
                    if($user){
                        if($user->id != $auth_user->id){
                            $user->notify(new UserTaggedComment($auth_user, $user));
                        }
                    }
                }
            };
        }

        $response['success'] = true;
        $new_comment->user;
        $new_comment->likes;
        $new_comment->replies = [];
        $response['comment'] = $new_comment;

        return back()->with('data', $response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Comment $comment)
    {
        $auth_user = Auth::user();

        $response = ['success' => false];
        if($auth_user->id == $comment->user_id){

            CommentLike::where('comment_id', $comment->id)->delete();
            ReplyComment::where('replied_to', $comment->id)->delete();
            ReplyCommentLike::where('comment_id', $comment->id)->delete();
            $comment->delete();

            $response['success'] = true;
        }

        return $response;
    }

    public function loadReplies(Request $request, Post $post, Comment $comment){
        $user = Auth::user();

        $response = ['success' => false, 'replies' => [], 'rem' => null];
        $last_id = $request->has('last_id') ? $request->last_id : 0;
        $replies = $comment->replies(false, $last_id)->get();
        if($replies->count() > 0){
            foreach ($replies as $reply) {
                $reply->user;
                $reply->likes;
            }

            $last_id = $replies[$replies->count() - 1]->id;
            $response['rem'] = $comment->replies(true, $last_id)->get()->count();
        }
        $response['replies'] = $replies;
        $response['success'] = true;




        return $response;

    }

    public function showLikes(Request $request, Comment $comment){
        $user = Auth::user();

        $response = ['success' => false, 'likes' => '', 'last_like' => false];
        $last_id = $request->has('last_id') ? $request->last_id : 0;
        $likes = $comment->likes(false, $last_id)->get();
        if($likes->count() > 0){
            foreach ($likes as $like) {
                $like->user;

            }

            $last_id = $likes[$likes->count() - 1]->id;
            $response['last_like'] = $comment->likes(false, $last_id)->get()->count() > 0 ? false : true;
        }
        $response['likes'] = $likes;
        $response['success'] = true;




        return $response;

    }

    public function toggleLike(Request $request, Post $post, Comment $comment){
        $user = Auth::user();

        $response = ['success' => false, 'action' => ''];

        $comment_liked = $comment->liked;

        if($comment_liked){
            $comment_like = $comment->commentLike();
            $comment_like->delete();
            $response['action'] = 'unliked';
        }else{
            CommentLike::create([
                'user_id' => $user->id,
                'comment_id' => $comment->id,
                'post_id' => $post->id
            ]);
            $response['action'] = 'liked';
        }

        $response['success'] = true;

        return $response;

    }
}
