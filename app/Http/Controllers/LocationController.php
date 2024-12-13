<?php

namespace App\Http\Controllers;

use App\Models\InecLga;
use App\Models\InecState;
use Illuminate\Http\Request;

class LocationController extends Controller
{


    public function getNewWards(Request $request, InecLga $lga){
        $response = ['success' => true, 'wards' => []];

        $wards = $lga->wards()->orderBy('name', 'ASC')->get();

        $response['wards'] = $wards;

        return $response;
    }

    public function getNewLgasAndWards(Request $request, InecState $state){
        $response = ['success' => true, 'lgas' => [], 'wards' => []];

        $lgas = $state->lgas;
        $response['lgas'] = $state->lgas()->orderBy('name', 'ASC')->get();
        $response['wards'] = $lgas->first()->wards()->orderBy('name', 'ASC')->get();

        return $response;
    }
}
