<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\CommunityHeadRequest;
use App\Models\InecState;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

// use \Response;

class TestController extends Controller
{

    public UsefulFunctions $functions;

    public function __construct()
    {
        $this->functions = new UsefulFunctions();
    }

    public function index(Request $request){

        return strtotime(date('H:i:sa'));
        return response()->json(['success' => true,'message' => 'Request Successful'], ($request->headers->has('X-Header') && Cookie::has('color')) ? 200 : 500);

    }

    public function applyAsCommunityLeader(Request $request, User $user){

        $response = ['success' => false];

        if(is_null($user->community_leader) && !$this->functions->checkIfUserHasPendingRequestForCommLeader($user->id)){

            CommunityHeadRequest::create([
                'user_id' => $user->id,
                'ward_id' => $user->ward_id,
                'community_leader_role_id' => rand(1, 3)
            ]);

            $user->community_leader_pending = 1;
            $user->save();

            $response['success'] = true;
        }

        return $response;
    }

    public function apiTest(Request $request){
        $text = "This is a #test string with #multiple #hashtags";

        // return $this->functions->searchTextForHashTags($text);

        // $files = File::files(public_path("/videos"));
        // $allMedia = [];


        // foreach ($files as $path) {
        //     $files = pathinfo($path);
        //     $allMedia[] = $files['basename'];
        // }
        // return ($allMedia);

        // $this->functions->giveUsersRandomProfilePics();
        // $this->functions->followAllUsers(11);
        // return User::find(113);

        // $this->functions->givePostDummyComments(147, 500);

        // $this->functions->giveCommentDummyRelpies(1465, 100);

        // $this->functions->giveReplyDummyLikes(2126, 15);

        // preg_match_all('/#(\w+)/', $text, $matches);
        // return $matches;

        // $this->functions->createDummyPostsForAllUsers();
        // $source = '/test_videos/09AYuBJzmrepFw1k.mp4';
        // $new_file_name = $this->functions->generateNewUniqueNameForImage('videos') . ".mp4";
        // $destination = "/videos/{$new_file_name}";

        // copy(public_path($source), public_path($destination));
        // return $destination;

        // return $this->functions->getAllTestImagesAndVideosFromVideo();

        // $this->functions->allUsersFollowOneUser(11);
        // $url = "https://inecnigeria.org/wp-content/themes/independent-national-electoral-commission/custom/views/wardView.php";
        // $use_post = true;
        // $post_data = [
        //     'lga_id' => 01,
        //     'state_id' => 01
        // ];
        // $lgas = $this->functions->inecCurl($url, $use_post, $post_data);
        // if($this->functions->isJson($lgas)){
        //     $lgas = json_decode($lgas);

        //     foreach($lgas as $lga){
        //         return $lga;
        //     }
        // }

        // $state = InecState::find(24);
        // $lga = $state->lgas()->find(508);

        // $wards = $lga->wards;
        // return $wards;

        // $user = User::find(11);
        // $state = $user->state;
        // $lga = $user->lga;
        // $ward = $user->ward;

        // return $user;

        // $date = "2024-11-18T09:45:16.000000Z";
        // return date('Y-m-d', strtotime($date));

        $filename = public_path('/community_gallery/pexels-streetwindy-3101214.jpg');
        $data = getimagesize($filename);
        $width = $data[0];
        $height = $data[1];

        return $width . " x " . $height;

    }

    public function socialMediaHomePage(Request $request){
        $props = [];

        $user = Auth::user();
        $user = User::find($user->id);
        $props['user'] = $user;

        $posts = $this->functions->getPostsForUserFrontPage($user->id);
        $props['posts'] = $posts;

        foreach ($posts as $post) {
            // $post->user;
            // $post->comments;
            // $post->likes;

            foreach ($post->comments as $comment) {
                $comment->user;
                $comment->likes;
                $comment->replies;
            }
        }

        // return $props;

        return Inertia::render('Tests/SocialHome', $props);
    }

    public function testLogin(Request $request): JsonResponse{
        $user = auth()->user();


        return response()->json(['success' => true,'details' => ['user' => $user]],201);

    }

    public function generateDataPlansJsonDefault(Request $request){
        $gsubz_mtn_plans = $this->functions->getAllGsubzPlansForDefault('mtn');
        $gsubz_glo_plans = $this->functions->getAllGsubzPlansForDefault('glo');
        $gsubz_airtel_plans = $this->functions->getAllGsubzPlansForDefault('airtel');
        $gsubz_9mobile_plans = $this->functions->getAllGsubzPlansForDefault('9mobile');

        $club_mtn_plans = $this->functions->getAllClubPlansForDefault('MTN');

        $mtn_plans = $this->functions->getAllDataPlansDefaultByNetwork('9mobile');



        return $mtn_plans;
        // return $club_mtn_plans;
    }
}
