<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\Post;
use App\Models\RecentSearch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SearchController extends Controller
{
    public $functions;

    public function __construct(){
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
        $auth = Auth::user();

        // return var_dump($request->search);
        $response = ['success' => false];
        if($request->has('search') && is_array($request->search)){
            $search = $request->search;

            $this->functions->createRecentSearch($search);

            $response['success'] = true;
        }
        return back()->with('data', $response);


    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $auth_user = Auth::user();

        $search_param = $request->has('search') ? $request->search : null;
        if($search_param != null){

            $props['search_param'] = $search_param;

            $posts = $this->functions->getPostsForSearchPage($search_param);

            if($posts->count() > 0){
                foreach ($posts as $post) {
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



            $props['posts'] = $posts;

            return Inertia::render('Search/Show', $props);
        }
    }

    public function loadMorePosts(Request $request, string $search_param){
        $post_data = (Object) $request->input();
        // return $post_data;
        $user = Auth::user();
        $user = User::find($user->id);


        if($request->has('last_id')){
            $response = ['posts' => [], 'last_post' => false];
            $last_id = $request->last_id;
            $posts = $this->functions->getPostsForSearchPage($search_param, $last_id);



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

    public function runSearch(Request $request){

        $auth_user = Auth::user();

        $response = ['success' => false, 'results' => []];
        if($request->has('param')){
            $param = $request->param;
            $response['success'] = true;
            $response['user_id'] = $auth_user->id;
            if(substr($param, 0, 1) != ""){
                $users = User::where('user_name', 'like', "%{$param}%")->orWhere('name', 'like', "%{$param}%")->limit(20)->get();

                if($users->count() > 0){
                    $results = [];

                    foreach($users as $user){
                        $results[] = [
                            'user_id' => $auth_user->id,
                            'type' => 'user',
                            'search' => null,
                            'searched_user_id' => $user->id,
                            'searched_user' => $user,

                        ];
                    }

                    $response['results'] = $results;
                }
            }

            $response['success'] = true;
        }


        return $response;
    }

    public function deleteAllRecentSearches(Request $request){
        $user = Auth::user();
        $response = ['success' => false];

        if($request->has('delete_all')){
            RecentSearch::where('user_id', $user->id)->delete();
            $response['success'] = true;
        }

        return $response;
    }

    public function deleteSingleRecentSearch(Request $request, RecentSearch $search){
        $user = Auth::user();
        $response = ['success' => false];

        if($search->user_id == $user->id){
            $search->delete();
            $response['success'] = true;
        }

        return $response;
    }

    public function recentSearches(Request $request){
        $user = Auth::user();
        $response = ['success' => false, 'recent_searches' => []];
        if($request->has('load_search')){
            $recent_searches = RecentSearch::where('user_id', $user->id)->latest()->limit(50)->get();

            $response['success'] = true;
            $response['recent_searches'] = $recent_searches;
        }

        return $response;
    }
}
