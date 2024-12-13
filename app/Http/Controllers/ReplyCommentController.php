<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\ReplyComment;
use App\Models\ReplyCommentLike;
use App\Models\User;
use App\Notifications\CommentReplyNotification;
use App\Notifications\UserTaggedComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReplyCommentController extends Controller
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
    public function store(Request $request, Comment $comment)
    {
        $auth_user = Auth::user();
        $auth_user = User::find($auth_user->id);
        $response = ['success'=> false, 'comment' => []];

        $request->validate([
            'comment' => 'required|min:5|max:2000'
        ]);


        // dd(substr($comment, 0, 50));
        // $comment = mb_convert_encoding($comment, 'UTF-8', 'UTF-8');
        $data = [
            'user_id' => $auth_user->id,
            'post_id' => $comment->post_id,
            'replied_to' => $comment->id,
            'comment' => $request->comment,
            'comment_short' => $request->comment,
        ];
        // return $data;
        $new_comment = ReplyComment::create($data);

        $replied_to_user = $comment->user;
        if($replied_to_user->id != $auth_user->id){
            $replied_to_user->notify(new CommentReplyNotification($auth_user, $replied_to_user, $comment->post_id));
        }

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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, ReplyComment $reply)
    {
        $auth_user = Auth::user();

        $response = ['success' => false];
        if($auth_user->id == $reply->user_id){

            ReplyCommentLike::where('reply_comment_id', $reply->id)->delete();
            $reply->delete();


            $response['success'] = true;
        }

        return $response;
    }

    public function showLikes(Request $request, ReplyComment $reply){
        $user = Auth::user();

        $response = ['success' => false, 'likes' => '', 'last_like' => false];
        $last_id = $request->has('last_id') ? $request->last_id : 0;
        $likes = $reply->likes(false, $last_id)->get();
        if($likes->count() > 0){
            foreach ($likes as $like) {
                $like->user;

            }

            $last_id = $likes[$likes->count() - 1]->id;
            $response['last_like'] = $reply->likes(false, $last_id)->get()->count() > 0 ? false : true;
        }
        $response['likes'] = $likes;
        $response['success'] = true;




        return $response;

    }


    public function toggleLike(Request $request, Post $post, Comment $comment, ReplyComment $reply){

        $user = Auth::user();

        $response = ['success' => false, 'action' => ''];

        $reply_liked = $reply->liked;

        if($reply_liked){
            $reply_like = $reply->replyLike();
            $reply_like->delete();
            $response['action'] = 'unliked';
        }else{
            ReplyCommentLike::create([
                'user_id' => $user->id,
                'reply_comment_id' => $reply->id,
                'post_id' => $post->id,
                'comment_id' => $comment->id
            ]);
            $response['action'] = 'liked';
        }

        $response['success'] = true;

        return $response;

    }

}
