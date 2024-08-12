<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
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

    public function socialMediaHomePage(Request $request){

        return Inertia::render('Tests/SocialHome');
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
