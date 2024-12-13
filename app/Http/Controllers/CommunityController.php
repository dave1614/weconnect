<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\CommunityDetail;
use App\Models\CommunityGallery;
use App\Models\CommunityHeadRequest;
use App\Models\CommunityLeaderRole;
use App\Models\InecWard;
use App\Models\User;
use App\Notifications\NewCommunityLeaderRequest;
use App\Notifications\NewCommunityLeaderResignation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Intervention\Image\Laravel\Facades\Image;

class CommunityController extends Controller
{
    public UsefulFunctions $functions;

    public function __construct()
    {
        $this->functions = new UsefulFunctions();
    }



    public function profilePage(Request $request, InecWard $community){
        $auth_user = Auth::user();

        $props['community'] = $community;
        $props['auth_user'] = User::find($auth_user->id);
        $this->functions->initCommunityDetailsDbIfNot($community->id);
        $props['community_details'] = CommunityDetail::where('ward_id', $community->id)->first();
        $props['position'] = $this->functions->getPositionOfUserIn($community->id, $auth_user->id);

        $posts = $this->functions->getPostsForUserCommunityPage($community->id);
        $props['posts'] = $posts;
        $props['roles'] = CommunityLeaderRole::all();

        $gallery = $community->gallery()->get();
        $props['gallery'] = $gallery;
        $last_id = $gallery[$gallery->count() - 1]->id;
        $props['last_gallery_id'] = $last_id;

        $props['last_gallery_image'] = $community->gallery(false, $last_id)->get()->count() > 0 ? false : true;

        // return $props['rem_gallery'];

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

        // return $props['gallery'];

        return Inertia::render('Community/Profile', $props);
    }

    public function loadMorePosts(Request $request, InecWard $community){
        $post_data = (Object) $request->input();
        // return $post_data;
        $user = Auth::user();
        $user = User::find($user->id);


        if($request->has('last_id')){
            $response = ['posts' => [], 'last_post' => false];
            $last_id = $request->last_id;
            $posts = $this->functions->getPostsForUserCommunityPage($community->id, $last_id);

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

    public function uploadNewGalleryImage(Request $request){
        $user = Auth::user();
        $user = User::find($user->id);
        if(!is_null($user->community_leader)){
            $community = InecWard::find($user->ward_id);

            $response_arr = ['success' => false];


            $rules = [
                'image' => 'required|image|mimes:jpeg,png,jpg|max:3048',
            ];

            $request->validate($rules);

            if($request->hasFile('image')){
                $image = $request->file('image');
                $image_name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/community_gallery');
                //resize image laravel
                $resizedImage = Image::read($image->getRealPath());
                // $resizedImage->resize(800, 400, function ($constraint) {
                //     $constraint->aspectRatio();
                //     $constraint->upsize();
                // });

                $resizedImage->save(public_path('/community_gallery/' .$image_name));

                $filename = public_path('/community_gallery/' .$image_name);
                $data = getimagesize($filename);
                $width = $data[0];
                $height = $data[1];
                CommunityGallery::create([
                    'ward_id' => $community->id,
                    'path' => '/community_gallery/' .$image_name,
                    'leader_id' => $user->id,
                    'width' => $width,
                    'height' => $height
                ]);

                $response_arr['success'] = true;

            }

            return back()->with('data', $response_arr);
        }
    }

    public function deleteGalleryImage(Request $request, InecWard $community, CommunityGallery $image){

        // return $image;
        $response = ['success' => false];

        $user = Auth::user();

        if($this->functions->checkIfUserIsALeaderInCommunity($community->id, $user->id)){

            unlink(public_path($image->path));

            $image->delete();



            $response['success'] = true;
        }

        return $response;
    }

    public function loadGallery(Request $request, InecWard $community){
        $response = ['success' => false, 'gallery' => [], 'last_image' => false];

        $last_id = $request->last_id;
        $gallery = $community->gallery(false, $last_id)->get();
        if($gallery->count() > 0){
            $last_id = $gallery[$gallery->count() - 1]->id;
            $response['last_image'] = $community->gallery(false, $last_id)->get()->count() > 0 ? false : true;
        }

        $response['gallery'] = $gallery;
        $response['success'] = true;

        return $response;
    }

    public function modifyHistory(Request $request, CommunityDetail $communityDetail){
        $response = ['success' => false];

        // return $request->input();

        $user = Auth::user();
        $user = User::find($user->id);
        if(!is_null($user->community_leader)){

            if($user->ward_id == $communityDetail->ward_id){

                if($request->has('history')){
                    // return "string";
                    $communityDetail->history = $request->history;

                    $communityDetail->save();

                    $response['success'] = true;
                }
            }
        }


        return $response;
    }



    public function showLeaders(Request $request, InecWard $community){

        $response = ['success' => false, 'leaders' => []];

        $response['leaders']['kings'] = $this->functions->getCommunityLeadersByPosition(1, $community->id);
        $response['leaders']['chiefs'] = $this->functions->getCommunityLeadersByPosition(2, $community->id);
        $response['leaders']['cabinet_members'] = $this->functions->getCommunityLeadersByPosition(3, $community->id);

        $response['success'] = true;
        return $response;

    }

    public function showResidents(Request $request, InecWard $community){

        $response = ['success' => false, 'residents' => '', 'last_resident' => false];
        $last_id = $request->has('last_id') ? $request->last_id : 0;
        $residents = $community->residents(false, $last_id)->get();
        if($residents->count() > 0){

            $last_id = $residents[$residents->count() - 1]->id;
            $response['last_resident'] = $community->residents(false, $last_id)->get()->count() > 0 ? false : true;
        }
        $response['residents'] = $residents;
        $response['success'] = true;




        return $response;

    }



    public function updateLogo(Request $request){
        $user = Auth::user();
        $user = User::find($user->id);
        if(!is_null($user->community_leader)){
            $community = InecWard::find($user->ward_id);

            $response_arr = ['success' => false];
            $this->functions->initCommunityDetailsDbIfNot($community->id);
            $community_details = CommunityDetail::where('ward_id', $community->id)->first();

            $rules = [
                'image' => 'required|image|mimes:jpeg,png,jpg|max:3048',
            ];

            $request->validate($rules);

            if($request->hasFile('image')){
                $image = $request->file('image');
                $image_name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/logos');
                //resize image laravel
                $resizedImage = Image::read($image->getRealPath());
                $resizedImage->resize(400, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $resizedImage->save(public_path('/logos/' .$image_name));
                $former_photo = $community_details->logo;
                if(!is_null($former_photo)){
                    unlink(public_path($former_photo));
                }
                $community_details->logo = '/logos/' . $image_name;
                $community_details->save();

                $response_arr['success'] = true;
                $response_arr['community_details'] = $community_details;

            }

            return back()->with('data', $response_arr);
        }
    }





    public function updateCoverPhoto(Request $request){
        $user = Auth::user();
        $user = User::find($user->id);
        if(!is_null($user->community_leader)){
            $community = InecWard::find($user->ward_id);

            $response_arr = ['success' => false];
            $this->functions->initCommunityDetailsDbIfNot($community->id);
            $community_details = CommunityDetail::where('ward_id', $community->id)->first();

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
                $former_photo = $community_details->cover_photo;
                if(!is_null($former_photo)){
                    unlink(public_path($former_photo));
                }
                $community_details->cover_photo = '/cover_pics/' . $image_name;
                $community_details->save();

                $response_arr['success'] = true;
                $response_arr['community_details'] = $community_details;

            }

            return back()->with('data', $response_arr);
        }
    }


    public function resignLeaderRequest(Request $request){
        $user = Auth::user();
        $user = User::find($user->id);

        $response = ['success' => false];


        $user->community_leader = NULL;
        $user->community_leader_date = NULL;

        $user->save();

        $response['success'] = true;


        return $response;
    }



    public function removeLeaderRequest(Request $request){
        $user = Auth::user();
        $user = User::find($user->id);

        $response = ['success' => false];


        CommunityHeadRequest::where('user_id', $user->id)->delete();

        $user->community_leader_pending = 0;
        $user->save();

        $admin_user = User::find(10);

        $admin_user->notify(new NewCommunityLeaderResignation($user, $request->role_id));

        $response['success'] = true;


        return $response;
    }


    public function applyAsLeader(Request $request){
        $user = Auth::user();
        $user = User::find($user->id);

        $response = ['success' => false, 'invalid_role' => true, 'invalid_for_application' => true];

        if($request->has('role_id')){
            if(in_array($request->role_id, $this->functions->getCommunityLeaderRolesIdsInArr())){
                $response['invalid_role'] = false;
                if(is_null($user->community_leader) && !$this->functions->checkIfUserHasPendingRequestForCommLeader($user->id)){
                    $response['invalid_for_application'] = false;

                    CommunityHeadRequest::create([
                        'user_id' => $user->id,
                        'ward_id' => $user->ward_id,
                        'community_leader_role_id' => $request->role_id
                    ]);

                    $user->community_leader_pending = 1;
                    $user->save();

                    $admin_user = User::find(10);

                    $admin_user->notify(new NewCommunityLeaderRequest($user, $request->role_id));

                    $response['success'] = true;
                }
            }
        }

        return $response;
    }


}
