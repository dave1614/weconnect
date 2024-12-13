<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\CommentLike;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public UsefulFunctions $functions;

    public function __construct()
    {
        $this->functions = new UsefulFunctions();
    }


    public function socialMediaHomePage(Request $request){
        $props = [];

        $user = Auth::user();
        $user = User::find($user->id);
        $props['user'] = $user;

        $posts = $this->functions->getPostsForUserFrontPage($user->id);
        // return $posts->count();
        if($posts->count() > 0){
            foreach ($posts as $post) {
                $post->user;
                $post->comments;
                $post->likes;
                foreach ($post->comments as $comment) {
                    $comment->user;
                    $comment->user->state;
                    $comment->likes;
                    $comment->replies = [];
                }
            }
        }
        $props['posts'] = $posts;

        // return $props;

        return Inertia::render('Home', $props);
    }




    public function loadMorePosts(Request $request){
        $post_data = (Object) $request->input();
        // return $post_data;
        $user = Auth::user();
        $user = User::find($user->id);


        if($request->has('last_id')){
            $response = ['posts' => [], 'last_post' => false];
            $last_id = $request->last_id;
            $posts = $this->functions->getPostsForUserFrontPage($user->id, $last_id);

            if($posts->count() > 0){
                foreach ($posts as $post) {
                    $post->user;
                    $post->comments;
                    $post->likes;
                    foreach ($post->comments as $comment) {
                        $comment->user;
                        $comment->user->state;
                        $comment->likes;
                        $comment->replies = [];
                    }
                }
            }
            $response['posts'] = $posts->count() > 0 ? $posts : [];
            $response['last_post'] = $posts->count() > 0 ? false : true;

            return $response;
        }
    }

}
