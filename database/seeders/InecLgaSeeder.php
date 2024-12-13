<?php

namespace Database\Seeders;

use App\Functions\UsefulFunctions;
use App\Models\InecLga;
use App\Models\InecState;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InecLgaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $functions = new UsefulFunctions();
        // $states = InecState::all();
        // if($states->count() > 0){
        //     foreach($states as $state){
        //         $url = "https://inecnigeria.org/wp-content/themes/independent-national-electoral-commission/custom/views/lgaView.php";
        //         $use_post = true;
        //         $post_data = [
        //             'state_id' => $state->id
        //         ];
        //         $lgas = $functions->inecCurl($url, $use_post, $post_data);
        //         if($functions->isJson($lgas)){
        //             $lgas = json_decode($lgas);

        //             foreach($lgas as $lga){

        //                 InecLga::create([
        //                     'id' => $lga->id,
        //                     'name' => $lga->name,
        //                     'abbreviation' => $lga->abbreviation,
        //                     'inec_state_id' => $state->id,

        //                 ]);
        //             }
        //         }
        //     }
        // }

        InecLga::create([
            'id' => 1,
            'name' => 'ABA NORTH',
            'abbreviation' => '01',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 2,
            'name' => 'ABA SOUTH',
            'abbreviation' => '02',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 3,
            'name' => 'AROCHUKWU',
            'abbreviation' => '03',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 4,
            'name' => 'BENDE',
            'abbreviation' => '04',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 5,
            'name' => 'IKWUANO',
            'abbreviation' => '05',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 6,
            'name' => 'ISIALA NGWA NORTH',
            'abbreviation' => '06',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 7,
            'name' => 'ISIALA NGWA SOUTH',
            'abbreviation' => '07',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 8,
            'name' => 'ISUIKWUATO',
            'abbreviation' => '08',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 9,
            'name' => 'OBINGWA',
            'abbreviation' => '09',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 10,
            'name' => 'OHAFIA',
            'abbreviation' => '10',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 11,
            'name' => 'OSISIOMA',
            'abbreviation' => '11',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 12,
            'name' => 'UGWUNAGBO',
            'abbreviation' => '12',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 13,
            'name' => 'UKWA EAST',
            'abbreviation' => '13',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 14,
            'name' => 'UKWA  WEST',
            'abbreviation' => '14',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 15,
            'name' => 'UMUAHIA NORTH',
            'abbreviation' => '15',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 16,
            'name' => 'UMUAHIA  SOUTH',
            'abbreviation' => '16',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 17,
            'name' => 'UMU - NNEOCHI',
            'abbreviation' => '17',
            'inec_state_id' => 1,
        ]);



        InecLga::create([
            'id' => 18,
            'name' => 'DEMSA',
            'abbreviation' => '01',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 19,
            'name' => 'FUFORE',
            'abbreviation' => '02',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 20,
            'name' => 'GANYE',
            'abbreviation' => '03',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 21,
            'name' => 'GIRE 1',
            'abbreviation' => '04',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 22,
            'name' => 'GOMBI',
            'abbreviation' => '05',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 23,
            'name' => 'GUYUK',
            'abbreviation' => '06',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 24,
            'name' => 'HONG',
            'abbreviation' => '07',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 25,
            'name' => 'JADA',
            'abbreviation' => '08',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 26,
            'name' => 'LAMURDE',
            'abbreviation' => '09',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 27,
            'name' => 'MADAGALI',
            'abbreviation' => '10',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 28,
            'name' => 'MAIHA',
            'abbreviation' => '11',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 29,
            'name' => 'MAYO - BELWA',
            'abbreviation' => '12',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 30,
            'name' => 'MICHIKA',
            'abbreviation' => '13',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 31,
            'name' => 'MUBI NORTH',
            'abbreviation' => '14',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 32,
            'name' => 'MUBI SOUTH',
            'abbreviation' => '15',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 33,
            'name' => 'NUMAN',
            'abbreviation' => '16',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 34,
            'name' => 'SHELLENG',
            'abbreviation' => '17',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 35,
            'name' => 'SONG',
            'abbreviation' => '18',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 36,
            'name' => 'TOUNGO',
            'abbreviation' => '19',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 37,
            'name' => 'YOLA NORTH',
            'abbreviation' => '20',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 38,
            'name' => 'YOLA SOUTH',
            'abbreviation' => '21',
            'inec_state_id' => 2,
        ]);



        InecLga::create([
            'id' => 39,
            'name' => 'ABAK',
            'abbreviation' => '01',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 40,
            'name' => 'EASTERN OBOLO',
            'abbreviation' => '02',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 41,
            'name' => 'EKET',
            'abbreviation' => '03',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 42,
            'name' => 'ESIT EKET (UQUO)',
            'abbreviation' => '04',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 43,
            'name' => 'ESSIEN UDIM',
            'abbreviation' => '05',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 44,
            'name' => 'ETIM EKPO',
            'abbreviation' => '06',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 45,
            'name' => 'ETINAN',
            'abbreviation' => '07',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 46,
            'name' => 'IBENO',
            'abbreviation' => '08',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 47,
            'name' => 'IBESIKPO ASUTAN',
            'abbreviation' => '09',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 48,
            'name' => 'IBIONO IBOM',
            'abbreviation' => '10',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 49,
            'name' => 'IKA',
            'abbreviation' => '11',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 50,
            'name' => 'IKONO',
            'abbreviation' => '12',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 51,
            'name' => 'IKOT ABASI',
            'abbreviation' => '13',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 52,
            'name' => 'IKOT EKPENE',
            'abbreviation' => '14',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 53,
            'name' => 'INI',
            'abbreviation' => '15',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 54,
            'name' => 'ITU',
            'abbreviation' => '16',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 55,
            'name' => 'MBO',
            'abbreviation' => '17',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 56,
            'name' => 'MKPAT ENIN',
            'abbreviation' => '18',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 57,
            'name' => 'NSIT ATAI',
            'abbreviation' => '19',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 58,
            'name' => 'NSIT IBOM',
            'abbreviation' => '20',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 59,
            'name' => 'NSIT UBIUM',
            'abbreviation' => '21',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 60,
            'name' => 'OBOT AKARA',
            'abbreviation' => '22',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 61,
            'name' => 'OKOBO',
            'abbreviation' => '23',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 62,
            'name' => 'ONNA',
            'abbreviation' => '24',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 63,
            'name' => 'ORON',
            'abbreviation' => '25',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 64,
            'name' => 'ORUK ANAM',
            'abbreviation' => '26',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 65,
            'name' => 'UDUNG UKO',
            'abbreviation' => '27',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 66,
            'name' => 'UKANAFUN',
            'abbreviation' => '28',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 67,
            'name' => 'URUAN',
            'abbreviation' => '29',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 68,
            'name' => 'URUE OFFONG/ORUKO',
            'abbreviation' => '30',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 69,
            'name' => 'UYO',
            'abbreviation' => '31',
            'inec_state_id' => 3,
        ]);



        InecLga::create([
            'id' => 70,
            'name' => 'AGUATA',
            'abbreviation' => '01',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 71,
            'name' => 'AYAMELUM',
            'abbreviation' => '02',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 72,
            'name' => 'ANAMBRA EAST',
            'abbreviation' => '03',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 73,
            'name' => 'ANAMBRA WEST',
            'abbreviation' => '04',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 74,
            'name' => 'ANAOCHA',
            'abbreviation' => '05',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 75,
            'name' => 'AWKA NORTH',
            'abbreviation' => '06',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 76,
            'name' => 'AWKA SOUTH',
            'abbreviation' => '07',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 77,
            'name' => 'DUNUKOFIA',
            'abbreviation' => '08',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 78,
            'name' => 'EKWUSIGO',
            'abbreviation' => '09',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 79,
            'name' => 'IDEMILI NORTH',
            'abbreviation' => '10',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 80,
            'name' => 'IDEMILI-SOUTH',
            'abbreviation' => '11',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 81,
            'name' => 'IHALA',
            'abbreviation' => '12',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 82,
            'name' => 'NJIKOKA',
            'abbreviation' => '13',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 83,
            'name' => 'NNEWI NORTH',
            'abbreviation' => '14',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 84,
            'name' => 'NNEWI SOUTH',
            'abbreviation' => '15',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 85,
            'name' => 'OGBARU',
            'abbreviation' => '16',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 86,
            'name' => 'ONITSHA-NORTH',
            'abbreviation' => '17',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 87,
            'name' => 'ONITSHA -SOUTH',
            'abbreviation' => '18',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 88,
            'name' => 'ORUMBA NORTH',
            'abbreviation' => '19',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 89,
            'name' => 'ORUMBA  SOUTH',
            'abbreviation' => '20',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 90,
            'name' => 'OYI',
            'abbreviation' => '21',
            'inec_state_id' => 4,
        ]);



        InecLga::create([
            'id' => 91,
            'name' => 'ALKALERI',
            'abbreviation' => '01',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 92,
            'name' => 'BAUCHI',
            'abbreviation' => '02',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 93,
            'name' => 'BOGORO',
            'abbreviation' => '03',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 94,
            'name' => 'DAMBAM',
            'abbreviation' => '04',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 95,
            'name' => 'DARAZO',
            'abbreviation' => '05',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 96,
            'name' => 'DASS',
            'abbreviation' => '06',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 97,
            'name' => 'GAMAWA',
            'abbreviation' => '07',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 98,
            'name' => 'GANJUWA',
            'abbreviation' => '08',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 99,
            'name' => 'GIADE',
            'abbreviation' => '09',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 100,
            'name' => 'ITAS/GADAU',
            'abbreviation' => '10',
            'inec_state_id' => 5,
        ]);


        InecLga::create([
            'id' => 101,
            'name' => 'JAMA\'ARE',
            'abbreviation' => '11',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 102,
            'name' => 'KATAGUM',
            'abbreviation' => '12',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 103,
            'name' => 'KIRFI',
            'abbreviation' => '13',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 104,
            'name' => 'MISAU',
            'abbreviation' => '14',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 105,
            'name' => 'NINGI',
            'abbreviation' => '15',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 106,
            'name' => 'SHIRA',
            'abbreviation' => '16',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 107,
            'name' => 'TAFAWA BALEWA',
            'abbreviation' => '17',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 108,
            'name' => 'TORO',
            'abbreviation' => '18',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 109,
            'name' => 'WARJI',
            'abbreviation' => '19',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 110,
            'name' => 'ZAKI',
            'abbreviation' => '20',
            'inec_state_id' => 5,
        ]);



        InecLga::create([
            'id' => 111,
            'name' => 'BRASS',
            'abbreviation' => '01',
            'inec_state_id' => 6,
        ]);



        InecLga::create([
            'id' => 112,
            'name' => 'EKEREMOR',
            'abbreviation' => '02',
            'inec_state_id' => 6,
        ]);



        InecLga::create([
            'id' => 113,
            'name' => 'KOLOKUMA/OPOKUMA',
            'abbreviation' => '03',
            'inec_state_id' => 6,
        ]);



        InecLga::create([
            'id' => 114,
            'name' => 'NEMBE',
            'abbreviation' => '04',
            'inec_state_id' => 6,
        ]);



        InecLga::create([
            'id' => 115,
            'name' => 'OGBIA',
            'abbreviation' => '05',
            'inec_state_id' => 6,
        ]);



        InecLga::create([
            'id' => 116,
            'name' => 'SAGBAMA',
            'abbreviation' => '06',
            'inec_state_id' => 6,
        ]);



        InecLga::create([
            'id' => 117,
            'name' => 'SOUTHERN IJAW',
            'abbreviation' => '07',
            'inec_state_id' => 6,
        ]);



        InecLga::create([
            'id' => 118,
            'name' => 'YENAGOA',
            'abbreviation' => '08',
            'inec_state_id' => 6,
        ]);



        InecLga::create([
            'id' => 119,
            'name' => 'ADO',
            'abbreviation' => '01',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 120,
            'name' => 'AGATU',
            'abbreviation' => '02',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 121,
            'name' => 'APA',
            'abbreviation' => '03',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 122,
            'name' => 'BURUKU',
            'abbreviation' => '04',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 123,
            'name' => 'GBOKO',
            'abbreviation' => '05',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 124,
            'name' => 'GUMA',
            'abbreviation' => '06',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 125,
            'name' => 'GWER EAST',
            'abbreviation' => '07',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 126,
            'name' => 'GWER WEST',
            'abbreviation' => '08',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 127,
            'name' => 'KATSINA-ALA',
            'abbreviation' => '09',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 128,
            'name' => 'KONSHISHA',
            'abbreviation' => '10',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 129,
            'name' => 'KWANDE',
            'abbreviation' => '11',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 130,
            'name' => 'LOGO',
            'abbreviation' => '12',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 131,
            'name' => 'MAKURDI',
            'abbreviation' => '13',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 132,
            'name' => 'OBI',
            'abbreviation' => '14',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 133,
            'name' => 'OGBADIBO',
            'abbreviation' => '15',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 134,
            'name' => 'OJU',
            'abbreviation' => '16',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 135,
            'name' => 'OHIMINI',
            'abbreviation' => '17',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 136,
            'name' => 'OKPOKWU',
            'abbreviation' => '18',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 137,
            'name' => 'OTUKPO',
            'abbreviation' => '19',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 138,
            'name' => 'TARKA',
            'abbreviation' => '20',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 139,
            'name' => 'UKUM',
            'abbreviation' => '21',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 140,
            'name' => 'USHONGO',
            'abbreviation' => '22',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 141,
            'name' => 'VANDEIKYA',
            'abbreviation' => '23',
            'inec_state_id' => 7,
        ]);



        InecLga::create([
            'id' => 142,
            'name' => 'ABADAM',
            'abbreviation' => '01',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 143,
            'name' => 'ASKIRA / UBA',
            'abbreviation' => '02',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 144,
            'name' => 'BAMA',
            'abbreviation' => '03',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 145,
            'name' => 'BAYO',
            'abbreviation' => '04',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 146,
            'name' => 'BIU',
            'abbreviation' => '05',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 147,
            'name' => 'CHIBOK',
            'abbreviation' => '06',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 148,
            'name' => 'DAMBOA',
            'abbreviation' => '07',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 149,
            'name' => 'DIKWA',
            'abbreviation' => '08',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 150,
            'name' => 'GUBIO',
            'abbreviation' => '09',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 151,
            'name' => 'GUZAMALA',
            'abbreviation' => '10',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 152,
            'name' => 'GWOZA',
            'abbreviation' => '11',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 153,
            'name' => 'HAWUL',
            'abbreviation' => '12',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 154,
            'name' => 'JERE',
            'abbreviation' => '13',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 155,
            'name' => 'KAGA',
            'abbreviation' => '14',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 156,
            'name' => 'KALA BALGE',
            'abbreviation' => '15',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 157,
            'name' => 'KONDUGA',
            'abbreviation' => '16',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 158,
            'name' => 'KUKAWA',
            'abbreviation' => '17',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 159,
            'name' => 'KWAYA / KUSAR',
            'abbreviation' => '18',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 160,
            'name' => 'MAFA',
            'abbreviation' => '19',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 161,
            'name' => 'MAGUMERI',
            'abbreviation' => '20',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 162,
            'name' => 'MAIDUGURI M. C.',
            'abbreviation' => '21',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 163,
            'name' => 'MARTE',
            'abbreviation' => '22',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 164,
            'name' => 'MOBBAR',
            'abbreviation' => '23',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 165,
            'name' => 'MONGUNO',
            'abbreviation' => '24',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 166,
            'name' => 'NGALA',
            'abbreviation' => '25',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 167,
            'name' => 'NGANZAI',
            'abbreviation' => '26',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 168,
            'name' => 'SHANI',
            'abbreviation' => '27',
            'inec_state_id' => 8,
        ]);



        InecLga::create([
            'id' => 169,
            'name' => 'ABI',
            'abbreviation' => '01',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 170,
            'name' => 'AKAMKPA',
            'abbreviation' => '02',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 171,
            'name' => 'AKPABUYO',
            'abbreviation' => '03',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 172,
            'name' => 'BAKASSI',
            'abbreviation' => '04',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 173,
            'name' => 'BEKWARRA',
            'abbreviation' => '05',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 174,
            'name' => 'BIASE',
            'abbreviation' => '06',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 175,
            'name' => 'BOKI',
            'abbreviation' => '07',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 176,
            'name' => 'CALABAR MUNICIPALITY',
            'abbreviation' => '08',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 177,
            'name' => 'CALABAR SOUTH',
            'abbreviation' => '09',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 178,
            'name' => 'ETUNG',
            'abbreviation' => '10',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 179,
            'name' => 'IKOM',
            'abbreviation' => '11',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 180,
            'name' => 'OBANLIKU',
            'abbreviation' => '12',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 181,
            'name' => 'OBUBRA',
            'abbreviation' => '13',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 182,
            'name' => 'OBUDU',
            'abbreviation' => '14',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 183,
            'name' => 'ODUKPANI',
            'abbreviation' => '15',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 184,
            'name' => 'OGOJA',
            'abbreviation' => '16',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 185,
            'name' => 'YAKURR',
            'abbreviation' => '17',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 186,
            'name' => 'YALA',
            'abbreviation' => '18',
            'inec_state_id' => 9,
        ]);



        InecLga::create([
            'id' => 187,
            'name' => 'ANIOCHA NORTH',
            'abbreviation' => '01',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 188,
            'name' => 'ANIOCHA - SOUTH',
            'abbreviation' => '02',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 189,
            'name' => 'BOMADI',
            'abbreviation' => '03',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 190,
            'name' => 'BURUTU',
            'abbreviation' => '04',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 191,
            'name' => 'ETHIOPE  EAST',
            'abbreviation' => '05',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 192,
            'name' => 'ETHIOPE  WEST',
            'abbreviation' => '06',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 193,
            'name' => 'IKA NORTH- EAST',
            'abbreviation' => '07',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 194,
            'name' => 'IKA - SOUTH',
            'abbreviation' => '08',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 195,
            'name' => 'ISOKO NORTH',
            'abbreviation' => '09',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 196,
            'name' => 'ISOKO SOUTH',
            'abbreviation' => '10',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 197,
            'name' => 'NDOKWA EAST',
            'abbreviation' => '11',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 198,
            'name' => 'NDOKWA WEST',
            'abbreviation' => '12',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 199,
            'name' => 'OKPE',
            'abbreviation' => '13',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 200,
            'name' => 'OSHIMILI - NORTH',
            'abbreviation' => '14',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 201,
            'name' => 'OSHIMILI - SOUTH',
            'abbreviation' => '15',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 202,
            'name' => 'PATANI',
            'abbreviation' => '16',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 203,
            'name' => 'SAPELE',
            'abbreviation' => '17',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 204,
            'name' => 'UDU',
            'abbreviation' => '18',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 205,
            'name' => 'UGHELLI NORTH',
            'abbreviation' => '19',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 206,
            'name' => 'UGHELLI SOUTH',
            'abbreviation' => '20',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 207,
            'name' => 'UKWUANI',
            'abbreviation' => '21',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 208,
            'name' => 'UVWIE',
            'abbreviation' => '22',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 209,
            'name' => 'WARRI  NORTH',
            'abbreviation' => '23',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 210,
            'name' => 'WARRI SOUTH',
            'abbreviation' => '24',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 211,
            'name' => 'WARRI SOUTH  WEST',
            'abbreviation' => '25',
            'inec_state_id' => 10,
        ]);



        InecLga::create([
            'id' => 212,
            'name' => 'ABAKALIKI',
            'abbreviation' => '01',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 213,
            'name' => 'AFIKPO NORTH',
            'abbreviation' => '02',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 214,
            'name' => 'AFIKPO  SOUTH',
            'abbreviation' => '03',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 215,
            'name' => 'EBONYI',
            'abbreviation' => '04',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 216,
            'name' => 'EZZA NORTH',
            'abbreviation' => '05',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 217,
            'name' => 'EZZA SOUTH',
            'abbreviation' => '06',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 218,
            'name' => 'IKWO',
            'abbreviation' => '07',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 219,
            'name' => 'ISHIELU',
            'abbreviation' => '08',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 220,
            'name' => 'IVO',
            'abbreviation' => '09',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 221,
            'name' => 'IZZI',
            'abbreviation' => '10',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 222,
            'name' => 'OHAOZARA',
            'abbreviation' => '11',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 223,
            'name' => 'OHAUKWU',
            'abbreviation' => '12',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 224,
            'name' => 'ONICHA',
            'abbreviation' => '13',
            'inec_state_id' => 11,
        ]);



        InecLga::create([
            'id' => 225,
            'name' => 'AKOKO EDO',
            'abbreviation' => '01',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 226,
            'name' => 'EGOR',
            'abbreviation' => '02',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 227,
            'name' => 'ESAN CENTRAL',
            'abbreviation' => '03',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 228,
            'name' => 'ESAN NORTH EAST',
            'abbreviation' => '04',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 229,
            'name' => 'ESAN SOUTH EAST',
            'abbreviation' => '05',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 230,
            'name' => 'ESAN WEST',
            'abbreviation' => '06',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 231,
            'name' => 'ETSAKO CENTRAL',
            'abbreviation' => '07',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 232,
            'name' => 'ETSAKO EAST',
            'abbreviation' => '08',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 233,
            'name' => 'ETSAKO  WEST',
            'abbreviation' => '09',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 234,
            'name' => 'IGUEBEN',
            'abbreviation' => '10',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 235,
            'name' => 'IKPOBA/OKHA',
            'abbreviation' => '11',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 236,
            'name' => 'OREDO',
            'abbreviation' => '12',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 237,
            'name' => 'ORHIONMWON',
            'abbreviation' => '13',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 238,
            'name' => 'OVIA NORTH EAST',
            'abbreviation' => '14',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 239,
            'name' => 'OVIA SOUTH WEST',
            'abbreviation' => '15',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 240,
            'name' => 'OWAN EAST',
            'abbreviation' => '16',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 241,
            'name' => 'OWAN WEST',
            'abbreviation' => '17',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 242,
            'name' => 'UHUNMWODE',
            'abbreviation' => '18',
            'inec_state_id' => 12,
        ]);



        InecLga::create([
            'id' => 243,
            'name' => 'ADO EKITI',
            'abbreviation' => '01',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 244,
            'name' => 'EFON',
            'abbreviation' => '02',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 245,
            'name' => 'EKITI EAST',
            'abbreviation' => '03',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 246,
            'name' => 'EKITI WEST',
            'abbreviation' => '04',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 247,
            'name' => 'EKITI SOUTH WEST',
            'abbreviation' => '05',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 248,
            'name' => 'EMURE',
            'abbreviation' => '06',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 249,
            'name' => 'GBONYIN',
            'abbreviation' => '07',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 250,
            'name' => 'IDO / OSI',
            'abbreviation' => '08',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 251,
            'name' => 'IJERO',
            'abbreviation' => '09',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 252,
            'name' => 'IKERE',
            'abbreviation' => '10',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 253,
            'name' => 'IKOLE',
            'abbreviation' => '11',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 254,
            'name' => 'ILEJEMEJE',
            'abbreviation' => '12',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 255,
            'name' => 'IREPODUN / IFELODUN',
            'abbreviation' => '13',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 256,
            'name' => 'ISE / ORUN',
            'abbreviation' => '14',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 257,
            'name' => 'MOBA',
            'abbreviation' => '15',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 258,
            'name' => 'OYE',
            'abbreviation' => '16',
            'inec_state_id' => 13,
        ]);



        InecLga::create([
            'id' => 259,
            'name' => 'ANINRI',
            'abbreviation' => '01',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 260,
            'name' => 'AWGU',
            'abbreviation' => '02',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 261,
            'name' => 'ENUGU EAST',
            'abbreviation' => '03',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 262,
            'name' => 'ENUGU NORTH',
            'abbreviation' => '04',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 263,
            'name' => 'ENUGU SOUTH',
            'abbreviation' => '05',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 264,
            'name' => 'EZEAGU',
            'abbreviation' => '06',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 265,
            'name' => 'IGBO ETITI',
            'abbreviation' => '07',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 266,
            'name' => 'IGBO EZE NORTH',
            'abbreviation' => '08',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 267,
            'name' => 'IGBO EZE SOUTH',
            'abbreviation' => '09',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 268,
            'name' => 'ISI UZO',
            'abbreviation' => '10',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 269,
            'name' => 'NKANU EAST',
            'abbreviation' => '11',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 270,
            'name' => 'NKANU WEST',
            'abbreviation' => '12',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 271,
            'name' => 'NSUKKA',
            'abbreviation' => '13',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 272,
            'name' => 'OJI-RIVER',
            'abbreviation' => '14',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 273,
            'name' => 'UDENU',
            'abbreviation' => '15',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 274,
            'name' => 'UDI',
            'abbreviation' => '16',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 275,
            'name' => 'UZO-UWANI',
            'abbreviation' => '17',
            'inec_state_id' => 14,
        ]);



        InecLga::create([
            'id' => 276,
            'name' => 'ABAJI',
            'abbreviation' => '01',
            'inec_state_id' => 37,
        ]);



        InecLga::create([
            'id' => 277,
            'name' => 'BWARI',
            'abbreviation' => '02',
            'inec_state_id' => 37,
        ]);



        InecLga::create([
            'id' => 278,
            'name' => 'GWAGWALADA',
            'abbreviation' => '03',
            'inec_state_id' => 37,
        ]);



        InecLga::create([
            'id' => 279,
            'name' => 'KUJE',
            'abbreviation' => '04',
            'inec_state_id' => 37,
        ]);



        InecLga::create([
            'id' => 280,
            'name' => 'KWALI',
            'abbreviation' => '05',
            'inec_state_id' => 37,
        ]);



        InecLga::create([
            'id' => 281,
            'name' => 'MUNICIPAL',
            'abbreviation' => '06',
            'inec_state_id' => 37,
        ]);



        InecLga::create([
            'id' => 282,
            'name' => 'AKKO',
            'abbreviation' => '01',
            'inec_state_id' => 15,
        ]);



        InecLga::create([
            'id' => 283,
            'name' => 'BALANGA',
            'abbreviation' => '02',
            'inec_state_id' => 15,
        ]);



        InecLga::create([
            'id' => 284,
            'name' => 'BILLIRI',
            'abbreviation' => '03',
            'inec_state_id' => 15,
        ]);



        InecLga::create([
            'id' => 285,
            'name' => 'DUKKU',
            'abbreviation' => '04',
            'inec_state_id' => 15,
        ]);



        InecLga::create([
            'id' => 286,
            'name' => 'FUNAKAYE',
            'abbreviation' => '05',
            'inec_state_id' => 15,
        ]);



        InecLga::create([
            'id' => 287,
            'name' => 'GOMBE',
            'abbreviation' => '06',
            'inec_state_id' => 15,
        ]);



        InecLga::create([
            'id' => 288,
            'name' => 'KALTUNGO',
            'abbreviation' => '07',
            'inec_state_id' => 15,
        ]);



        InecLga::create([
            'id' => 289,
            'name' => 'KWAMI',
            'abbreviation' => '08',
            'inec_state_id' => 15,
        ]);



        InecLga::create([
            'id' => 290,
            'name' => 'NAFADA',
            'abbreviation' => '09',
            'inec_state_id' => 15,
        ]);



        InecLga::create([
            'id' => 291,
            'name' => 'SHONGOM',
            'abbreviation' => '10',
            'inec_state_id' => 15,
        ]);



        InecLga::create([
            'id' => 292,
            'name' => 'YALMALTU/ DEBA',
            'abbreviation' => '11',
            'inec_state_id' => 15,
        ]);



        InecLga::create([
            'id' => 293,
            'name' => 'ABOH MBAISE',
            'abbreviation' => '01',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 294,
            'name' => 'AHIAZU MBAISE',
            'abbreviation' => '02',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 295,
            'name' => 'EHIME MBANO',
            'abbreviation' => '03',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 296,
            'name' => 'EZINIHITTE MBAISE',
            'abbreviation' => '04',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 297,
            'name' => 'IDEATO NORTH',
            'abbreviation' => '05',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 298,
            'name' => 'IDEATO SOUTH',
            'abbreviation' => '06',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 299,
            'name' => 'IHITTE/UBOMA (ISINWEKE)',
            'abbreviation' => '07',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 300,
            'name' => 'IKEDURU (IHO)',
            'abbreviation' => '08',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 301,
            'name' => 'ISIALA MBANO (UMUELEMAI)',
            'abbreviation' => '09',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 302,
            'name' => 'ISU (UMUNDUGBA)',
            'abbreviation' => '10',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 303,
            'name' => 'MBAITOLI (NWAORIEUBI)',
            'abbreviation' => '11',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 304,
            'name' => 'NGOR OKPALA (UMUNEKE)',
            'abbreviation' => '12',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 305,
            'name' => 'NJABA (NNENASA)',
            'abbreviation' => '13',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 306,
            'name' => 'NKWERRE',
            'abbreviation' => '14',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 307,
            'name' => 'NWANGELE (ONU-NWANGELE AMAIGBO)',
            'abbreviation' => '15',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 308,
            'name' => 'OBOWO (OTOKO)',
            'abbreviation' => '16',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 309,
            'name' => 'OGUTA (OGUTA)',
            'abbreviation' => '17',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 310,
            'name' => 'OHAJI/EGBEMA (MMAHU-EGBEMA)',
            'abbreviation' => '18',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 311,
            'name' => 'OKIGWE  (OKIGWE)',
            'abbreviation' => '19',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 312,
            'name' => 'ONUIMO (OKWE)',
            'abbreviation' => '20',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 313,
            'name' => 'ORLU',
            'abbreviation' => '21',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 314,
            'name' => 'ORSU (AWO IDEMILI)',
            'abbreviation' => '22',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 315,
            'name' => 'ORU-EAST',
            'abbreviation' => '23',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 316,
            'name' => 'ORU WEST (MGBIDI)',
            'abbreviation' => '24',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 317,
            'name' => 'OWERRI MUNICIPAL',
            'abbreviation' => '25',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 318,
            'name' => 'OWERRI NORTH (ORIE URATTA)',
            'abbreviation' => '26',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 319,
            'name' => 'OWERRI WEST (UMUGUMA)',
            'abbreviation' => '27',
            'inec_state_id' => 16,
        ]);



        InecLga::create([
            'id' => 320,
            'name' => 'AUYO',
            'abbreviation' => '01',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 321,
            'name' => 'BABURA',
            'abbreviation' => '02',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 322,
            'name' => 'BIRNIN KUDU',
            'abbreviation' => '03',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 323,
            'name' => 'BIRNIWA',
            'abbreviation' => '04',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 324,
            'name' => 'BUJI',
            'abbreviation' => '05',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 325,
            'name' => 'DUTSE',
            'abbreviation' => '06',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 326,
            'name' => 'GARKI',
            'abbreviation' => '07',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 327,
            'name' => 'GAGARAWA',
            'abbreviation' => '08',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 328,
            'name' => 'GUMEL',
            'abbreviation' => '09',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 329,
            'name' => 'GURI',
            'abbreviation' => '10',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 330,
            'name' => 'GWARAM',
            'abbreviation' => '11',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 331,
            'name' => 'GWIWA',
            'abbreviation' => '12',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 332,
            'name' => 'HADEJIA',
            'abbreviation' => '13',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 333,
            'name' => 'JAHUN',
            'abbreviation' => '14',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 334,
            'name' => 'KAFIN HAUSA',
            'abbreviation' => '15',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 335,
            'name' => 'KAUGAMA',
            'abbreviation' => '16',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 336,
            'name' => 'KAZAURE',
            'abbreviation' => '17',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 337,
            'name' => 'KIRIKA SAMMA',
            'abbreviation' => '18',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 338,
            'name' => 'KIYAWA',
            'abbreviation' => '19',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 339,
            'name' => 'MAIGATARI',
            'abbreviation' => '20',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 340,
            'name' => 'MALAM MADORI',
            'abbreviation' => '21',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 341,
            'name' => 'MIGA',
            'abbreviation' => '22',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 342,
            'name' => 'RINGIM',
            'abbreviation' => '23',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 343,
            'name' => 'RONI',
            'abbreviation' => '24',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 344,
            'name' => 'SULE-TANKARKAR',
            'abbreviation' => '25',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 345,
            'name' => 'TAURA',
            'abbreviation' => '26',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 346,
            'name' => 'YANKWASHI',
            'abbreviation' => '27',
            'inec_state_id' => 17,
        ]);



        InecLga::create([
            'id' => 347,
            'name' => 'BIRNIN GWARI',
            'abbreviation' => '01',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 348,
            'name' => 'CHIKUN',
            'abbreviation' => '02',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 349,
            'name' => 'GIWA',
            'abbreviation' => '03',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 350,
            'name' => 'IGABI',
            'abbreviation' => '04',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 351,
            'name' => 'IKARA',
            'abbreviation' => '05',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 352,
            'name' => 'JABA',
            'abbreviation' => '06',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 353,
            'name' => 'JEMA\'A',
            'abbreviation' => '07',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 354,
            'name' => 'KACHIA',
            'abbreviation' => '08',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 355,
            'name' => 'KADUNA NORTH',
            'abbreviation' => '09',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 356,
            'name' => 'KADUNA SOUTH',
            'abbreviation' => '10',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 357,
            'name' => 'KAGARKO',
            'abbreviation' => '11',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 358,
            'name' => 'KAJURU',
            'abbreviation' => '12',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 359,
            'name' => 'KAURA',
            'abbreviation' => '13',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 360,
            'name' => 'KAURU',
            'abbreviation' => '14',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 361,
            'name' => 'KUBAU',
            'abbreviation' => '15',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 362,
            'name' => 'KUDAN',
            'abbreviation' => '16',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 363,
            'name' => 'LERE',
            'abbreviation' => '17',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 364,
            'name' => 'MAKARFI',
            'abbreviation' => '18',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 365,
            'name' => 'SABON GARI',
            'abbreviation' => '19',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 366,
            'name' => 'SANGA',
            'abbreviation' => '20',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 367,
            'name' => 'SOBA',
            'abbreviation' => '21',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 368,
            'name' => 'ZANGON KATAF',
            'abbreviation' => '22',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 369,
            'name' => 'ZARIA',
            'abbreviation' => '23',
            'inec_state_id' => 18,
        ]);



        InecLga::create([
            'id' => 370,
            'name' => 'AJINGI',
            'abbreviation' => '01',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 371,
            'name' => 'ALBASU',
            'abbreviation' => '02',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 372,
            'name' => 'BAGWAI',
            'abbreviation' => '03',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 373,
            'name' => 'BEBEJI',
            'abbreviation' => '04',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 374,
            'name' => 'BICHI',
            'abbreviation' => '05',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 375,
            'name' => 'BUNKURE',
            'abbreviation' => '06',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 376,
            'name' => 'DALA',
            'abbreviation' => '07',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 377,
            'name' => 'DANBATA',
            'abbreviation' => '08',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 378,
            'name' => 'DAWAKI KUDU',
            'abbreviation' => '09',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 379,
            'name' => 'DAWAKI TOFA',
            'abbreviation' => '10',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 380,
            'name' => 'DOGUWA',
            'abbreviation' => '11',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 381,
            'name' => 'FAGGE',
            'abbreviation' => '12',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 382,
            'name' => 'GABASAWA',
            'abbreviation' => '13',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 383,
            'name' => 'GARKO',
            'abbreviation' => '14',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 384,
            'name' => 'GARUN MALAM',
            'abbreviation' => '15',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 385,
            'name' => 'GAYA',
            'abbreviation' => '16',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 386,
            'name' => 'GEZAWA',
            'abbreviation' => '17',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 387,
            'name' => 'GWALE',
            'abbreviation' => '18',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 388,
            'name' => 'GWARZO',
            'abbreviation' => '19',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 389,
            'name' => 'KABO',
            'abbreviation' => '20',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 390,
            'name' => 'KANO MUNICIPAL',
            'abbreviation' => '21',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 391,
            'name' => 'KARAYE',
            'abbreviation' => '22',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 392,
            'name' => 'KIBIYA',
            'abbreviation' => '23',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 393,
            'name' => 'KIRU',
            'abbreviation' => '24',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 394,
            'name' => 'KUMBOTSO',
            'abbreviation' => '25',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 395,
            'name' => 'KUNCHI',
            'abbreviation' => '26',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 396,
            'name' => 'KURA',
            'abbreviation' => '27',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 397,
            'name' => 'MADOBI',
            'abbreviation' => '28',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 398,
            'name' => 'MAKODA',
            'abbreviation' => '29',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 399,
            'name' => 'MINJIBIR',
            'abbreviation' => '30',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 400,
            'name' => 'NASARAWA',
            'abbreviation' => '31',
            'inec_state_id' => 19,
        ]);

        InecLga::create([
            'id' => 401,
            'name' => 'RANO',
            'abbreviation' => '32',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 402,
            'name' => 'RIMIN GADO',
            'abbreviation' => '33',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 403,
            'name' => 'ROGO',
            'abbreviation' => '34',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 404,
            'name' => 'SHANONO',
            'abbreviation' => '35',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 405,
            'name' => 'SUMAILA',
            'abbreviation' => '36',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 406,
            'name' => 'TAKAI',
            'abbreviation' => '37',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 407,
            'name' => 'TARAUNI',
            'abbreviation' => '38',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 408,
            'name' => 'TOFA',
            'abbreviation' => '39',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 409,
            'name' => 'TSANYAWA',
            'abbreviation' => '40',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 410,
            'name' => 'TUDUN WADA',
            'abbreviation' => '41',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 411,
            'name' => 'UNGOGO',
            'abbreviation' => '42',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 412,
            'name' => 'WARAWA',
            'abbreviation' => '43',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 413,
            'name' => 'WUDIL',
            'abbreviation' => '44',
            'inec_state_id' => 19,
        ]);



        InecLga::create([
            'id' => 414,
            'name' => 'BAKORI',
            'abbreviation' => '01',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 415,
            'name' => 'BATAGARAWA',
            'abbreviation' => '02',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 416,
            'name' => 'BATSARI',
            'abbreviation' => '03',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 417,
            'name' => 'BAURE',
            'abbreviation' => '04',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 418,
            'name' => 'BINDAWA',
            'abbreviation' => '05',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 419,
            'name' => 'CHARANCHI',
            'abbreviation' => '06',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 420,
            'name' => 'DANDUME',
            'abbreviation' => '07',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 421,
            'name' => 'DANJA',
            'abbreviation' => '08',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 422,
            'name' => 'DAN MUSA',
            'abbreviation' => '09',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 423,
            'name' => 'DAURA',
            'abbreviation' => '10',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 424,
            'name' => 'DUTSI',
            'abbreviation' => '11',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 425,
            'name' => 'DUTSIN-MA',
            'abbreviation' => '12',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 426,
            'name' => 'FASKARI',
            'abbreviation' => '13',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 427,
            'name' => 'FUNTUA',
            'abbreviation' => '14',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 428,
            'name' => 'INGAWA',
            'abbreviation' => '15',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 429,
            'name' => 'JIBIA',
            'abbreviation' => '16',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 430,
            'name' => 'KAFUR',
            'abbreviation' => '17',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 431,
            'name' => 'KAITA',
            'abbreviation' => '18',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 432,
            'name' => 'KANKARA',
            'abbreviation' => '19',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 433,
            'name' => 'KANKIA',
            'abbreviation' => '20',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 434,
            'name' => 'KATSINA',
            'abbreviation' => '21',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 435,
            'name' => 'KURFI',
            'abbreviation' => '22',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 436,
            'name' => 'KUSADA',
            'abbreviation' => '23',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 437,
            'name' => 'MAI\'ADUA',
            'abbreviation' => '24',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 438,
            'name' => 'MALUFASHI',
            'abbreviation' => '25',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 439,
            'name' => 'MANI',
            'abbreviation' => '26',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 440,
            'name' => 'MASHI',
            'abbreviation' => '27',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 441,
            'name' => 'MATAZU',
            'abbreviation' => '28',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 442,
            'name' => 'MUSAWA',
            'abbreviation' => '29',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 443,
            'name' => 'RIMI',
            'abbreviation' => '30',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 444,
            'name' => 'SABUWA',
            'abbreviation' => '31',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 445,
            'name' => 'SAFANA',
            'abbreviation' => '32',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 446,
            'name' => 'SANDAMU',
            'abbreviation' => '33',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 447,
            'name' => 'ZANGO',
            'abbreviation' => '34',
            'inec_state_id' => 20,
        ]);



        InecLga::create([
            'id' => 448,
            'name' => 'ALIERO',
            'abbreviation' => '01',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 449,
            'name' => 'AREWA',
            'abbreviation' => '02',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 450,
            'name' => 'ARGUNGU',
            'abbreviation' => '03',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 451,
            'name' => 'AUGIE',
            'abbreviation' => '04',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 452,
            'name' => 'BAGUDO',
            'abbreviation' => '05',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 453,
            'name' => 'BIRNIN KEBBI',
            'abbreviation' => '06',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 454,
            'name' => 'BUNZA',
            'abbreviation' => '07',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 455,
            'name' => 'DANDI',
            'abbreviation' => '08',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 456,
            'name' => 'FAKAI',
            'abbreviation' => '09',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 457,
            'name' => 'GWANDU',
            'abbreviation' => '10',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 458,
            'name' => 'JEGA',
            'abbreviation' => '11',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 459,
            'name' => 'KALGO',
            'abbreviation' => '12',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 460,
            'name' => 'KOKO/BESSE',
            'abbreviation' => '13',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 461,
            'name' => 'MAIYAMA',
            'abbreviation' => '14',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 462,
            'name' => 'NGASKI',
            'abbreviation' => '15',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 463,
            'name' => 'SAKABA',
            'abbreviation' => '16',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 464,
            'name' => 'SHANGA',
            'abbreviation' => '17',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 465,
            'name' => 'SURU',
            'abbreviation' => '18',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 466,
            'name' => 'WASAGU/DANKO',
            'abbreviation' => '19',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 467,
            'name' => 'YAURI',
            'abbreviation' => '20',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 468,
            'name' => 'ZURU',
            'abbreviation' => '21',
            'inec_state_id' => 21,
        ]);



        InecLga::create([
            'id' => 469,
            'name' => 'ADAVI',
            'abbreviation' => '01',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 470,
            'name' => 'AJAOKUTA',
            'abbreviation' => '02',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 471,
            'name' => 'ANKPA',
            'abbreviation' => '03',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 472,
            'name' => 'BASSA',
            'abbreviation' => '04',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 473,
            'name' => 'DEKINA',
            'abbreviation' => '05',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 474,
            'name' => 'IBAJI',
            'abbreviation' => '06',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 475,
            'name' => 'IDAH',
            'abbreviation' => '07',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 476,
            'name' => 'IGALAMELA/ODOLU',
            'abbreviation' => '08',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 477,
            'name' => 'IJUMU',
            'abbreviation' => '09',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 478,
            'name' => 'KABBA/BUNU',
            'abbreviation' => '10',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 479,
            'name' => 'KOGI . K. K.',
            'abbreviation' => '11',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 480,
            'name' => 'LOKOJA',
            'abbreviation' => '12',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 481,
            'name' => 'MOPA MORO',
            'abbreviation' => '13',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 482,
            'name' => 'OFU',
            'abbreviation' => '14',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 483,
            'name' => 'OGORI MANGOGO',
            'abbreviation' => '15',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 484,
            'name' => 'OKEHI',
            'abbreviation' => '16',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 485,
            'name' => 'OKENE',
            'abbreviation' => '17',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 486,
            'name' => 'OLAMABORO',
            'abbreviation' => '18',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 487,
            'name' => 'OMALA',
            'abbreviation' => '19',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 488,
            'name' => 'YAGBA EAST',
            'abbreviation' => '20',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 489,
            'name' => 'YAGBA WEST',
            'abbreviation' => '21',
            'inec_state_id' => 22,
        ]);



        InecLga::create([
            'id' => 490,
            'name' => 'ASA',
            'abbreviation' => '01',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 491,
            'name' => 'BARUTEN',
            'abbreviation' => '02',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 492,
            'name' => 'EDU',
            'abbreviation' => '03',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 493,
            'name' => 'EKITI',
            'abbreviation' => '04',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 494,
            'name' => 'IFELODUN',
            'abbreviation' => '05',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 495,
            'name' => 'ILORIN EAST',
            'abbreviation' => '06',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 496,
            'name' => 'ILORIN-SOUTH',
            'abbreviation' => '07',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 497,
            'name' => 'ILORIN-WEST',
            'abbreviation' => '08',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 498,
            'name' => 'IREPODUN',
            'abbreviation' => '09',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 499,
            'name' => 'ISIN',
            'abbreviation' => '10',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 500,
            'name' => 'KAIAMA',
            'abbreviation' => '11',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 501,
            'name' => 'MORO',
            'abbreviation' => '12',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 502,
            'name' => 'OFFA',
            'abbreviation' => '13',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 503,
            'name' => 'OKE - ERO',
            'abbreviation' => '14',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 504,
            'name' => 'OYUN',
            'abbreviation' => '15',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 505,
            'name' => 'PATIGI',
            'abbreviation' => '16',
            'inec_state_id' => 23,
        ]);



        InecLga::create([
            'id' => 506,
            'name' => 'AGEGE',
            'abbreviation' => '01',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 507,
            'name' => 'AJEROMI/IFELODUN',
            'abbreviation' => '02',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 508,
            'name' => 'ALIMOSHO',
            'abbreviation' => '03',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 509,
            'name' => 'AMUWO-ODOFIN',
            'abbreviation' => '04',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 510,
            'name' => 'APAPA',
            'abbreviation' => '05',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 511,
            'name' => 'BADAGRY',
            'abbreviation' => '06',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 512,
            'name' => 'EPE',
            'abbreviation' => '07',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 513,
            'name' => 'ETI-OSA',
            'abbreviation' => '08',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 514,
            'name' => 'IBEJU/LEKKI',
            'abbreviation' => '09',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 515,
            'name' => 'IFAKO-IJAYE',
            'abbreviation' => '10',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 516,
            'name' => 'IKEJA',
            'abbreviation' => '11',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 517,
            'name' => 'IKORODU',
            'abbreviation' => '12',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 518,
            'name' => 'KOSOFE',
            'abbreviation' => '13',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 519,
            'name' => 'LAGOS ISLAND',
            'abbreviation' => '14',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 520,
            'name' => 'LAGOS MAINLAND',
            'abbreviation' => '15',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 521,
            'name' => 'MUSHIN',
            'abbreviation' => '16',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 522,
            'name' => 'OJO',
            'abbreviation' => '17',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 523,
            'name' => 'OSHODI/ISOLO',
            'abbreviation' => '18',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 524,
            'name' => 'SOMOLU',
            'abbreviation' => '19',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 525,
            'name' => 'SURULERE',
            'abbreviation' => '20',
            'inec_state_id' => 24,
        ]);



        InecLga::create([
            'id' => 526,
            'name' => 'AKWANGA',
            'abbreviation' => '01',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 527,
            'name' => 'AWE',
            'abbreviation' => '02',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 528,
            'name' => 'DOMA',
            'abbreviation' => '03',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 529,
            'name' => 'KARU',
            'abbreviation' => '04',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 530,
            'name' => 'KEANA',
            'abbreviation' => '05',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 531,
            'name' => 'KEFFI',
            'abbreviation' => '06',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 532,
            'name' => 'KOKONA',
            'abbreviation' => '07',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 533,
            'name' => 'LAFIA',
            'abbreviation' => '08',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 534,
            'name' => 'NASARAWA EGGON',
            'abbreviation' => '10',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 535,
            'name' => 'TOTO',
            'abbreviation' => '12',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 536,
            'name' => 'WAMBA',
            'abbreviation' => '13',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 771,
            'name' => 'NASARAWA',
            'abbreviation' => '09',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 774,
            'name' => 'OBI',
            'abbreviation' => '11',
            'inec_state_id' => 25,
        ]);



        InecLga::create([
            'id' => 537,
            'name' => 'AGAIE',
            'abbreviation' => '01',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 538,
            'name' => 'AGWARA',
            'abbreviation' => '02',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 539,
            'name' => 'BIDA',
            'abbreviation' => '03',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 540,
            'name' => 'BORGU',
            'abbreviation' => '04',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 541,
            'name' => 'BOSSO',
            'abbreviation' => '05',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 542,
            'name' => 'CHANCHAGA',
            'abbreviation' => '06',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 543,
            'name' => 'EDATTI',
            'abbreviation' => '07',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 544,
            'name' => 'GBAKO',
            'abbreviation' => '08',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 545,
            'name' => 'GURARA',
            'abbreviation' => '09',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 546,
            'name' => 'KATCHA',
            'abbreviation' => '10',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 547,
            'name' => 'KONTAGORA',
            'abbreviation' => '11',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 548,
            'name' => 'LAPAI',
            'abbreviation' => '12',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 549,
            'name' => 'LAVUN',
            'abbreviation' => '13',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 550,
            'name' => 'MAGAMA',
            'abbreviation' => '14',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 551,
            'name' => 'MARIGA',
            'abbreviation' => '15',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 552,
            'name' => 'MASHEGU',
            'abbreviation' => '16',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 553,
            'name' => 'MOKWA',
            'abbreviation' => '17',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 554,
            'name' => 'MUNYA',
            'abbreviation' => '18',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 555,
            'name' => 'PAIKORO',
            'abbreviation' => '19',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 556,
            'name' => 'RAFI',
            'abbreviation' => '20',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 557,
            'name' => 'RIJAU',
            'abbreviation' => '21',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 558,
            'name' => 'SHIRORO',
            'abbreviation' => '22',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 559,
            'name' => 'SULEJA',
            'abbreviation' => '23',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 560,
            'name' => 'TAFA',
            'abbreviation' => '24',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 561,
            'name' => 'WUSHISHI',
            'abbreviation' => '25',
            'inec_state_id' => 26,
        ]);



        InecLga::create([
            'id' => 562,
            'name' => 'ABEOKUTA NORTH',
            'abbreviation' => '01',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 563,
            'name' => 'ABEOKUTA SOUTH',
            'abbreviation' => '02',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 564,
            'name' => 'ADO ODO-OTA',
            'abbreviation' => '03',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 565,
            'name' => 'EGBADO NORTH',
            'abbreviation' => '04',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 566,
            'name' => 'EGBADO SOUTH',
            'abbreviation' => '05',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 567,
            'name' => 'EWEKORO',
            'abbreviation' => '06',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 568,
            'name' => 'IFO',
            'abbreviation' => '07',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 569,
            'name' => 'IJEBU EAST',
            'abbreviation' => '08',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 570,
            'name' => 'IJEBU NORTH',
            'abbreviation' => '09',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 571,
            'name' => 'IJEBU NORTH EAST',
            'abbreviation' => '10',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 572,
            'name' => 'IJEBU ODE',
            'abbreviation' => '11',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 573,
            'name' => 'IKENNE',
            'abbreviation' => '12',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 574,
            'name' => 'IMEKO/AFON',
            'abbreviation' => '13',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 575,
            'name' => 'IPOKIA',
            'abbreviation' => '14',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 576,
            'name' => 'OBAFEMI/OWODE',
            'abbreviation' => '15',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 577,
            'name' => 'ODEDA',
            'abbreviation' => '16',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 578,
            'name' => 'ODOGBOLU',
            'abbreviation' => '17',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 579,
            'name' => 'OGUN WATER SIDE',
            'abbreviation' => '18',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 580,
            'name' => 'REMO NORTH',
            'abbreviation' => '19',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 581,
            'name' => 'SAGAMU',
            'abbreviation' => '20',
            'inec_state_id' => 27,
        ]);



        InecLga::create([
            'id' => 582,
            'name' => 'AKOKO NORTH EAST',
            'abbreviation' => '01',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 583,
            'name' => 'AKOKO NORTH WEST',
            'abbreviation' => '02',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 584,
            'name' => 'AKOKO SOUTH EAST',
            'abbreviation' => '03',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 585,
            'name' => 'AKOKO SOUTH WEST',
            'abbreviation' => '04',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 586,
            'name' => 'AKURE NORTH',
            'abbreviation' => '05',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 587,
            'name' => 'AKURE SOUTH',
            'abbreviation' => '06',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 588,
            'name' => 'ESE-ODO',
            'abbreviation' => '07',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 589,
            'name' => 'IDANRE',
            'abbreviation' => '08',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 590,
            'name' => 'IFEDORE',
            'abbreviation' => '09',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 591,
            'name' => 'ILAJE',
            'abbreviation' => '10',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 592,
            'name' => 'ILEOLUJI/OKEIGBO',
            'abbreviation' => '11',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 593,
            'name' => 'IRELE',
            'abbreviation' => '12',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 594,
            'name' => 'ODIGBO',
            'abbreviation' => '13',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 595,
            'name' => 'OKITIPUPA',
            'abbreviation' => '14',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 596,
            'name' => 'ONDO EAST',
            'abbreviation' => '15',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 597,
            'name' => 'ONDO WEST',
            'abbreviation' => '16',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 598,
            'name' => 'OSE',
            'abbreviation' => '17',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 599,
            'name' => 'OWO',
            'abbreviation' => '18',
            'inec_state_id' => 28,
        ]);



        InecLga::create([
            'id' => 600,
            'name' => 'ATAKUMOSA EAST',
            'abbreviation' => '01',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 601,
            'name' => 'ATAKUMOSA WEST',
            'abbreviation' => '02',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 602,
            'name' => 'AYEDAADE',
            'abbreviation' => '03',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 603,
            'name' => 'AYEDIRE',
            'abbreviation' => '04',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 604,
            'name' => 'BOLUWADURO',
            'abbreviation' => '05',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 605,
            'name' => 'BORIPE',
            'abbreviation' => '06',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 606,
            'name' => 'EDE NORTH',
            'abbreviation' => '07',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 607,
            'name' => 'EDE SOUTH',
            'abbreviation' => '08',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 608,
            'name' => 'EGBEDORE',
            'abbreviation' => '09',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 609,
            'name' => 'EJIGBO',
            'abbreviation' => '10',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 610,
            'name' => 'IFE CENTRAL',
            'abbreviation' => '11',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 611,
            'name' => 'IFEDAYO',
            'abbreviation' => '12',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 612,
            'name' => 'IFE EAST',
            'abbreviation' => '13',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 613,
            'name' => 'IFE NORTH',
            'abbreviation' => '15',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 614,
            'name' => 'IFE SOUTH',
            'abbreviation' => '16',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 615,
            'name' => 'ILA',
            'abbreviation' => '17',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 616,
            'name' => 'ILESA EAST',
            'abbreviation' => '18',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 617,
            'name' => 'ILESA WEST',
            'abbreviation' => '19',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 618,
            'name' => 'IREWOLE',
            'abbreviation' => '21',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 619,
            'name' => 'ISOKAN',
            'abbreviation' => '22',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 620,
            'name' => 'IWO',
            'abbreviation' => '23',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 621,
            'name' => 'OBOKUN',
            'abbreviation' => '24',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 622,
            'name' => 'ODO-OTIN',
            'abbreviation' => '25',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 623,
            'name' => 'OLA-OLUWA',
            'abbreviation' => '26',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 624,
            'name' => 'OLORUNDA',
            'abbreviation' => '27',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 625,
            'name' => 'ORIADE',
            'abbreviation' => '28',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 626,
            'name' => 'OROLU',
            'abbreviation' => '29',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 627,
            'name' => 'OSOGBO',
            'abbreviation' => '30',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 770,
            'name' => 'IREPODUN',
            'abbreviation' => '20',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 772,
            'name' => 'IFELODUN',
            'abbreviation' => '14',
            'inec_state_id' => 29,
        ]);



        InecLga::create([
            'id' => 628,
            'name' => 'AFIJIO',
            'abbreviation' => '01',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 629,
            'name' => 'AKINYELE',
            'abbreviation' => '02',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 630,
            'name' => 'ATIBA',
            'abbreviation' => '03',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 631,
            'name' => 'ATISBO',
            'abbreviation' => '04',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 632,
            'name' => 'EGBEDA',
            'abbreviation' => '05',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 633,
            'name' => 'IBADAN NORTH',
            'abbreviation' => '06',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 634,
            'name' => 'IBADAN NORTH EAST',
            'abbreviation' => '07',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 635,
            'name' => 'IBADAN NORTH WEST',
            'abbreviation' => '08',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 636,
            'name' => 'IBADAN SOUTH-EAST',
            'abbreviation' => '09',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 637,
            'name' => 'IBADAN SOUTH WEST',
            'abbreviation' => '10',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 638,
            'name' => 'IBARAPA CENTRAL',
            'abbreviation' => '11',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 639,
            'name' => 'IBARAPA EAST',
            'abbreviation' => '12',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 640,
            'name' => 'IBARAPA NORTH',
            'abbreviation' => '13',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 641,
            'name' => 'IDO',
            'abbreviation' => '14',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 642,
            'name' => 'IREPO',
            'abbreviation' => '15',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 643,
            'name' => 'ISEYIN',
            'abbreviation' => '16',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 644,
            'name' => 'ITESIWAJU',
            'abbreviation' => '17',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 645,
            'name' => 'IWAJOWA',
            'abbreviation' => '18',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 646,
            'name' => 'KAJOLA',
            'abbreviation' => '19',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 647,
            'name' => 'LAGELU',
            'abbreviation' => '20',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 648,
            'name' => 'OGBOMOSO NORTH',
            'abbreviation' => '21',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 649,
            'name' => 'OGBOMOSO SOUTH',
            'abbreviation' => '22',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 650,
            'name' => 'OGO-OLUWA',
            'abbreviation' => '23',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 651,
            'name' => 'OLORUNSOGO',
            'abbreviation' => '24',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 652,
            'name' => 'OLUYOLE',
            'abbreviation' => '25',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 653,
            'name' => 'ONA-ARA',
            'abbreviation' => '26',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 654,
            'name' => 'OORELOPE',
            'abbreviation' => '27',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 655,
            'name' => 'ORI IRE',
            'abbreviation' => '28',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 656,
            'name' => 'OYO EAST',
            'abbreviation' => '29',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 657,
            'name' => 'OYO WEST',
            'abbreviation' => '30',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 658,
            'name' => 'SAKI EAST',
            'abbreviation' => '31',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 659,
            'name' => 'SAKI WEST',
            'abbreviation' => '32',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 773,
            'name' => 'SURULERE',
            'abbreviation' => '33',
            'inec_state_id' => 30,
        ]);



        InecLga::create([
            'id' => 660,
            'name' => 'BARIKIN LADI',
            'abbreviation' => '01',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 661,
            'name' => 'BOKKOS',
            'abbreviation' => '03',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 662,
            'name' => 'JOS EAST',
            'abbreviation' => '04',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 663,
            'name' => 'JOS NORTH',
            'abbreviation' => '05',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 664,
            'name' => 'JOS SOUTH',
            'abbreviation' => '06',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 665,
            'name' => 'KANAM',
            'abbreviation' => '07',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 666,
            'name' => 'KANKE',
            'abbreviation' => '08',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 667,
            'name' => 'LANGTANG NORTH',
            'abbreviation' => '09',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 668,
            'name' => 'LANGTANG SOUTH',
            'abbreviation' => '10',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 669,
            'name' => 'MANGU',
            'abbreviation' => '11',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 670,
            'name' => 'MIKANG',
            'abbreviation' => '12',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 671,
            'name' => 'PANKSHIN',
            'abbreviation' => '13',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 672,
            'name' => 'QUA\'AN PAN',
            'abbreviation' => '14',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 673,
            'name' => 'RIYOM',
            'abbreviation' => '15',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 674,
            'name' => 'SHENDAM',
            'abbreviation' => '16',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 675,
            'name' => 'WASE',
            'abbreviation' => '17',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 769,
            'name' => 'BASSA',
            'abbreviation' => '02',
            'inec_state_id' => 31,
        ]);



        InecLga::create([
            'id' => 676,
            'name' => 'ABUA-ODUAL',
            'abbreviation' => '01',
            'inec_state_id' => 32,
        ]);



        InecLga::create([
            'id' => 677,
            'name' => 'AHOADA EAST',
            'abbreviation' => '02',
            'inec_state_id' => 32,
        ]);



        InecLga::create([
            'id' => 678,
            'name' => 'AHOADA WEST',
            'abbreviation' => '03',
            'inec_state_id' => 32,
        ]);



        InecLga::create([
            'id' => 679,
            'name' => 'AKUKU TORU',
            'abbreviation' => '04',
            'inec_state_id' => 32,
        ]);



        InecLga::create([
            'id' => 680,
            'name' => 'ANDONI',
            'abbreviation' => '05',
            'inec_state_id' => 32,
        ]);



        InecLga::create([
            'id' => 681,
            'name' => 'ASARI-TORU',
            'abbreviation' => '06',
            'inec_state_id' => 32,
        ]);

        Ineclga::create([
            'id' => 682,
            'name' => 'BONNY',
            'abbreviation' => '07',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 683,
            'name' => 'DEGEMA',
            'abbreviation' => '08',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 684,
            'name' => 'ELEME',
            'abbreviation' => '09',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 685,
            'name' => 'EMOHUA',
            'abbreviation' => '10',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 686,
            'name' => 'ETCHE',
            'abbreviation' => '11',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 687,
            'name' => 'GOKANA',
            'abbreviation' => '12',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 688,
            'name' => 'IKWERRE',
            'abbreviation' => '13',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 689,
            'name' => 'KHANA',
            'abbreviation' => '14',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 690,
            'name' => 'OBIO/AKPOR',
            'abbreviation' => '15',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 691,
            'name' => 'OGBA/EGBEMA/NDONI',
            'abbreviation' => '16',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 692,
            'name' => 'OGU/BOLO',
            'abbreviation' => '17',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 693,
            'name' => 'OKRIKA',
            'abbreviation' => '18',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 694,
            'name' => 'OMUMA',
            'abbreviation' => '19',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 695,
            'name' => 'OPOBO/NEKORO',
            'abbreviation' => '20',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 696,
            'name' => 'OYIGBO',
            'abbreviation' => '21',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 697,
            'name' => 'PORT HARCOURT',
            'abbreviation' => '22',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 698,
            'name' => 'TAI',
            'abbreviation' => '23',
            'inec_state_id' => 32,
        ]);



        Ineclga::create([
            'id' => 699,
            'name' => 'BINJI',
            'abbreviation' => '01',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 700,
            'name' => 'BODINGA',
            'abbreviation' => '02',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 701,
            'name' => 'DANGE/SHUNI',
            'abbreviation' => '03',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 702,
            'name' => 'GADA',
            'abbreviation' => '04',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 703,
            'name' => 'GORONYO',
            'abbreviation' => '05',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 704,
            'name' => 'GUDU',
            'abbreviation' => '06',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 705,
            'name' => 'GWADABAWA',
            'abbreviation' => '07',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 706,
            'name' => 'ILLELA',
            'abbreviation' => '08',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 707,
            'name' => 'ISA',
            'abbreviation' => '09',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 708,
            'name' => 'KWARE',
            'abbreviation' => '10',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 709,
            'name' => 'KEBBE',
            'abbreviation' => '11',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 710,
            'name' => 'RABAH',
            'abbreviation' => '12',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 711,
            'name' => 'S/BIRNI',
            'abbreviation' => '13',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 712,
            'name' => 'SHAGARI',
            'abbreviation' => '14',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 713,
            'name' => 'SILAME',
            'abbreviation' => '15',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 714,
            'name' => 'SOKOTO NORTH',
            'abbreviation' => '16',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 715,
            'name' => 'SOKOTO SOUTH',
            'abbreviation' => '17',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 716,
            'name' => 'TAMBUWAL',
            'abbreviation' => '18',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 717,
            'name' => 'TANGAZA',
            'abbreviation' => '19',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 718,
            'name' => 'TURETA',
            'abbreviation' => '20',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 719,
            'name' => 'WAMAKKO',
            'abbreviation' => '21',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 720,
            'name' => 'WURNO',
            'abbreviation' => '22',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 721,
            'name' => 'YABO',
            'abbreviation' => '23',
            'inec_state_id' => 33,
        ]);



        Ineclga::create([
            'id' => 722,
            'name' => 'ARDO - KOLA',
            'abbreviation' => '01',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 723,
            'name' => 'BALI',
            'abbreviation' => '02',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 724,
            'name' => 'DONGA',
            'abbreviation' => '03',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 725,
            'name' => 'GASHAKA',
            'abbreviation' => '04',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 726,
            'name' => 'GASSOL',
            'abbreviation' => '05',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 727,
            'name' => 'IBI',
            'abbreviation' => '06',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 728,
            'name' => 'JALINGO',
            'abbreviation' => '07',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 729,
            'name' => 'KARIM-LAMIDO',
            'abbreviation' => '08',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 730,
            'name' => 'KURMI',
            'abbreviation' => '09',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 731,
            'name' => 'LAU',
            'abbreviation' => '10',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 732,
            'name' => 'SARDAUNA',
            'abbreviation' => '11',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 733,
            'name' => 'TAKUM',
            'abbreviation' => '12',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 734,
            'name' => 'USSA',
            'abbreviation' => '13',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 735,
            'name' => 'WUKARI',
            'abbreviation' => '14',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 736,
            'name' => 'YORRO',
            'abbreviation' => '15',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 737,
            'name' => 'ZING',
            'abbreviation' => '16',
            'inec_state_id' => 34,
        ]);



        Ineclga::create([
            'id' => 738,
            'name' => 'BADE',
            'abbreviation' => '01',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 739,
            'name' => 'BURSARI',
            'abbreviation' => '02',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 740,
            'name' => 'DAMATURU',
            'abbreviation' => '03',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 741,
            'name' => 'FIKA',
            'abbreviation' => '04',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 742,
            'name' => 'FUNE',
            'abbreviation' => '05',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 743,
            'name' => 'GEIDAM',
            'abbreviation' => '06',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 744,
            'name' => 'GUJBA',
            'abbreviation' => '07',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 745,
            'name' => 'GULANI',
            'abbreviation' => '08',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 746,
            'name' => 'JAKUSKO',
            'abbreviation' => '09',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 747,
            'name' => 'KARASAWA',
            'abbreviation' => '10',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 748,
            'name' => 'MACHINA',
            'abbreviation' => '11',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 749,
            'name' => 'NANGERE',
            'abbreviation' => '12',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 750,
            'name' => 'NGURU',
            'abbreviation' => '13',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 751,
            'name' => 'POTISKUM',
            'abbreviation' => '14',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 752,
            'name' => 'TARMUWA',
            'abbreviation' => '15',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 753,
            'name' => 'YUNUSARI',
            'abbreviation' => '16',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 754,
            'name' => 'YUSUFARI',
            'abbreviation' => '17',
            'inec_state_id' => 35,
        ]);



        Ineclga::create([
            'id' => 755,
            'name' => 'ANKA',
            'abbreviation' => '01',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 756,
            'name' => 'BAKURA',
            'abbreviation' => '02',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 757,
            'name' => 'BIRNIN MAGAJI',
            'abbreviation' => '03',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 758,
            'name' => 'BUKKUYUM',
            'abbreviation' => '04',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 759,
            'name' => 'BUNGUDU',
            'abbreviation' => '05',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 760,
            'name' => 'GUMMI',
            'abbreviation' => '06',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 761,
            'name' => 'GUSAU',
            'abbreviation' => '07',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 762,
            'name' => 'KAURA NAMODA',
            'abbreviation' => '08',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 763,
            'name' => 'MARADUN',
            'abbreviation' => '09',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 764,
            'name' => 'MARU',
            'abbreviation' => '10',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 765,
            'name' => 'SHINKAFI',
            'abbreviation' => '11',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 766,
            'name' => 'TALATA MAFARA',
            'abbreviation' => '12',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 767,
            'name' => 'TSAFE',
            'abbreviation' => '13',
            'inec_state_id' => 36,
        ]);



        Ineclga::create([
            'id' => 768,
            'name' => 'ZURMI',
            'abbreviation' => '14',
            'inec_state_id' => 36,
        ]);
    }
}
