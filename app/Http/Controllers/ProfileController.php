<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\Country;
use App\Models\User;
use App\Rules\CountryRule;
use App\Rules\PhoneEditProfRule;
use App\Rules\PhoneRegistrRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    public UsefulFunctions $functions;

    public function __construct()
    {
        $this->functions = new UsefulFunctions();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $auth_user = Auth::user();

        $props['auth_user'] = $auth_user;
        $props['user'] = $user;



        $posts = $this->functions->getPostsForUserProfilePage($user->id);
        $props['posts'] = $posts;

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

        // return $posts;

        return Inertia::render('Profile/Show', $props);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $props = [];
        $real_countries = [];
        $user = Auth::user();
        $countries = Country::where('id', '!=', '0')->orderBy("name", "ASC")->get();

        $i = -1;
        foreach($countries as $country){
            $i++;
            $id = $country->id;
            $name = $country->name;
            $phone_code = $country->phone_code;

            $real_countries[] = [
                'id' => $id,
                'label' => $name . ' (' . $phone_code . ')',
            ];

            // $props['selected_country'] = !isset($props['selected_country']) && $id == $user->country_id = $i;
            if($id == $user->country_id){
                $props['selected_country'] = $i;
            }
        }
        // dd($user->country_id);
        // dd($props['selected_country']);
        // return $real_countries;
        $props['user'] = $user;

        $props['countries'] = $real_countries;
        // return $user;
        return Inertia::render('EditProfile',$props);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $user = User::find($user->id);
        // return $request->country['id'];

        $response_arr = ['success' => false,'email_changed' => false];

        $rules = [
            'email' => 'required|string|email|max:255',
            // 'country' => ['required', new CountryRule],
            'name' => 'required|string|max:255',
            'phone' => ['required', 'numeric', 'min_digits:7', 'max_digits:15', new PhoneEditProfRule($user->id)],
            'address' => 'required|string|max:1000',

        ];

        $messages = [
            'sponsor_user_name.exists' => 'This user does not exist.',
        ];

        $request->validate($rules, $messages);

        // $user->country_id = $request->country['id'];
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if($user->email != $request->email){
            $response_arr['email_changed'] = true;
            $user->newEmail($request->email);
        }

        $user->save();

        $response_arr['success'] = true;

        return back()->with('data', $response_arr);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function updateProfilePicture(Request $request){
        $user = Auth::user();
        $user = User::find($user->id);

        $response_arr = ['success' => false];

        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:3048',
        ];

        $request->validate($rules);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/profile_pics');
            //resize image laravel
            $resizedImage = Image::read($image->getRealPath());
            $resizedImage->resize(400, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $resizedImage->save(public_path('/profile_pics/' .$image_name));
            $former_photo = $user->profile_picture;
            if(!is_null($former_photo)){
                unlink(public_path($former_photo));
            }
            $user->profile_picture = '/profile_pics/' . $image_name;
            $user->save();

            $response_arr['success'] = true;
            $response_arr['user'] = $user;

        }

        return back()->with('data', $response_arr);
    }

    public function updateCoverPhoto(Request $request){
        $user = Auth::user();
        $user = User::find($user->id);

        $response_arr = ['success' => false];

        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:3048',
        ];

        $request->validate($rules);

        if($request->hasFile('image')){
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/cover_pics');
            //resize image laravel
            $resizedImage = Image::read($image->getRealPath());
            $resizedImage->resize(800, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $resizedImage->save(public_path('/cover_pics/' .$image_name));
            $former_photo = $user->cover_photo;
            if(!is_null($former_photo)){
                unlink(public_path($former_photo));
            }
            $user->cover_photo = '/cover_pics/' . $image_name;
            $user->save();

            $response_arr['success'] = true;
            $response_arr['user'] = $user;

        }

        return back()->with('data', $response_arr);
    }

    public function showFollowing(Request $request, User $user){

        $response = ['success' => false, 'following' => '', 'last_following' => false];
        $last_id = $request->has('last_id') ? $request->last_id : 0;
        $following = $user->following(false, $last_id)->get();
        if($following->count() > 0){

            $last_id = $following[$following->count() - 1]->id;
            $response['last_following'] = $user->following(false, $last_id)->get()->count() > 0 ? false : true;
        }
        $response['following'] = $following;
        $response['success'] = true;




        return $response;

    }

    public function showFollowers(Request $request, User $user){

        $response = ['success' => false, 'followers' => '', 'last_follower' => false];
        $last_id = $request->has('last_id') ? $request->last_id : 0;
        $followers = $user->followers(false, $last_id)->get();
        if($followers->count() > 0){

            $last_id = $followers[$followers->count() - 1]->id;
            $response['last_follower'] = $user->followers(false, $last_id)->get()->count() > 0 ? false : true;
        }
        $response['followers'] = $followers;
        $response['success'] = true;




        return $response;

    }

    public function loadMorePosts(Request $request){
        $post_data = (Object) $request->input();
        // return $post_data;
        $user = Auth::user();
        $user = User::find($user->id);


        if($request->has('last_id')){
            $response = ['posts' => [], 'last_post' => false];
            $last_id = $request->last_id;
            $posts = $this->functions->getPostsForUserProfilePage($user->id, $last_id);

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
