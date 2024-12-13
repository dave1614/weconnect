<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function loadDetails(Request $request, User $user){
        return ['success' => true, 'user' => $user];
    }

    public function toggleFollow(Request $request, User $user){
        // return $user;
        $auth_user = Auth::user();
        $auth_user = User::find($auth_user->id);
        if($auth_user->id != $user->id){

            $response = ['success' => false, 'action' => ''];

            if($user->following_status){
                $auth_user->unfollow($user);
                $response['action'] = 'unfollowed';
            }else{
                $auth_user->follow($user);
                $response['action'] = 'followed';
            }

            $response['success'] = true;
            return $response;

        }

    }
}
