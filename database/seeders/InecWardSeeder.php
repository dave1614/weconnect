<?php

namespace Database\Seeders;

use App\Functions\UsefulFunctions;
use App\Models\InecLga;
use App\Models\InecWard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InecWardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $functions = new UsefulFunctions();
        // $lgas = InecLga::all();
        // if($lgas->count() > 0){
        //     foreach($lgas as $lga){
        //         $url = "https://inecnigeria.org/wp-content/themes/independent-national-electoral-commission/custom/views/wardView.php";
        //         $use_post = true;
        //         $post_data = [
        //             // 'lga_id' => $lga->id < 10 ? "0{$lga->id}" : $lga->id,
        //             'lga_id' => $lga->abbreviation,
        //             'state_id' => $lga->inec_state_id
        //         ];
        //         $wards = $functions->inecCurl($url, $use_post, $post_data);
        //         if($functions->isJson($wards)){
        //             $wards = json_decode($wards);

        //             foreach($wards as $ward){

        //                 InecWard::create([
        //                     'id' => $ward->id,
        //                     'name' => $ward->name,
        //                     'abbreviation' => $ward->abbreviation,
        //                     'inec_state_id' => $lga->inec_state_id,
        //                     'inec_lga_id' => $lga->id

        //                 ]);
        //             }
        //         }
        //     }
        // }

        \DB::unprepared(
            file_get_contents(public_path('inec_wards.sql'))
        );
    }
}
