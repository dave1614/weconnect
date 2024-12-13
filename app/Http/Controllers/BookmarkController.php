<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookmarkController extends Controller
{

    public $functions;

    public function __construct(){
        $this->functions = new UsefulFunctions();
    }



    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $auth_user = Auth::user();




        $bookmarks = $this->functions->getPostsForBookmarksPage($auth_user->id);


        if($bookmarks->count() > 0){
            foreach ($bookmarks as $bookmark) {
                $post = $bookmark->post;
                // return $tag->post;


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

        // return $bookmarks;



        $props['posts'] = $bookmarks;

        return Inertia::render('Bookmarks/Index', $props);


    }

    public function loadMorePosts(Request $request){
        $post_data = (Object) $request->input();
        // return $post_data;
        $user = Auth::user();
        $user = User::find($user->id);


        if($request->has('last_id')){
            $response = ['posts' => [], 'last_post' => false];
            $last_id = $request->last_id;
            $bookmarks = $this->functions->getPostsForBookmarksPage($user->id, $last_id);
            // return $bookmarks;


            if($bookmarks->count() > 0){
                foreach ($bookmarks as $bookmark) {
                    $post = $bookmark->post;
                    // return $tag->post;


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
            $response['posts'] = $bookmarks->count() > 0 ? $bookmarks : [];
            $response['last_post'] = $bookmarks->count() > 0 ? false : true;

            return $response;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
    public function destroy(string $id)
    {
        //
    }
}
