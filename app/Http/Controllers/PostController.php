<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\HashTag;
use App\Models\PostFavorite;
use App\Models\PostLike;
use App\Models\ReplyComment;
use App\Models\ReplyCommentLike;
use App\Models\User;
use App\Notifications\PostLikedNotification;
use App\Notifications\UserTaggedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Intervention\Image\Laravel\Facades\Image;

class PostController extends Controller
{

    public UsefulFunctions $functions;

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
        // return $request->all();
        $auth_user = Auth::user();
        $response = ['success' => false];

        $img_ext_arr = ['jpeg', 'jpg', 'png', 'gif'];
        $rules = [
            'caption' => 'required|min:10|max:3000',
            'media' => 'required|max:10',
            'media.*' => 'required|mimes:jpeg,jpg,png,gif,mp4|max:10000',
        ];

        $messages = [
            'media.required' => 'You must select media files to upload',
            'media.max' => 'You cannot select more than 10 media files in one post',
            'media.*.mimes' => 'Only jpeg, jpg, png, gif and mp4 files are allowed',
            'media.*.max' => 'Media file cannot exceed 10MB'
        ];

        $request->validate($rules, $messages);

        if($request->hasFile('media')){
            $media_arr = [];
            $files = $request->file('media');

            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

                $new_name = $this->functions->generateNewUniqueNameForImage(in_array($extension, $img_ext_arr) ? 'image': 'video');

                $new_name = $new_name . '.' . $extension;

                if( in_array($extension, $img_ext_arr)){
                    $destination_path = public_path('/images');
                    $file->move($destination_path, $new_name);
                    $media_arr[] = [
                        'type' => 'image',
                        'small_path' => "/images/{$new_name}",
                        'path' => "/images/{$new_name}",
                    ];
                }else{
                    $destination_path = public_path('/videos');
                    $file->move($destination_path, $new_name);
                    $media_arr[] = [
                        'type' => 'video',
                        'small_path' => "/videos/{$new_name}",
                        'path' => "/videos/{$new_name}",
                    ];
                }

            }

            // return $media_arr;

            $caption = str_replace("\n", " ", $request->caption);
            $caption_short = substr($caption, 0, 50);

            $post = Post::create([
                'user_id' => $auth_user->id,
                'caption' => $caption,
                'caption_short' => $caption_short,
                'media' => json_encode($media_arr),
                'ward_id' => $request->for_community ? $auth_user->ward_id : null
            ]);

            if(preg_match_all("/@(\w+)/", $request->caption, $matches)) {
                // dd($matches);
                if(count($matches[1]) > 0){
                    foreach ($matches[1] as $mention) {
                        $user = User::where('user_name', $mention)->first();
                        if($user){
                            if($user->id != $auth_user->id){
                                $user->notify(new UserTaggedPost($auth_user, $user, $post));
                            }
                        }
                    }
                };
            }

            preg_match_all('/#(\w+)/', $request->caption, $matches);
            if(count($matches[1]) > 0){
                foreach ($matches[1] as $hashtag) {

                    if(HashTag::where('name', $hashtag)->where('post_id', $post->id)->count() == 0){
                        HashTag::create([
                            'name' => $hashtag,
                            'post_id' => $post->id
                        ]);
                    }
                }
            }

            $response['success'] = true;
        }


        return back()->with('data', $response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post)
    {
        $auth_user = Auth::user();
        $props['auth_user'] = $auth_user;

        $post->user;
        $post->comments;
        $post->likes;
        foreach ($post->comments as $comment) {
            $comment->user;
            $comment->user->state;
            $comment->likes;
            $comment->replies = [];
        }
        $props['post'] = $post;


        return Inertia::render('Post/Show', $props);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Post $post)
    {
        $auth_user = Auth::user();
        $props['auth_user'] = $auth_user;
        $props['post'] = $post;


        $props['deletePost'] = $request->has('delete') ? true : false;

        return Inertia::render('Post/Edit', $props);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $auth_user = Auth::user();
        $response = ['success' => false];
        if($post->user_id == $auth_user->id){


            $request->validate([
                'caption' => 'required|min:10|max:3000',
            ]);

                // return $media_arr;

            $caption = str_replace("\n", " ", $request->caption);
            $caption_short = substr($caption, 0, 50);

            $post->caption = $caption;
            $post->caption_short = $caption_short;

            $post->save();


            // if(preg_match_all("/@(\w+)/", $request->caption, $matches)) {
            //     // dd($matches);
            //     if(count($matches[1]) > 0){
            //         foreach ($matches[1] as $mention) {
            //             $user = User::where('user_name', $mention)->first();
            //             if($user){
            //                 if($user->id != $auth_user->id){
            //                     $user->notify(new UserTaggedPost($auth_user, $user, $post));
            //                 }
            //             }
            //         }
            //     };
            // }

            preg_match_all('/#(\w+)/', $request->caption, $matches);
            if(count($matches[1]) > 0){
                foreach ($matches[1] as $hashtag) {
                    if(HashTag::where('name', $hashtag)->where('post_id', $post->id)->count() == 0){
                        HashTag::create([
                            'name' => $hashtag,
                            'post_id' => $post->id
                        ]);
                    }
                }
            }

            $response['success'] = true;

        }

        return back()->with('data', $response);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        $auth_user = Auth::user();
        $response = ['success' => false];
        if($post->user_id == $auth_user->id){
            $media_arr = $post->media;
            // return var_dump($media_arr);
            for($i = 0; $i < count($media_arr); $i++){
                if(file_exists(public_path($media_arr[$i]->path))){
                    unlink(public_path($media_arr[$i]->path));
                }


            }

            HashTag::where('post_id', $post->id)->delete();
            Comment::where('post_id', $post->id)->delete();
            ReplyComment::where('post_id', $post->id)->delete();
            PostFavorite::where('post_id', $post->id)->delete();
            PostLike::where('post_id', $post->id)->delete();
            CommentLike::where('post_id', $post->id)->delete();
            ReplyCommentLike::where('post_id', $post->id)->delete();




            $post->delete();

            $response['success'] = true;
        }

        return $response;
    }



    public function updateMediaFile(Request $request, Post $post){
        $auth_user = Auth::user();
        $response = ['success' => false];
        if($post->user_id == $auth_user->id){

            if($request->has('index') && $request->has('type') && $request->has('path')){

                $rules = [
                    'media' => 'required|mimes:jpeg,jpg,png,gif,mp4|max:10000'
                ];

                $messages = [
                    'media.required' => 'You must select media files to upload',
                    'media.mimes' => 'Only jpeg, jpg, png, gif and mp4 files are allowed',
                    'media.max' => 'Media file cannot exceed 10MB'
                ];

                $request->validate($rules, $messages);

                $media_arr = $post->media;

                for($i = 0; $i < count($media_arr); $i++){
                    if($request->index == $i && $request->type == $media_arr[$i]->type && $request->path == $media_arr[$i]->path){

                        if($request->hasFile('media')){
                            $media = $request->file('media');
                            $extension = $media->getClientOriginalExtension();
                            $file_name = time().'.'.$extension;

                            if($extension != "mp4"){

                                //resize image laravel
                                // $resizedImage = Image::read($media->getRealPath());
                                // $resizedImage->resize(800, 600, function ($constraint) {
                                //     $constraint->aspectRatio();
                                //     $constraint->upsize();
                                // });

                                // $resizedImage->save(public_path('/images/' .$file_name));

                                $destination_path = public_path('/images');
                                $media->move($destination_path, $file_name);

                                if(file_exists(public_path($media_arr[$i]->path))){
                                    unlink(public_path($media_arr[$i]->path));
                                }
                                $media_arr[$i] = [
                                    'type' => 'image',
                                    'small_path' => "/images/{$file_name}",
                                    'path' => "/images/{$file_name}",
                                ];



                            }else{
                                $destination_path = public_path('/videos');
                                $media->move($destination_path, $file_name);

                                if(file_exists(public_path($media_arr[$i]->path))){
                                    unlink(public_path($media_arr[$i]->path));
                                }
                                $media_arr[$i] = [
                                    'type' => 'video',
                                    'small_path' => "/videos/{$file_name}",
                                    'path' => "/videos/{$file_name}",
                                ];
                            }


                            // return $media_arr;
                            $post->media = json_encode($media_arr);
                            $post->save();
                            $response['success'] = true;
                            $response['media'] = $media_arr;
                        }
                    }
                }

            }
        }
        return back()->with('data', $response);
    }

    public function addNewMediaFile(Request $request, Post $post){
        $auth_user = Auth::user();
        $response = ['success' => false];
        if($post->user_id == $auth_user->id){

            $rules = [
                'media' => 'required|mimes:jpeg,jpg,png,gif,mp4|max:10000'
            ];

            $messages = [
                'media.required' => 'You must select media files to upload',
                'media.mimes' => 'Only jpeg, jpg, png, gif and mp4 files are allowed',
                'media.max' => 'Media file cannot exceed 10MB'
            ];

            $request->validate($rules, $messages);

            $media_arr = $post->media;
            if(count($media_arr) < 10){

                if($request->hasFile('media')){
                    $media = $request->file('media');
                    $extension = $media->getClientOriginalExtension();
                    $file_name = time().'.'.$extension;

                    if($extension != "mp4"){

                        //resize image laravel
                        // $resizedImage = Image::read($media->getRealPath());
                        // $resizedImage->resize(800, 600, function ($constraint) {
                        //     $constraint->aspectRatio();
                        //     $constraint->upsize();
                        // });

                        // $resizedImage->save(public_path('/images/' .$file_name));

                        $destination_path = public_path('/images');
                        $media->move($destination_path, $file_name);
                        $media_arr[] = [
                            'type' => 'image',
                            'small_path' => "/images/{$file_name}",
                            'path' => "/images/{$file_name}",
                        ];



                    }else{
                        $destination_path = public_path('/videos');
                        $media->move($destination_path, $file_name);
                        $media_arr[] = [
                            'type' => 'video',
                            'small_path' => "/videos/{$file_name}",
                            'path' => "/videos/{$file_name}",
                        ];
                    }

                    $post->media = json_encode($media_arr);
                    $post->save();
                    $response['success'] = true;
                    $response['media'] = $media_arr;
                }
            }
        }
        return back()->with('data', $response);
    }

    public function deleteMedia(Request $request, Post $post){
        $auth_user = Auth::user();
        if($post->user_id == $auth_user->id){
            $response = ['success' => false];

            if($request->has('index') && $request->has('file_name')){
                $media_arr = $post->media;
                // return var_dump($media_arr);
                for($i = 0; $i < count($media_arr); $i++){
                    if($media_arr[$i]->path == $request->file_name && $request->index == $i){
                        if(file_exists(public_path($request->file_name))){
                            unlink(public_path($request->file_name));
                        }
                        unset($media_arr[$i]);
                        $media_arr = array_values($media_arr);
                        // return json_encode($media_arr);
                    }
                }
                $post->update([
                    'media' => json_encode($media_arr)
                ]);

                $response['success'] = true;
                $response['media'] = $media_arr;
            }

            return $response;
        }
    }

    public function toggleFavorite(Request $request, Post $post){
        $user = Auth::user();

        $response = ['success' => false, 'action' => ''];

        $is_favorite = $post->is_favorite;

        if($is_favorite){
            $favorite = PostFavorite::where('post_id', $post->id)->where('user_id', $user->id)->first();
            $favorite->delete();
            $response['action'] = 'unfavorited';
        }else{
            PostFavorite::create([
                'user_id' => $user->id,
                'post_id' => $post->id
            ]);
            $response['action'] = 'favorited';
        }

        $response['success'] = true;

        return $response;

    }

    public function showLikes(Request $request, Post $post){
        $user = Auth::user();

        $response = ['success' => false, 'likes' => '', 'last_like' => false];
        $last_id = $request->has('last_id') ? $request->last_id : 0;
        $likes = $post->likes(false, $last_id)->get();
        if($likes->count() > 0){
            foreach ($likes as $like) {
                $like->user;

            }

            $last_id = $likes[$likes->count() - 1]->id;
            $response['last_like'] = $post->likes(false, $last_id)->get()->count() > 0 ? false : true;
        }
        $response['likes'] = $likes;
        $response['success'] = true;




        return $response;

    }

    public function loadMoreComments(Request $request, Post $post){
        $user = Auth::user();


        if($request->has('last_id')){
            $response = ['comments' => [], 'last_comment' => false];
            $last_id = $request->last_id;
            $comments = $post->comments(false, $last_id)->get();

            // return $comments->count();

            if($comments->count() > 0){
                foreach ($comments as $comment) {
                    $comment->user;
                    $comment->likes;


                     $comment->replies = [];
                    // if($replies->count() > 0){
                    //     $replies->user;
                    //     $replies->likes;
                    // }
                }

            }
            $response['comments'] = $comments->count() > 0 ? $comments : [];
            $response['last_comment'] = $comments->count() > 0 ? false : true;

            return $response;
        }
    }


    public function toggleLike(Request $request, Post $post){
        $auth_user = Auth::user();

        $response = ['success' => false, 'action' => ''];

        $liked = $post->liked;

        if($liked){
            $like = $post->postLike();
            $like->delete();
            $response['action'] = 'unliked';
        }else{
            PostLike::create([
                'user_id' => $auth_user->id,
                'post_id' => $post->id
            ]);

            if($auth_user->id != $post->user_id){
                $post_user = User::find($post->user_id);

                $post_user->notify(new PostLikedNotification($auth_user, $post, $post_user));
            }
            $response['action'] = 'liked';
        }

        $response['success'] = true;

        return $response;

    }
}
