<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\HashTag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HashTagController extends Controller
{
    public $functions;
    public function __construct()
    {
        $this->functions = new UsefulFunctions();
    }

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $tag)
    {
        $auth_user = Auth::user();

        $props['auth_user'] = $auth_user;
        $props['tag'] = $tag;

        $tags = $this->functions->getPostsForHashTagPage($tag);


        if($tags->count() > 0){
            foreach ($tags as $tag) {
                $post = $tag->post;
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

        // return $tags;



        $props['posts'] = $tags;

        return Inertia::render('Hashtag/Show', $props);

    }

    public function loadMorePosts(Request $request, string $tag){
        $post_data = (Object) $request->input();
        // return $post_data;
        $user = Auth::user();
        $user = User::find($user->id);


        if($request->has('last_id')){
            $response = ['posts' => [], 'last_post' => false];
            $last_id = $request->last_id;
            $tags = $this->functions->getPostsForHashTagPage($tag, $last_id);


            if($tags->count() > 0){
                foreach ($tags as $tag) {
                    $post = $tag->post;
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
            $response['posts'] = $tags->count() > 0 ? $tags : [];
            $response['last_post'] = $tags->count() > 0 ? false : true;

            return $response;
        }
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
    public function destroy(string $id)
    {
        //
    }
}
