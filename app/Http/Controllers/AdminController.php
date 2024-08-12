<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\AccountCreditHistory;
use App\Models\AdminDebitUsersHistory;
use App\Models\AdminFundUsersHistory;
use App\Models\AirtimeTopup;
use App\Models\CablePlan;
use App\Models\ComboRechargeVtu;
use App\Models\Country;
use App\Models\DataPlan;
use App\Models\EasyLoan;
use App\Models\EasySavings;
use App\Models\EducationalPlan;
use App\Models\MlmDb;
use App\Models\MlmEarning;
use App\Models\RouterPlan;
use App\Models\TransferFundsHistory;
use App\Models\User;
use App\Models\VtuTransaction;
use App\Models\WithdrawalRequest;
use App\Rules\CountryRule;
use App\Rules\PhoneEditProfRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AdminController extends Controller
{

    public UsefulFunctions $functions;
    public $networks;
    public $tvs;
    public $routers;
    public $educationals;
    public $airtime_platforms;
    public $data_platforms;
    public $electricity_platforms;
    public $cable_platforms;
    public $router_platforms;
    public $educational_platforms;

    public function __construct()
    {
        $this->functions = new UsefulFunctions();
        $this->networks = ['mtn', 'airtel', 'glo', '9mobile'];
        $this->tvs = ['dstv', 'gotv', 'startimes'];
        $this->routers = ['smile', 'spectranet'];
        $this->educationals = ['waec', 'neco'];

        $this->airtime_platforms = [
            'mtn' => ['gsubz' => 'gsubz', 'clubkonnect' => 'clubkonnect'],
            'airtel' => ['gsubz' => 'gsubz', 'clubkonnect' => 'clubkonnect'],
            'glo' => ['gsubz' => 'gsubz', 'clubkonnect' => 'clubkonnect'],
            '9mobile' => ['gsubz' => 'gsubz', 'clubkonnect' => 'clubkonnect'],
        ];
        
        $this->data_platforms = [
            'mtn' => ['payscribe' => 'payscribe', 'gsubz_mtn_sme' => 'gsubz_mtn_sme', 'gsubz_mtn_cg' => 'gsubz_mtn_cg', 'gsubz_mtncg' => 'gsubz_mtncg', 'gsubz_mtn_cg_lite' => 'gsubz_mtn_cg_lite', 'gsubz_mtn_coupon' => 'gsubz_mtn_coupon', 'clubkonnect' => 'clubkonnect'],
            'airtel' => ['payscribe' => 'payscribe', 'gsubz_airtel_cg' => 'gsubz_airtel_cg', 'gsubz_airtelcg' => 'gsubz_airtelcg', 'clubkonnect' => 'clubkonnect'],
            'glo' => ['payscribe' => 'payscribe', 'gsubz_glo_data' => 'gsubz_glo_data', 'clubkonnect' => 'clubkonnect'],
            '9mobile' => ['payscribe' => 'payscribe', 'gsubz_etisalat_data' => 'gsubz_etisalat_data', 'clubkonnect' => 'clubkonnect'],
        ];

        $this->electricity_platforms = [
            'buypower' => 'buypower', 'payscribe' => 'payscribe',
        ];

        $this->cable_platforms = [
            'dstv' => ['clubkonnect' => 'clubkonnect', 'payscribe' => 'payscribe'],
            'gotv' => ['clubkonnect' => 'clubkonnect', 'payscribe' => 'payscribe'],
            'startimes' => ['clubkonnect' => 'clubkonnect', 'payscribe' => 'payscribe'],
            
        ];

        $this->router_platforms = [
            // 'smile' => ['clubkonnect' => 'clubkonnect', 'payscribe' => 'payscribe'],
            // 'spectranet' => ['clubkonnect' => 'clubkonnect', 'payscribe' => 'payscribe'],

            'smile' => ['clubkonnect' => 'clubkonnect'],
            'spectranet' => ['clubkonnect' => 'clubkonnect'],
        ];

        $this->educational_platforms = [
            'waec' => ['clubkonnect' => 'clubkonnect', 'payscribe' => 'payscribe'],
            'neco' => ['payscribe' => 'payscribe'],

        ];
    }

    

    public function loadManageVtuPage(Request $request, $param1 = null)
    {

        $props['user'] = Auth::user();
        $props['networks'] = $this->networks;
        $props['tvs'] = $this->tvs;
        $props['routers'] = $this->routers;
        $props['educationals'] = $this->educationals;
        
        $props['airtime_platforms'] = $this->airtime_platforms;
        $props['data_platforms'] = $this->data_platforms;
        $props['electricity_platforms'] = $this->electricity_platforms;
        $props['cable_platforms'] = $this->cable_platforms;
        $props['router_platforms'] = $this->router_platforms;
        $props['educational_platforms'] = $this->educational_platforms;
        $props['history_opened'] = $param1 == 'history' ? true : false;

        
        // return $props;
        return Inertia::render('Admin/ManageVtu', $props);
    }


    public function loadManageVtuPageHistory(Request $request){
        return redirect()->route('manage_vtu', ['param1' => 'history']);
    }

    public function saveEducationalPlansSettings(Request $request, User $user)
    {
        $response = ['success' => false];


        $request->validate([
            'network' => ['required', Rule::in($this->educationals)],
            'platform' => ['required', Rule::in($this->educational_platforms[strtolower($request->network)])],
            'modify_prices_status' => 'required|in:yes,no',
            'price_alteration_option' => 'required|in:percentage,direct',
            'percentage' => 'nullable|numeric|max:100',
            'added_amount' => 'nullable|numeric',
        ]);

        $platform = $request->platform;

        $this->functions->setCurrentPlatform('educational', $request->network, $platform);

        $data_plan = EducationalPlan::where('network', $request->network)->get();
        if ($data_plan->count() == 1) {
            $data_plan = EducationalPlan::find($data_plan[0]->id);



            $data_plan->modify_prices = $request->modify_prices_status;
            $data_plan->price_alteration_option = $request->price_alteration_option;
            $data_plan->percentage = $request->percentage;
            $data_plan->added_amount = $request->added_amount;

            if ($data_plan->modify_prices == 'yes' && $data_plan->price_alteration_option == 'direct') {
                $prices_details = $data_plan->details;

                if ($request->has('plans')) {
                    $plans = $request->plans;
                    if (count($plans) > 0) {
                        $plans_arr = [];
                        foreach ($plans as $plan) {
                            $name = $plan['name'];
                            $product_id = $plan['product_id'];
                            $old_price = $plan['old_price'];
                            $new_price = (float) $plan['new_price'];


                            // $preset_plans = json_decode(json_encode($preset_plans));
                            // dd($preset_plans);

                            $plans_arr[] = [
                                'name' => $name,
                                'product_id' => $product_id,
                                'price' => $new_price,
                            ];
                        }


                        $preset_plans = json_decode($prices_details);
                        foreach ($preset_plans as $plan) {
                            if (isset($plan->$platform)) {

                                $plan->$platform = $plans_arr;
                            }
                        }

                        $data_plan->details = json_encode($preset_plans);
                    }
                }
            }

            $data_plan->save();
        }

        $response['success'] = true;

        return back()->with('data', $response);
    }

    public function loadEducationalPlanDetailsByNetwork(Request $request, User $user)
    {
        $response = ['success' => false, 'current_platform' => '', 'gsubz' => false, 'modify_prices_status' => false, 'percentage' => 0, 'added_amount' => 0, 'plans' => []];

        if ($request->has('network') && $request->has('platform')) {
            $network = $request->network;
            $platform = $request->platform;

            if (in_array($network, $this->educationals) && in_array($platform, $this->educational_platforms[$network])) {

                $current_platform = $this->functions->getVtuPlatformToUse('educational', $network);
                $response['current_platform'] = $current_platform;

                $data_plan = EducationalPlan::where('network', $network)->get();
                if ($data_plan->count() == 1) {
                    $data_plan = $data_plan[0];
                    $modify_prices_status = $request->has('temp') ? $request->modify_prices_status : $data_plan->modify_prices;
                    $price_alteration_option = $request->has('temp') ? $request->price_alteration_option : $data_plan->price_alteration_option;
                    $percentage = $request->has('temp') ? $request->percentage : $data_plan->percentage;
                    $added_amount = $request->has('temp') ? $request->added_amount : $data_plan->added_amount;

                    $response['modify_prices_status'] = $modify_prices_status;
                    $response['price_alteration_option'] = $price_alteration_option;
                    $response['percentage'] = $percentage;
                    $response['added_amount'] = $added_amount;

                    if ($modify_prices_status == "yes") {
                        //Get plans for this particular platform with old price and new price depending on price alteration option


                        $options = (object) [
                            'price_alteration_option' => $price_alteration_option,
                            'percentage' => $percentage,
                            'added_amount' => $added_amount,
                        ];

                        $platform_to_use = $request->has('platform_changed') ? $platform : $current_platform;
                        // return $platform_to_use;
                        $plans = $this->functions->getEducationalPlansForEditing($network, $platform_to_use, $options);

                        if (count($plans) > 0) {

                            $response['plans'] = $plans;
                        }
                    }
                    $response['success'] = true;
                }
            }
        }

        return $response;
    }

    public function saveRouterPlansSettings(Request $request, User $user)
    {
        $response = ['success' => false];


        $request->validate([
            'network' => ['required', Rule::in($this->routers)],
            'platform' => ['required', Rule::in($this->router_platforms[strtolower($request->network)])],
            'modify_prices_status' => 'required|in:yes,no',
            'price_alteration_option' => 'required|in:percentage,direct',
            'percentage' => 'nullable|numeric|max:100',
            'added_amount' => 'nullable|numeric',
        ]);

        $platform = $request->platform;

        $this->functions->setCurrentPlatform('router', $request->network, $platform);

        $data_plan = RouterPlan::where('network', $request->network)->get();
        if ($data_plan->count() == 1) {
            $data_plan = RouterPlan::find($data_plan[0]->id);



            $data_plan->modify_prices = $request->modify_prices_status;
            $data_plan->price_alteration_option = $request->price_alteration_option;
            $data_plan->percentage = $request->percentage;
            $data_plan->added_amount = $request->added_amount;

            if ($data_plan->modify_prices == 'yes' && $data_plan->price_alteration_option == 'direct') {
                $prices_details = $data_plan->details;

                if ($request->has('plans')) {
                    $plans = $request->plans;
                    if (count($plans) > 0) {
                        $plans_arr = [];
                        foreach ($plans as $plan) {
                            $name = $plan['name'];
                            $product_id = $plan['product_id'];
                            $old_price = $plan['old_price'];
                            $new_price = (float) $plan['new_price'];


                            // $preset_plans = json_decode(json_encode($preset_plans));
                            // dd($preset_plans);

                            $plans_arr[] = [
                                'name' => $name,
                                'product_id' => $product_id,
                                'price' => $new_price,
                            ];
                        }


                        $preset_plans = json_decode($prices_details);
                        foreach ($preset_plans as $plan) {
                            if (isset($plan->$platform)) {

                                $plan->$platform = $plans_arr;
                            }
                        }

                        $data_plan->details = json_encode($preset_plans);
                    }
                }
            }

            $data_plan->save();
        }

        $response['success'] = true;

        return back()->with('data', $response);
    }

    public function loadRouterPlanDetailsByNetwork(Request $request, User $user)
    {
        $response = ['success' => false, 'current_platform' => '', 'gsubz' => false, 'modify_prices_status' => false, 'percentage' => 0, 'added_amount' => 0, 'plans' => []];

        if ($request->has('network') && $request->has('platform')) {
            $network = $request->network;
            $platform = $request->platform;

            if (in_array($network, $this->routers) && in_array($platform, $this->router_platforms[$network])) {

                $current_platform = $this->functions->getVtuPlatformToUse('router', $network);
                $response['current_platform'] = $current_platform;

                $data_plan = RouterPlan::where('network', $network)->get();
                if ($data_plan->count() == 1) {
                    $data_plan = $data_plan[0];
                    $modify_prices_status = $request->has('temp') ? $request->modify_prices_status : $data_plan->modify_prices;
                    $price_alteration_option = $request->has('temp') ? $request->price_alteration_option : $data_plan->price_alteration_option;
                    $percentage = $request->has('temp') ? $request->percentage : $data_plan->percentage;
                    $added_amount = $request->has('temp') ? $request->added_amount : $data_plan->added_amount;

                    $response['modify_prices_status'] = $modify_prices_status;
                    $response['price_alteration_option'] = $price_alteration_option;
                    $response['percentage'] = $percentage;
                    $response['added_amount'] = $added_amount;

                    if ($modify_prices_status == "yes") {
                        //Get plans for this particular platform with old price and new price depending on price alteration option


                        $options = (object) [
                            'price_alteration_option' => $price_alteration_option,
                            'percentage' => $percentage,
                            'added_amount' => $added_amount,
                        ];

                        $platform_to_use = $request->has('platform_changed') ? $platform : $current_platform;
                        // return $platform_to_use;
                        $plans = $this->functions->getRouterPlansForEditing($network, $platform_to_use, $options);

                        if (count($plans) > 0) {

                            $response['plans'] = $plans;
                        }
                    }
                    $response['success'] = true;
                }
            }
        }

        return $response;
    }

    public function saveCablePlansSettings(Request $request, User $user)
    {
        $response = ['success' => false];


        $request->validate([
            'network' => ['required', Rule::in($this->tvs)],
            'platform' => ['required', Rule::in($this->cable_platforms[strtolower($request->network)])],
            'modify_prices_status' => 'required|in:yes,no',
            'price_alteration_option' => 'required|in:percentage,direct',
            'percentage' => 'nullable|numeric|max:100',
            'added_amount' => 'nullable|numeric',
        ]);

        $platform = $request->platform;

        $this->functions->setCurrentPlatform('cable', $request->network, $platform);

        $data_plan = CablePlan::where('network', $request->network)->get();
        if ($data_plan->count() == 1) {
            $data_plan = CablePlan::find($data_plan[0]->id);



            $data_plan->modify_prices = $request->modify_prices_status;
            $data_plan->price_alteration_option = $request->price_alteration_option;
            $data_plan->percentage = $request->percentage;
            $data_plan->added_amount = $request->added_amount;

            if ($data_plan->modify_prices == 'yes' && $data_plan->price_alteration_option == 'direct') {
                $prices_details = $data_plan->details;

                if ($request->has('plans')) {
                    $plans = $request->plans;
                    if (count($plans) > 0) {
                        $plans_arr = [];
                        foreach ($plans as $plan) {
                            $name = $plan['name'];
                            $product_id = $plan['product_id'];
                            $old_price = $plan['old_price'];
                            $new_price = (float) $plan['new_price'];


                            // $preset_plans = json_decode(json_encode($preset_plans));
                            // dd($preset_plans);

                            $plans_arr[] = [
                                'name' => $name,
                                'product_id' => $product_id,
                                'price' => $new_price,
                            ];
                        }


                        $preset_plans = json_decode($prices_details);
                        foreach ($preset_plans as $plan) {
                            if (isset($plan->$platform)) {

                                $plan->$platform = $plans_arr;
                            }
                        }

                        $data_plan->details = json_encode($preset_plans);
                    }
                }
            }

            $data_plan->save();
        }

        $response['success'] = true;

        return back()->with('data', $response);
    }

    public function loadCablePlanDetailsByNetwork(Request $request, User $user)
    {
        $response = ['success' => false, 'current_platform' => '', 'gsubz' => false, 'modify_prices_status' => false, 'percentage' => 0, 'added_amount' => 0, 'plans' => []];

        if ($request->has('network') && $request->has('platform')) {
            $network = $request->network;
            $platform = $request->platform;

            if (in_array($network, $this->tvs) && in_array($platform, $this->cable_platforms[$network])) {

                $current_platform = $this->functions->getVtuPlatformToUse('cable', $network);
                $response['current_platform'] = $current_platform;
                
                $data_plan = CablePlan::where('network', $network)->get();
                if ($data_plan->count() == 1) {
                    $data_plan = $data_plan[0];
                    $modify_prices_status = $request->has('temp') ? $request->modify_prices_status : $data_plan->modify_prices;
                    $price_alteration_option = $request->has('temp') ? $request->price_alteration_option : $data_plan->price_alteration_option;
                    $percentage = $request->has('temp') ? $request->percentage : $data_plan->percentage;
                    $added_amount = $request->has('temp') ? $request->added_amount : $data_plan->added_amount;

                    $response['modify_prices_status'] = $modify_prices_status;
                    $response['price_alteration_option'] = $price_alteration_option;
                    $response['percentage'] = $percentage;
                    $response['added_amount'] = $added_amount;

                    if ($modify_prices_status == "yes") {
                        //Get plans for this particular platform with old price and new price depending on price alteration option


                        $options = (object) [
                            'price_alteration_option' => $price_alteration_option,
                            'percentage' => $percentage,
                            'added_amount' => $added_amount,
                        ];

                        $platform_to_use = $request->has('platform_changed') ? $platform : $current_platform;
                        // return $platform_to_use;
                        $plans = $this->functions->getCablePlansForEditing($network, $platform_to_use, $options);

                        if (count($plans) > 0) {

                            $response['plans'] = $plans;
                        }
                    }
                    $response['success'] = true;
                }
            }
        }

        return $response;
    }

    public function loadAllVtuHistory(Request $request)
    {

        $user = Auth::user();
        $user = User::find($user->id);


        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");
        $length = empty($length) ? 10 : $length;

        

        $history = VtuTransaction::where('vtu_transactions.id', '!=', 0);


        $history = $history->join('users as j', 'vtu_transactions.user_id', '=', 'j.id')->addSelect('j.name')->addSelect('j.user_name')->addSelect('j.email');

        

        $history = $history->addSelect('vtu_transactions.*');

        $history = $request->has('name') ? $history->where('j.name', 'like', '%' . $request->query('name') . '%') : $history;
        $history = $request->has('user_name') ? $history->where('j.user_name', 'like', '%' . $request->query('user_name') . '%') : $history;
        $history = $request->has('type') ? $history->where('type', 'like', '%' . $request->query('type') . '%') : $history;
        $history = $request->has('sub_type') ? $history->where('sub_type', 'like', '%' . $request->query('sub_type') . '%') : $history;
        $history = $request->has('order_id') ? $history->where('order_id', 'like', '%' . $request->query('order_id') . '%') : $history;
        $history = $request->has('number') ? $history->where('number', 'like', '%' . $request->query('number') . '%') : $history;
        $history = $request->has('amount') ? $history->where('amount', 'like', '%' . $request->query('amount') . '%') : $history;

        

        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('vtu_transactions.date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('vtu_transactions.created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("vtu_transactions.id", "DESC")
        ->paginate($length)->withQueryString();


        // $history = $history->orderBy("id", "DESC")
        // ->toRawSql();


        return $history;
    }


    public function saveElectricitySettings(Request $request, User $user)
    {
        $response = ['success' => false];


        $request->validate([
            'platform' => ['required', Rule::in($this->electricity_platforms)],
        ]);

        $platform = $request->platform;

        $this->functions->setCurrentPlatform('', 'electricity', $platform);
        $response['success'] = true;
        

        return back()->with('data', $response);
    }

    public function loadElectricityDetailsByNetwork(Request $request, User $user)
    {
        $response = ['success' => false, 'current_platform' => ''];

        if ($request->has('platform')) {
            $platform = $request->platform;

            if (in_array($platform, $this->electricity_platforms)) {

                $current_platform = $this->functions->getVtuPlatformToUse('', 'electricity');
                $response['current_platform'] = $current_platform;
                $response['success'] = true;
                
            }
        }

        return $response;
    }


    public function saveAirtimeSettings(Request $request, User $user)
    {
        $response = ['success' => false];


        $request->validate([
            'network' => ['required', Rule::in($this->networks)],
            'platform' => ['required', Rule::in($this->airtime_platforms[strtolower($request->network)])],
            'discount' => 'nullable|numeric|max:100',
            
        ]);

        $platform = $request->platform;

        $this->functions->setCurrentPlatform('airtime', $request->network, $platform);

        $airtime_plan = AirtimeTopup::where('network', $request->network)->get();
        if ($airtime_plan->count() == 1) {
            $airtime_plan = AirtimeTopup::find($airtime_plan[0]->id);



            $airtime_plan->discount = $request->discount;
            $airtime_plan->save();

            $response['success'] = true;
        }

        return back()->with('data', $response);
    }

    public function loadAirtimeDetailsByNetwork(Request $request, User $user)
    {
        $response = ['success' => false, 'current_platform' => '', 'discount' => 0.00];

        if ($request->has('network') && $request->has('platform')) {
            $network = $request->network;
            $platform = $request->platform;

            if (in_array($network, $this->networks) && in_array($platform, $this->airtime_platforms[$network])) {

                $current_platform = $this->functions->getVtuPlatformToUse('airtime', $network);
                $response['current_platform'] = $current_platform;
               
                $airtime_plan = AirtimeTopup::where('network', $network)->get();
                if ($airtime_plan->count() == 1) {
                    $airtime_plan = $airtime_plan[0];
                    
                    $discount = $airtime_plan->discount;

                    
                    $response['discount'] = $discount;
                    $response['success'] = true;
                }
            }
        }

        return $response;
    }

    
    public function saveDataPlansSettings(Request $request, User $user)
    {
        $response = ['success' => false];
        

        $request->validate([
            'network' => ['required', Rule::in($this->networks)],
            'platform' => ['required', Rule::in($this->data_platforms[strtolower($request->network)])],
            'modify_prices_status' => 'required|in:yes,no',
            'price_alteration_option' => 'required|in:percentage,direct',
            'percentage' => 'nullable|numeric|max:100',
            'added_amount' => 'nullable|numeric',
        ]);

        $platform = $request->platform;

        $this->functions->setCurrentPlatform('data', $request->network, $platform);

        $data_plan = DataPlan::where('network', $request->network)->get();
        if ($data_plan->count() == 1) {
            $data_plan = DataPlan::find($data_plan[0]->id);

            

            $data_plan->modify_prices = $request->modify_prices_status;
            $data_plan->price_alteration_option = $request->price_alteration_option;
            $data_plan->percentage = $request->percentage;
            $data_plan->added_amount = $request->added_amount;

            if($data_plan->modify_prices == 'yes' && $data_plan->price_alteration_option == 'direct'){
                $prices_details = $data_plan->details;

                if($request->has('plans')){
                    $plans = $request->plans;
                    if(count($plans) > 0){
                        $plans_arr = [];
                        foreach($plans as $plan){
                            $name = $plan['name'];
                            $product_id = $plan['product_id'];
                            $old_price = $plan['old_price'];
                            $new_price = (float) $plan['new_price'];

                            
                            // $preset_plans = json_decode(json_encode($preset_plans));
                            // dd($preset_plans);

                            $plans_arr[] = [
                                'name' => $name,
                                'product_id' => $product_id,
                                'price' => $new_price,
                            ];
                            
                        }

                        
                        $preset_plans = json_decode($prices_details);
                        foreach ($preset_plans as $plan) {
                            if (isset($plan->$platform)) {

                                $plan->$platform = $plans_arr;
                            }
                        }

                        $data_plan->details = json_encode($preset_plans);
                    }
                }
            }

            $data_plan->save();
        }

        $response['success'] = true;

        return back()->with('data', $response);
    }
    
    public function loadDataPlanDetailsByNetwork(Request $request, User $user)
    {
        $response = ['success' => false, 'current_platform' => '', 'gsubz' => false, 'modify_prices_status' => false, 'percentage' => 0, 'added_amount' => 0, 'plans' => []];

        if($request->has('network') && $request->has('platform')){
            $network = $request->network;
            $platform = $request->platform;

            if(in_array($network, $this->networks) && in_array($platform, $this->data_platforms[$network])){

                $current_platform = $this->functions->getVtuPlatformToUse('data', $network);
                $response['current_platform'] = $current_platform;
                if(substr($platform, 0, 5) == "gsubz"){
                    $response['gsubz'] = true;

                    // $platform = substr($platform, 6);
                }

                $data_plan = DataPlan::where('network', $network)->get();
                if($data_plan->count() == 1){
                    $data_plan = $data_plan[0];
                    $modify_prices_status = $request->has('temp') ? $request->modify_prices_status : $data_plan->modify_prices;
                    $price_alteration_option = $request->has('temp') ? $request->price_alteration_option : $data_plan->price_alteration_option;
                    $percentage = $request->has('temp') ? $request->percentage : $data_plan->percentage;
                    $added_amount = $request->has('temp') ? $request->added_amount : $data_plan->added_amount;

                    $response['modify_prices_status'] = $modify_prices_status;
                    $response['price_alteration_option'] = $price_alteration_option;
                    $response['percentage'] = $percentage;
                    $response['added_amount'] = $added_amount;

                    if($modify_prices_status == "yes"){
                        //Get plans for this particular platform with old price and new price depending on price alteration option

                        
                        $options = (Object) [
                            'price_alteration_option' => $price_alteration_option,
                            'percentage' => $percentage,
                            'added_amount' => $added_amount,
                        ];

                        $platform_to_use = $request->has('platform_changed') ? $platform : $current_platform;
                        $plans = $this->functions->getDataPlansForEditing($network, $platform_to_use, $options);

                        if(count($plans) > 0){
                            
                            $response['plans'] = $plans;
                        }
                    }
                    $response['success'] = true;
                    
                }
                
            }
        }

        return $response;
    }


    public function loadUsersEarningsWalletPage(Request $request, User $user)
    {
        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        $history = $user->earningsHistory()->orderBy("id", "DESC");

        $history = $request->query('amount') ? $history->where('amount', 'like', '%' . $request->query('amount') . '%') : $history;
        $history = $request->query('balance') ? $history->where('balance', 'like', '%' . $request->query('balance') . '%') : $history;

        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('created_at', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;


        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->paginate($length);

        
        // return $history;


        $props['history'] = $history;
        $props['length'] = $length;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;
        $props['balance'] = $request->query('balance') ? $request->query('balance') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;

        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;


        // return Inertia::render('Earnings/MainPage', $props);



        return Inertia::render("Admin/UsersEarningsWallet", $props);
    }

    public function loadAdminGoEasySavingsPage(Request $request){

        $total_amount_of_current_savings = 0;
        $total_amount_disbursed = 0;
        $total_amount_saved_so_far = 0;
        $savings = new EasySavings;
        $current_savings = $savings->where('disbursed', 0)->select('id','total_amount_debited_so_far')->get();
        $disbursed_savings = $savings->where('disbursed', 1)->select('id', 'amount_disbursed')->get();
        $total_savings = $savings->where('id','!=', 0)->select('id', 'total_amount_debited_so_far')->get();
        $props['figures']['number_of_current_savings'] = $current_savings->count();
        if($current_savings->count() > 0){
            foreach($current_savings as $row){
                $total_amount_of_current_savings += $row->total_amount_debited_so_far;
            }
        }
        $props['figures']['total_amount_of_current_savings'] = $total_amount_of_current_savings;

        $props['figures']['number_of_disbursed_savings'] = $disbursed_savings->count();
        if ($disbursed_savings->count() > 0) {
            foreach ($disbursed_savings as $row) {
                $total_amount_disbursed += $row->amount_disbursed;
            }
        }
        $props['figures']['total_amount_disbursed'] = $total_amount_disbursed;

        $props['figures']['total_no_savings'] = $total_savings->count();
        if ($total_savings->count() > 0) {
            foreach ($total_savings as $row) {
                $total_amount_saved_so_far += $row->total_amount_debited_so_far;
            }
        }
        $props['figures']['total_amount_saved_so_far'] = $total_amount_saved_so_far;
        
        $props['user'] = Auth::user();
        // return $props;
        return Inertia::render('Admin/GoeasyPage',$props);
    }

    public function showUsersSavingsAutoWithdHistoryPage(Request $request, User $user){
        $props['user'] = $user;

        $page = $request->query('page');

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        $history = $user->savingsAutoWithdrawalHistory()->orderBy("id", "DESC");

        $history = $request->query('amount') ? $history->where('amount', 'like', '%' . $request->query('amount') . '%') : $history;

        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('created_at', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;


        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->paginate($length);

        foreach ($history as $row) {
            $newtime = strtotime($row->created_at);
            $row->date_time = date('j M Y h:i:sa', $newtime);
        }

        // return $history;


        $props['history'] = $history;
        $props['length'] = $length;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;


        $props['date'] = $request->query('date') ? $request->query('date') : NULL;

        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;


        return Inertia::render('Admin/UsersSavingsWithdrawalHistory', $props);
    }

    public function showUsersSavingsHistoryPage(Request $request, User $user){
        $props['user'] = $user;

        $user_id = $user->id;
        $page = $request->query('page');

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        $status_prop = $request->query("status");
        $status_prop = empty($status_prop) ? 'all' : $status_prop;

        $j = 0;


        // $savings = EasySavings::where('user_id',$user_id);
        $user = User::find($user_id);
        $savings = $user->savings();


        $savings = $savings->join('savings_frequencies as frequency', 'easy_savings.savings_frequency_id', '=', 'frequency.id')->addSelect('frequency.label as frequency_label');

        $savings = $savings->join('savings_durations as duration', 'easy_savings.savings_duration_id', '=', 'duration.id')->addSelect('duration.label as duration_label');


        $savings = $savings->addSelect('easy_savings.*');

        $savings = $request->query('amount') ? $savings->where('easy_savings.amount', 'like', '%' . $request->query('amount') . '%') : $savings;


        if ($status_prop == "pending") {
            $savings = $savings->where('disbursed', 0);
        } else if ($status_prop == "disbursed") {
            $savings = $savings->where('disbursed', 1)->where('cause_of_disbursement', '!=', 'user deactivation');
        } else if ($status_prop == "deactivated") {
            $savings = $savings->where('disbursed', 1)->where('cause_of_disbursement', 'user deactivation');
        }

        $savings = $request->query('frequency') ? $savings->where('frequency.label', 'like', '%' . $request->query('frequency') . '%') : $savings;
        $savings = $request->query('duration') ? $savings->where('duration.label', 'like', '%' . $request->query('duration') . '%') : $savings;

        $savings = !empty($request->query('date')) && $request->query('date') != "" ? $savings->where('easy_savings.start_date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $savings;

        $savings = !empty($request->query('projected_end_date')) && $request->query('projected_end_date') != "" ? $savings->where('easy_savings.end_of_savings_date', 'like', date("j M Y", strtotime($request->query('projected_end_date')))  . '%') : $savings;


        $savings = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $savings->whereBetween('easy_savings.created_at', [$request->query('start_date'), $request->query('end_date')]) : $savings;

        $savings = $savings->paginate($length);

        $props['savings'] = $savings;
        $props['length'] = $length;
        $props['frequency'] = $request->query('frequency') ? $request->query('frequency') : NULL;
        $props['duration'] = $request->query('duration') ? $request->query('duration') : NULL;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;


        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['projected_end_date'] = $request->query('projected_end_date') ? $request->query('projected_end_date') : NULL;

        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;

        $props['status'] = $status_prop;

        return Inertia::render('Admin/UsersSavingsHistory', $props);
    }

    public function showSavingsDebitHistoryPage(Request $request, User $user, EasySavings $easySaving){
        $props['user'] = $user;
        $saving_id = $easySaving->id;
        
        $page = $request->query('page');

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        if ($user->id == $easySaving->user_id) {

            $history = $easySaving->debitHistory()->orderBy('id', 'desc');

            $history = $request->query('amount') ? $history->where('amount', 'like', '%' . $request->query('amount') . '%') : $history;

            $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('created_at', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;


            $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



            $history = $history->paginate($length);

            foreach ($history as $row) {
                $newtime = strtotime($row->created_at);
                $row->date_time = date('j M Y h:i:sa', $newtime);
            }

            // return $history;

            $props['saving_id'] = $saving_id;
            $props['history'] = $history;
            $props['length'] = $length;
            $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;


            $props['date'] = $request->query('date') ? $request->query('date') : NULL;

            $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
            $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;


            return Inertia::render('Admin/UsersSavingDebitHistory', $props);
        }
    }

    public function showUsersSavingDetailsPage(Request $request, User $user, EasySavings $easySaving){
        $props['user'] = $user;

        $saving_id = $easySaving->id;

        if ($user->id == $easySaving->user_id) {
            $easySaving = $easySaving->join('savings_frequencies as frequency', 'easy_savings.savings_frequency_id', '=', 'frequency.id')->addSelect('frequency.label as frequency');

            $easySaving = $easySaving->join('savings_durations as duration', 'easy_savings.savings_duration_id', '=', 'duration.id')->addSelect('duration.label as duration');


            $easySaving = $easySaving->addSelect('easy_savings.*');

            $easySaving = $easySaving->where('easy_savings.id', $saving_id);
            $easySaving = $easySaving->first();

            if ($easySaving->disbursed == 0) {
                $easySaving->status = "pending";
            } else if ($easySaving->disbursed == 1 && $easySaving->cause_of_disbursement != "user deactivation") {
                $easySaving->status = "disbursed";
            } else if ($easySaving->disbursed == 1 && $easySaving->cause_of_disbursement == "user deactivation") {
                $easySaving->status = "deactivated";
            }



            $props['saving'] = $easySaving;
            // return $easySaving;
            return Inertia::render('Admin/UsersSavingDetail', $props);
        }
    }

    public function showUsersSavingsMainPage(Request $request,User $user){
        $props['user'] = $user;
        
        $props['has_current_savings'] = $this->functions->checkIfUserHasAnyCurrentSavingsOn($user->id);
        $saving = EasySavings::where('user_id', $user->id)->where('disbursed', 0)->first();
        $props['saving_id'] = is_null($saving) ? 0 : $saving->id;

        return Inertia::render('Admin/UsersSavingsMainPage', $props);
    }
    
    public function loadUsersEasyLoanHistoryPage(Request $request, User $user)
    {
        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        


        $j = 0;
        $history = EasyLoan::where('user_id', $user->id);

        $history = $request->query('amount') ? $history->where('amount', 'like', '%' . $request->query('amount') . '%') : $history;
        $history = $request->query('amount_paid') ? $history->where('amount_paid', 'like', '%' . $request->query('amount_paid') . '%') : $history;

        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('last_date_paid')) && $request->query('last_date_paid') != "" ? $history->where('date', 'like', date("Y-m-d", strtotime($request->query('last_date_paid')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();

        if ($history->count() > 0) {
            foreach ($history as $row) {
                $amount = $row->amount;
                $amount_paid = $row->amount_paid;
                $last_date_paid = $row->last_date_paid;
                $paid_off = $row->paid_off;
                $created_at = $row->created_at;
                $row->date = date("j M Y", strtotime($created_at));
                $row->last_date_paid = date("j M Y", strtotime($last_date_paid));

                $row->status = $paid_off == 1 ? 'Cleared' : 'Pending';
                $row->amount_owed = 0;
                if ($paid_off == 0) {
                    $start_date = $created_at;
                    $start_date = date("j M Y", strtotime($start_date));
                    $start_date = strtotime($start_date);
                    $end_date = strtotime(date("j M Y"));



                    $date_diff = ($end_date - $start_date) / 60 / 60 / 24;

                    $weeks_num = $date_diff / 7;

                    $weeks_num = (int) $weeks_num;
                    $charged_weeks = $weeks_num - 4;
                    if ($charged_weeks < 0) {
                        $charged_weeks = 0;
                    }
                    $total_service_charge = 250 * $charged_weeks;

                    $total_amount_payable = $amount + $total_service_charge;
                    $row->amount_owed = $total_amount_payable - $amount_paid;
                }
            }
        }

        // return $history;

        $props['history'] = $history;
        $props['length'] = $length;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;
        $props['amount_paid'] = $request->query('amount_paid') ? $request->query('amount_paid') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['last_date_paid'] = $request->query('last_date_paid') ? $request->query('last_date_paid') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;


        // return $wallet_statement;


        return Inertia::render("Admin/UsersLoanHistory", $props);
    }

    public function loadUsersEarningsToWalletHistoryPage(Request $request, User $user)
    {
        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        $history = $user->earningToWalletHist();



        $history = $request->query('amount') ? $history->where('amount', 'like', '%' . $request->query('amount') . '%') : $history;

        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();




        // return $history;


        $props['history'] = $history;
        $props['length'] = $length;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;



        return Inertia::render("Admin/UsersEarningsToWalletHist", $props);
    }

    public function loadDownlineMembersPage(Request $request)
    {
        $user = Auth::user();
        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        $history = MlmDb::where('mlm_db.id','!=', 1);


        $history = $history->join('users', 'mlm_db.user_id', '=', 'users.id')->addSelect('users.name as name')->addSelect('users.email as email');

        

        $history = $history->addSelect('mlm_db.*');

        $history = $request->query('name') ? $history->where('users.name', 'like', '%' . $request->query('name') . '%') : $history;
        $history = $request->query('email') ? $history->where('users.email', 'like', '%' . $request->query('email') . '%') : $history;

        $history = $request->query('level') && $request->query('level') >= 1  ? $history->where('mlm_db.stage', $request->query('level')) : $history;


        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('mlm_db.date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('mlm_db.created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("stage", "ASC")
            ->paginate($length)->withQueryString();


        if (is_object($history)) {
            $j = 0;
            foreach ($history as $row) {



                $j++;

                // $index = $j + (($page - 1) * $length);

                $id = $row->id;
                $user_id = $row->user_id;
                

                $date_created = $row->date_created;
                $time_created = $row->time_created;
                $stage = $row->stage;
                $level = $stage;
                $under = $row->under;
                $sponsor = $row->sponsor;
                $positioning = $row->positioning;
                
                $row->level_str = number_format($level);

                
                $placement_user_id = $this->functions->getMlmDbParamById("user_id", $under);
                
                $row->placement_name = $this->functions->getUserParamById("name", $placement_user_id);
                $row->placement_email = $this->functions->getUserParamById("email", $placement_user_id);
                $row->placement_name = $row->placement_name . " (" . $positioning . ")";
                // $row->placement_email = $row->placement_email . " (" . $positioning . ")";


                $sponsor_user_id = $this->functions->getMlmDbParamById("user_id", $sponsor);

                $row->sponsor_name = $this->functions->getUserParamById("name", $sponsor_user_id);
                $row->sponsor_email = $this->functions->getUserParamById("email", $sponsor_user_id);
                
                // $row->index = $index;
            }
        }

        // return $history;



        $props['history'] = $history;
        $props['length'] = $length;

        $props['name'] = $request->query('name') ? $request->query('name') : NULL;

        $props['email'] = $request->query('email') ? $request->query('email') : NULL;
        $props['level'] = $request->query('level') ? $request->query('level') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;

        $props['total_downline_num'] = number_format($this->functions->getTotalNumberOfDownlineInMlmSystem());
        $props['total_levels'] = number_format($this->functions->getNumberOfLevelsInMlmSystem());


        
        return Inertia::render('Admin/DownlineMembers', $props);
    }

    public function loadUsersVtuHistoryPage(Request $request, User $user)
    {

        $props['user'] = $user;




        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;


        $j = 0;
        $user_id = $user->id;
        $history = VtuTransaction::where('user_id', $user_id);


        $history = $request->query('type') ? $history->where('type', 'like', '%' . $request->query('type') . '%') : $history;
        $history = $request->query('sub_type') ? $history->where('sub_type', 'like', '%' . $request->query('sub_type') . '%') : $history;
        $history = $request->query('order_id') ? $history->where('order_id', 'like', '%' . $request->query('order_id') . '%') : $history;
        $history = $request->query('number') ? $history->where('number', 'like', '%' . $request->query('number') . '%') : $history;



        $history = $request->query('amount') ? $history->where('amount', 'like', '%' . $request->query('amount') . '%') : $history;

        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();



        $props['history'] = $history;
        $props['length'] = $length;

        $props['type'] = $request->query('type') ? $request->query('type') : NULL;
        $props['sub_type'] = $request->query('sub_type') ? $request->query('sub_type') : NULL;
        $props['order_id'] = $request->query('order_id') ? $request->query('order_id') : NULL;

        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;


        // return $history;


        return Inertia::render("Admin/UsersVTUHistory", $props);
    }

    public function loadAccountDeditHistoryPage(Request $request)
    {
        $user = Auth::user();
        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        $history = AdminDebitUsersHistory::where('user_id', '!=', '0');


        $history = $history->join('users', 'admin_debit_users_history.user_id', '=', 'users.id')->addSelect('users.name as name')->addSelect('users.email as email');
        $history = $history->addSelect('admin_debit_users_history.*');

        $history = $request->query('name') ? $history->where('users.name', 'like', '%' . $request->query('name') . '%') : $history;
        $history = $request->query('email') ? $history->where('users.email', 'like', '%' . $request->query('email') . '%') : $history;

        $history = $request->query('amount') ? $history->where('admin_debit_users_history.amount', 'like', '%' . $request->query('amount') . '%') : $history;


        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('admin_debit_users_history.date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('admin_debit_users_history.created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();




        // return $history;



        $props['history'] = $history;
        $props['length'] = $length;

        $props['name'] = $request->query('name') ? $request->query('name') : NULL;

        $props['email'] = $request->query('email') ? $request->query('email') : NULL;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;



        return Inertia::render("Admin/AdminAccountDebitHistory", $props);
    }

    public function loadAdminAccountCreditHistoryPage(Request $request)
    {
        $user = Auth::user();
        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        $history = AdminFundUsersHistory::where('user_id','!=','0');


        $history = $history->join('users', 'admin_fund_users_history.user_id', '=', 'users.id')->addSelect('users.name as name')->addSelect('users.email as email');
        $history = $history->addSelect('admin_fund_users_history.*');

        $history = $request->query('name') ? $history->where('users.name', 'like', '%' . $request->query('name') . '%') : $history;
        $history = $request->query('email') ? $history->where('users.email', 'like', '%' . $request->query('email') . '%') : $history;

        $history = $request->query('amount') ? $history->where('admin_fund_users_history.amount', 'like', '%' . $request->query('amount') . '%') : $history;
        

        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('admin_fund_users_history.date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('admin_fund_users_history.created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();




        // return $history;

        

        $props['history'] = $history;
        $props['length'] = $length;

        $props['name'] = $request->query('name') ? $request->query('name') : NULL;

        $props['email'] = $request->query('email') ? $request->query('email') : NULL;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;



        return Inertia::render("Admin/AdminAccountCreditHistory", $props);
    }

    public function loadAccountCreditHistoryPage(Request $request)
    {
        $user = Auth::user();
        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        $history = AccountCreditHistory::where('user_id','!=','0');


        $history = $history->join('users', 'account_credit_history.user_id', '=', 'users.id')->addSelect('users.name as name')->addSelect('users.email as email');
        $history = $history->addSelect('account_credit_history.*');

        $history = $request->query('name') ? $history->where('users.name', 'like', '%' . $request->query('name') . '%') : $history;
        $history = $request->query('email') ? $history->where('users.email', 'like', '%' . $request->query('email') . '%') : $history;

        $history = $request->query('amount') ? $history->where('account_credit_history.amount', 'like', '%' . $request->query('amount') . '%') : $history;
        $history = $request->query('payment_option') ? $history->where('account_credit_history.payment_option', 'like', '%' . $request->query('payment_option') . '%') : $history;
        $history = $request->query('reference') ? $history->where('account_credit_history.reference', 'like', '%' . $request->query('reference') . '%') : $history;

        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('account_credit_history.date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('account_credit_history.created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();




        // return $history;

        

        $props['history'] = $history;
        $props['length'] = $length;

        $props['name'] = $request->query('name') ? $request->query('name') : NULL;

        $props['email'] = $request->query('email') ? $request->query('email') : NULL;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;

        $props['payment_option'] = $request->query('payment_option') ? $request->query('payment_option') : NULL;
        $props['reference'] = $request->query('reference') ? $request->query('reference') : NULL;
        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;



        return Inertia::render("Admin/AccountCreditHistory", $props);
    }

    public function loadDataComboRechargeHistoryPage(Request $request)
    {
        $user = Auth::user();
        $props['user'] = $user;



        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;


        $j = 0;

        $requests = ComboRechargeVtu::where('credited', 1)->where('amount', 'like', "%GB");


        $requests = $requests->join('users', 'combo_recharge_vtu.user_id', '=', 'users.id')->addSelect('users.name as name')->addSelect('users.email as email');



        $requests = $requests->addSelect('combo_recharge_vtu.*');


        $requests = $request->query('name') ? $requests->where('users.name', 'like', '%' . $request->query('name') . '%') : $requests;
        $requests = $request->query('email') ? $requests->where('users.email', 'like', '%' . $request->query('email') . '%') : $requests;



        $requests = $request->query('amount') ? $requests->where('combo_recharge_vtu.amount', 'like', '%' . $request->query('amount') . '%') : $requests;
        $requests = $request->query('number') ? $requests->where('combo_recharge_vtu.number', 'like', '%' . $request->query('number') . '%') : $requests;

        $requests = !empty($request->query('date')) && $request->query('date') != "" ? $requests->where('combo_recharge_vtu.date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $requests;

        $requests = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $requests->whereBetween('combo_recharge_vtu.created_at', [$request->query('start_date'), $request->query('end_date')]) : $requests;

        $requests = !empty($request->query('credited_date')) && $request->query('credited_date') != "" ? $requests->where('combo_recharge_vtu.credited_date', 'like', date("j M Y", strtotime($request->query('credited_date')))  . '%') : $requests;


        $requests = $requests->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();



        $props['requests'] = $requests;
        $props['length'] = $length;

        $props['name'] = $request->query('name') ? $request->query('name') : NULL;

        $props['email'] = $request->query('email') ? $request->query('email') : NULL;


        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;
        $props['number'] = $request->query('number') ? $request->query('number') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['credited_date'] = $request->query('credited_date') ? $request->query('credited_date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;



        return Inertia::render("Admin/DataComboHistory", $props);
    }

    public function loadDataComboRequestsPage(Request $request)
    {
        $user = Auth::user();
        $props['user'] = $user;



        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;


        $j = 0;

        $requests = ComboRechargeVtu::where('credited', 0)->where('amount', 'like', "%GB");


        $requests = $requests->join('users', 'combo_recharge_vtu.user_id', '=', 'users.id')->addSelect('users.name as name')->addSelect('users.email as email');



        $requests = $requests->addSelect('combo_recharge_vtu.*');


        $requests = $request->query('name') ? $requests->where('users.name', 'like', '%' . $request->query('name') . '%') : $requests;
        $requests = $request->query('email') ? $requests->where('users.email', 'like', '%' . $request->query('email') . '%') : $requests;



        $requests = $request->query('amount') ? $requests->where('combo_recharge_vtu.amount', 'like', '%' . $request->query('amount') . '%') : $requests;
        $requests = $request->query('number') ? $requests->where('combo_recharge_vtu.number', 'like', '%' . $request->query('number') . '%') : $requests;

        $requests = !empty($request->query('date')) && $request->query('date') != "" ? $requests->where('combo_recharge_vtu.date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $requests;

        $requests = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $requests->whereBetween('combo_recharge_vtu.created_at', [$request->query('start_date'), $request->query('end_date')]) : $requests;



        $requests = $requests->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();



        $props['requests'] = $requests;
        $props['length'] = $length;

        $props['name'] = $request->query('name') ? $request->query('name') : NULL;

        $props['email'] = $request->query('email') ? $request->query('email') : NULL;


        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;
        $props['number'] = $request->query('number') ? $request->query('number') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;



        return Inertia::render("Admin/DataComboRequests", $props);
    }

    public function loadAirtimeComboRechargeHistoryPage(Request $request)
    {
        $user = Auth::user();
        $props['user'] = $user;



        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;


        $j = 0;

        $requests = ComboRechargeVtu::where('credited', 1)->where('amount', 'not like', "%GB");


        $requests = $requests->join('users', 'combo_recharge_vtu.user_id', '=', 'users.id')->addSelect('users.name as name')->addSelect('users.email as email');



        $requests = $requests->addSelect('combo_recharge_vtu.*');


        $requests = $request->query('name') ? $requests->where('users.name', 'like', '%' . $request->query('name') . '%') : $requests;
        $requests = $request->query('email') ? $requests->where('users.email', 'like', '%' . $request->query('email') . '%') : $requests;



        $requests = $request->query('amount') ? $requests->where('combo_recharge_vtu.amount', 'like', '%' . $request->query('amount') . '%') : $requests;
        $requests = $request->query('number') ? $requests->where('combo_recharge_vtu.number', 'like', '%' . $request->query('number') . '%') : $requests;

        $requests = !empty($request->query('date')) && $request->query('date') != "" ? $requests->where('combo_recharge_vtu.date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $requests;

        $requests = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $requests->whereBetween('combo_recharge_vtu.created_at', [$request->query('start_date'), $request->query('end_date')]) : $requests;

        $requests = !empty($request->query('credited_date')) && $request->query('credited_date') != "" ? $requests->where('combo_recharge_vtu.credited_date', 'like', date("j M Y", strtotime($request->query('credited_date')))  . '%') : $requests;


        $requests = $requests->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();



        $props['requests'] = $requests;
        $props['length'] = $length;

        $props['name'] = $request->query('name') ? $request->query('name') : NULL;

        $props['email'] = $request->query('email') ? $request->query('email') : NULL;


        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;
        $props['number'] = $request->query('number') ? $request->query('number') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['credited_date'] = $request->query('credited_date') ? $request->query('credited_date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;



        return Inertia::render("Admin/AirtimeComboHistory", $props);
    }


    public function markComboRecordAsRecharged(Request $request)
    {
        $date = date("j M Y");
        $time = date("h:i:sa");
        
        $response_arr = ['success' => false];
        if ($request->id) {
            $id = $request->id;

            $combo_recharge = ComboRechargeVtu::find($id);
            $combo_recharge->credited = 1;
            $combo_recharge->credited_date = $date;
            $combo_recharge->credited_time = $time;

            $combo_recharge->save();

            
            $response_arr['success'] = true;
            
        }


        return back()->with('data', $response_arr);
    } 

    public function loadAirtimeComboRequestsPage(Request $request)
    {
        $user = Auth::user();
        $props['user'] = $user;

        

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;


        $j = 0;

        $requests = ComboRechargeVtu::where('credited', 0)->where('amount', 'not like', "%GB");


        $requests = $requests->join('users', 'combo_recharge_vtu.user_id', '=', 'users.id')->addSelect('users.name as name')->addSelect('users.email as email');

       

        $requests = $requests->addSelect('combo_recharge_vtu.*');


        $requests = $request->query('name') ? $requests->where('users.name', 'like', '%' . $request->query('name') . '%') : $requests;
        $requests = $request->query('email') ? $requests->where('users.email', 'like', '%' . $request->query('email') . '%') : $requests;



        $requests = $request->query('amount') ? $requests->where('combo_recharge_vtu.amount', 'like', '%' . $request->query('amount') . '%') : $requests;
        $requests = $request->query('number') ? $requests->where('combo_recharge_vtu.number', 'like', '%' . $request->query('number') . '%') : $requests;

        $requests = !empty($request->query('date')) && $request->query('date') != "" ? $requests->where('combo_recharge_vtu.date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $requests;

        $requests = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $requests->whereBetween('combo_recharge_vtu.created_at', [$request->query('start_date'), $request->query('end_date')]) : $requests;



        $requests = $requests->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();



        $props['requests'] = $requests;
        $props['length'] = $length;
        
        $props['name'] = $request->query('name') ? $request->query('name') : NULL;
        
        $props['email'] = $request->query('email') ? $request->query('email') : NULL;
        

        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;
        $props['number'] = $request->query('number') ? $request->query('number') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;



        return Inertia::render("Admin/AirtimeComboRequests", $props);
    }

    public function dismissAccountCreditWithdrawal(Request $request)
    {
        $date = date("j M Y");
        $time = date("h:i:sa");
        

        $response_arr = ['success' => false];
        if ($request->id) {
            $id = $request->id;

            
            $withdrawal_request = WithdrawalRequest::find($id);

            $withdrawal_request->dismissed = 1;
            $withdrawal_request->dismissed_date_time = $date . " " . $time;
            $withdrawal_request->save();

            $summary = "Refund For Withdrawal Request Dismissal";
            $amount = $withdrawal_request->amount + 100;
            if ($this->functions->creditUser($withdrawal_request->user_id, $amount, $summary)) {
                $response_arr['success'] = true;
            }
            
        }

        return back()->with('data', $response_arr);
    } 

    public function verifyAccountCreditWithdrawal(Request $request)
    {
        $date = date("j M Y");
        $time = date("h:i:sa");
        

        $response_arr = ['success' => false];

        if ($request->id) {
            $id = $request->id;
            
            $withdrawal_request = WithdrawalRequest::find($id);
            $user_id = $withdrawal_request->user_id;

            $withdrawal_request->debited = 1;
            $withdrawal_request->debited_date_time = $date . " " . $time;
            $withdrawal_request->save();

            $steps = 24;

            $charge_id = 15;
            $summary = 'Upteam Earning';
            $income = $this->functions->getWithdrawalEarningAmt();



            $ids_to_credit = $this->functions->getIdsToCreditUpteam($user_id, $steps);
            $ids_to_credit_num = count($ids_to_credit);
            for ($i = 0; $i < count($ids_to_credit); $i++) {
                $placements_user_id = $ids_to_credit[$i];
                $placements_mlm_db_id = $this->functions->getUsersFirstMlmDbId($placements_user_id);


                MlmEarning::create([
                    'user_id' => $placements_user_id,
                    'mlm_db_id' => $placements_mlm_db_id,
                    'type' => $charge_id,
                    'amount' => $income,
                    'date' => $date,
                    'time' => $time,
                ]);



                $this->functions->creditUser($placements_user_id, $income, $summary);
            }

            
            if ($this->functions->addWithrawalHistory($withdrawal_request->user_id, $withdrawal_request->amount)) {
                $response_arr['success'] = true;
            }
            
        }


        return back()->with('data', $response_arr);
    } 
    

    public function loadAccountWithdrawalRequestsPage(Request $request)
    {
        $user = Auth::user();
        $props['user'] = $user;

        $role_prop = $request->query("role");
        $role_prop = empty($role_prop) ? 'pending' : $role_prop;


        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;


        $j = 0;
        
        $requests = WithdrawalRequest::where(function ($query) use ($role_prop) {

            if ($role_prop == "dismissed") {
                $query->where('debited', 0)
                ->where('dismissed', 1);
            } else if ($role_prop == "debited") {
                $query->where('debited', 1)
                ->where('dismissed', 0);
            } else if ($role_prop == "pending") {
                $query->where('debited', 0)
                ->where('dismissed', 0);
            }else{
                $query->where('debited', 0)
                    ->where('dismissed', 0);
            }
        });


        $requests = $requests->join('users', 'withdrawal_request.user_id', '=', 'users.id')->addSelect('users.name as name')->addSelect('users.phone as phone')->addSelect('users.country_id as country_id')->addSelect('users.email as email');

        $requests = $requests->join('countries', 'users.country_id', '=', 'countries.id')->addSelect('countries.name as country_name');


        $requests = $requests->addSelect('withdrawal_request.*');


        $requests = $request->query('name') ? $requests->where('users.name', 'like', '%' . $request->query('name') . '%') : $requests;
        $requests = $request->query('phone') ? $requests->where('users.phone', 'like', '%' . $request->query('phone') . '%') : $requests;
        $requests = $request->query('email') ? $requests->where('users.email', 'like', '%' . $request->query('email') . '%') : $requests;
        $requests = $request->query('country_name') ? $requests->where('countries.name', 'like', '%' . $request->query('country_name') . '%') : $requests;




        $requests = $request->query('amount') ? $requests->where('withdrawal_request.amount', 'like', '%' . $request->query('amount') . '%') : $requests;

        $requests = !empty($request->query('date')) && $request->query('date') != "" ? $requests->where('withdrawal_request.date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $requests;

        $requests = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $requests->whereBetween('withdrawal_request.created_at', [$request->query('start_date'), $request->query('end_date')]) : $requests;

        $requests = !empty($request->query('debited_date_time')) && $request->query('debited_date_time') != "" ? $requests->where('withdrawal_request.debited_date_time', 'like', date("j M Y", strtotime($request->query('debited_date_time')))  . '%') : $requests;

        $requests = !empty($request->query('dismissed_date_time')) && $request->query('dismissed_date_time') != "" ? $requests->where('withdrawal_request.dismissed_date_time', 'like', date("j M Y", strtotime($request->query('dismissed_date_time')))  . '%') : $requests;



        $requests = $requests->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();



        $props['requests'] = $requests;
        $props['length'] = $length;
        $props['role'] = $role_prop;
        $props['name'] = $request->query('name') ? $request->query('name') : NULL;
        $props['phone'] = $request->query('phone') ? $request->query('phone') : NULL;
        $props['email'] = $request->query('email') ? $request->query('email') : NULL;
        $props['country_name'] = $request->query('country_name') ? $request->query('country_name') : NULL;

        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['debited_date_time'] = $request->query('debited_date_time') ? $request->query('debited_date_time') : NULL;
        $props['dismissed_date_time'] = $request->query('dismissed_date_time') ? $request->query('dismissed_date_time') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;


        // return $history;


        return Inertia::render("Admin/AccountWithdrawalRequests", $props);
    }

    public function loadUsersAdminDebitHistoryPage(Request $request, User $user)
    {

        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;


        $j = 0;
        $history = $user->adminDebitHistory();

        $history = $request->query('amount') ? $history->where('amount', 'like', '%' . $request->query('amount') . '%') : $history;

        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();

        $props['history'] = $history;
        $props['length'] = $length;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;
        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;


        // return $wallet_statement;


        return Inertia::render("Admin/UsersAdminDebitHistory", $props);
    }

    public function loadUsersAdminCreditHistoryPage(Request $request, User $user)
    {

        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;


        $j = 0;
        $history = $user->adminCreditHistory();

        $history = $request->query('amount') ? $history->where('amount', 'like', '%' . $request->query('amount') . '%') : $history;
       
        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();

        $props['history'] = $history;
        $props['length'] = $length;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;
        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;


        // return $wallet_statement;


        return Inertia::render("Admin/UsersAdminCreditHistory", $props);
    }

    public function loadUsersTransferHistoryPage(Request $request, User $user)
    {

        $props['user'] = $user;

        $role_prop = $request->query("role");
        $role_prop = empty($role_prop) ? 'all' : $role_prop;


        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;


        $j = 0;
        $user_id = $user->id;
        $history = TransferFundsHistory::where(function ($query) use ($user_id, $role_prop) {

            if ($role_prop == "all") {
                $query->where('sender', $user_id)
                    ->orWhere('recepient', $user_id);
            } else if ($role_prop == "sender") {
                $query->where('sender', $user_id);
            } else if ($role_prop == "recepient") {
                $query->where('recepient', $user_id);
            }
        });


        $history = $history->join('users as sender', 'transfer_funds_history.sender', '=', 'sender.id')->addSelect('sender.name as sender_name')->addSelect('sender.phone as sender_phone')->addSelect('sender.country_id as sender_country_id')->addSelect('sender.email as sender_email');

        $history = $history->join('countries as sender_country', 'sender.country_id', '=', 'sender_country.id')->addSelect('sender_country.name as sender_country_name');

        $history = $history->join('users as recepient', 'transfer_funds_history.recepient', '=', 'recepient.id')->addSelect('recepient.name as recepient_name')->addSelect('recepient.phone as recepient_phone')->addSelect('recepient.country_id as recepient_country_id')->addSelect('recepient.email as recepient_email');

        $history = $history->join('countries as recepient_country', 'recepient.country_id', '=', 'recepient_country.id')->addSelect('recepient_country.name as recepient_country_name');
        // $history = $history->join('users', 'transfer_funds_history.sender', '=', 'users.id');

        $history = $history->addSelect('transfer_funds_history.*');


        $history = $request->query('sender_name') ? $history->where('sender.name', 'like', '%' . $request->query('sender_name') . '%') : $history;
        $history = $request->query('sender_phone') ? $history->where('sender.phone', 'like', '%' . $request->query('sender_phone') . '%') : $history;
        $history = $request->query('sender_email') ? $history->where('sender.email', 'like', '%' . $request->query('sender_email') . '%') : $history;
        $history = $request->query('sender_country_name') ? $history->where('sender_country.name', 'like', '%' . $request->query('sender_country_name') . '%') : $history;

        $history = $request->query('recepient_name') ? $history->where('recepient.name', 'like', '%' . $request->query('recepient_name') . '%') : $history;
        $history = $request->query('recepient_phone') ? $history->where('recepient.phone', 'like', '%' . $request->query('recepient_phone') . '%') : $history;
        $history = $request->query('recepient_email') ? $history->where('recepient.email', 'like', '%' . $request->query('recepient_email') . '%') : $history;
        $history = $request->query('recepient_country_name') ? $history->where('recepient_country.name', 'like', '%' . $request->query('recepient_country_name') . '%') : $history;

        

        $history = $request->query('amount') ? $history->where('transfer_funds_history.amount', 'like', '%' . $request->query('amount') . '%') : $history;
        
        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('transfer_funds_history.date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('transfer_funds_history.created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();

        

        $props['history'] = $history;
        $props['length'] = $length;
        $props['role'] = $role_prop;
        $props['sender_name'] = $request->query('sender_name') ? $request->query('sender_name') : NULL;
        $props['sender_phone'] = $request->query('sender_phone') ? $request->query('sender_phone') : NULL;
        $props['sender_email'] = $request->query('sender_email') ? $request->query('sender_email') : NULL;
        $props['recepient_country_name'] = $request->query('recepient_country_name') ? $request->query('recepient_country_name') : NULL;

        $props['recepient_name'] = $request->query('recepient_name') ? $request->query('recepient_name') : NULL;
        $props['recepient_phone'] = $request->query('recepient_phone') ? $request->query('recepient_phone') : NULL;
        $props['recepient_email'] = $request->query('recepient_email') ? $request->query('recepient_email') : NULL;
        $props['recepient_country_name'] = $request->query('recepient_country_name') ? $request->query('recepient_country_name') : NULL;
        
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;
        
        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;


        // return $history;


        return Inertia::render("Admin/UsersTransferHistory", $props);
    }

    public function loadUsersAccountStatementPage(Request $request, User $user){
        
        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;


        $j = 0;
        $wallet_statement = $user->accountStatement();

        $wallet_statement = $request->query('amount') ? $wallet_statement->where('amount', 'like', '%' . $request->query('amount') . '%') : $wallet_statement;
        $wallet_statement = $request->query('balance') ? $wallet_statement->where('amount_after', 'like', '%' . $request->query('balance') . '%') : $wallet_statement;
        $wallet_statement = $request->query('summary') ? $wallet_statement->where('summary', 'like', '%' . $request->query('summary') . '%') : $wallet_statement;
        $wallet_statement = !empty($request->query('date')) && $request->query('date') != "" ? $wallet_statement->where('date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $wallet_statement;

        $wallet_statement = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $wallet_statement->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]) : $wallet_statement;



        $wallet_statement = $wallet_statement->orderBy("id", "DESC")
        ->paginate($length)->withQueryString();

        $props['wallet_statement'] = $wallet_statement;
        $props['length'] = $length;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;
        $props['balance'] = $request->query('balance') ? $request->query('balance') : NULL;
        $props['summary'] = $request->query('summary') ? $request->query('summary') : NULL;
        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;


        // return $wallet_statement;


        return Inertia::render("Admin/UsersAccountStatement", $props);
    }

    public function loadUsersAccountWithdrawalHistoryPage(Request $request, User $user){
        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        $history = $user->withdrawalHistory();



        $history = $request->query('amount') ? $history->where('amount', 'like', '%' . $request->query('amount') . '%') : $history;
        
        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("id", "DESC")
            ->paginate($length)->withQueryString();




        // return $history;


        $props['history'] = $history;
        $props['length'] = $length;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;

        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;



        return Inertia::render("Admin/UsersWithdrawalHistory", $props);
    }
    
    public function loadUsersAccountCreditHistoryPage(Request $request, User $user){
        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        $history = $user->accountCreditHistory();



        $history = $request->query('amount') ? $history->where('amount', 'like', '%' . $request->query('amount') . '%') : $history;
        $history = $request->query('payment_option') ? $history->where('payment_option', 'like', '%' . $request->query('payment_option') . '%') : $history;
        $history = $request->query('reference') ? $history->where('reference', 'like', '%' . $request->query('reference') . '%') : $history;
        
        $history = !empty($request->query('date')) && $request->query('date') != "" ? $history->where('date', 'like', date("j M Y", strtotime($request->query('date')))  . '%') : $history;

        $history = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $history->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]) : $history;



        $history = $history->orderBy("id","DESC")
                    ->paginate($length)->withQueryString();




        // return $history;


        $props['history'] = $history;
        $props['length'] = $length;
        $props['amount'] = $request->query('amount') ? $request->query('amount') : NULL;
        
        $props['payment_option'] = $request->query('payment_option') ? $request->query('payment_option') : NULL;
        $props['reference'] = $request->query('reference') ? $request->query('reference') : NULL;
        $props['date'] = $request->query('date') ? $request->query('date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;



        return Inertia::render("Admin/UsersAccountCreditHistory", $props);
    }

    public function processDebitUser(Request $request, User $user)
    {
        $date = date("j M Y");
        $time = date("h:i:sa");
        $response_arr = ['success' => false];
        $rules = [
            'amount' => ['required', 'numeric']
        ];

        $request->validate($rules);

        $amount = $request->amount;
        $total_income = $user->total_income;
        $withdrawn = $user->withdrawn;

        // $wallet_balance = $total_income - $withdrawn;

        // if($amount <= $wallet_balance){
        
        $summary = "Admin Debit Of " . $amount;
        if ($this->functions->debitUser($user->id, $amount, $summary)) {
            $this->functions->addAdminDebitHistory($user->id, $amount, $date, $time);
            $response_arr['success'] = true;
            
        }

        return back()->with('data', $response_arr);
    }

    public function processCreditUser(Request $request, User $user){
        $date = date("j M Y");
        $time = date("h:i:sa");
        $response_arr = ['success' => false];
        $rules = [
            'amount' => ['required', 'numeric']
        ];

        $request->validate($rules);

        $amount = $request->amount;
        $summary = "Admin Credit Of " . $amount;

        if ($this->functions->creditUser($user->id, $amount, $summary)) {
            if ($this->functions->debitUser($user->id, 20, "Admin Credit Charge")) {
                $this->functions->addAdminCreditHistory($user->id, $amount, $date, $time);
                $response_arr['success'] = true;
            }
        }

        return back()->with('data', $response_arr);
    }

    public function getUserData(Request $request, User $user){
        
        $user->country_name = Country::find($user->country_id)->name;
        $response_arr = ['success' => true, 'user' => $user];
        return $response_arr;
        // return back()->with('data', $response_arr);
    }
        

    public function processEditUsersProfile(Request $request, User $user){
        
        $response_arr = ['success' => false, 'email_changed' => false];

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
        

        if ($user->email != $request->email) {
            $response_arr['email_changed'] = true;
            $user->newEmail($request->email);
        }

        $user->save();

        $response_arr['success'] = true;

        return back()->with('data', $response_arr);
    }

    public function loadAdminEditUserProfilePage(Request $request, User $user){
        
        $props = [];
        $real_countries = [];
        
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

            if($id == $user->country_id){
                $props['selected_country'] = $i;
            }
        }
       
        $props['user'] = $user;

        $props['countries'] = $real_countries;
        
        return Inertia::render('Admin/EditUserProfile',$props);
    }

    public function loadMembersListPage(Request $request){
        $user = Auth::user();
        
        $props['user'] = $user;

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;


        $j = 0;
        $users = User::where('is_admin',0);

        $users = $users->join('countries', 'users.country_id', '=', 'countries.id')->addSelect('countries.name as country_name');
        $users = $users->addSelect('users.*');

        $users = $request->query('name') ? $users->where('users.name', 'like', '%' . $request->query('name') . '%') : $users;
        $users = $request->query('user_name') ? $users->where('users.user_name', 'like', '%' . $request->query('user_name') . '%') : $users;
        
        $users = $request->query('country') ? $users->where('users.country_id', $request->query('country')['id']) : $users;
        $users = $request->query('phone') ? $users->where('users.phone', 'like', '%' . $request->query('phone') . '%') : $users;
        $users = $request->query('email') ? $users->where('users.email', 'like', '%' . $request->query('email') . '%') : $users;
        $users = !empty($request->query('created_date')) && $request->query('created_date') != "" ? $users->where('users.created_date', 'like', date("j M Y", strtotime($request->query('created_date')))  . '%') : $users;

        $users = !empty($request->query('start_date')) && !empty($request->query('end_date')) != "" ? $users->whereBetween('users.created_at', [$request->query('start_date'), $request->query('end_date')]) : $users;



        $users = $users->orderBy("name", "ASC")
        ->paginate($length)->withQueryString();

        


        // return $users;

        
        $real_countries = [];
        
        $countries = Country::where('id', '!=', '0')->orderBy("name", "ASC")->get();

        $i = -1;
        foreach ($countries as $country) {
            $i++;
            $id = $country->id;
            $name = $country->name;
            $phone_code = $country->phone_code;

            $real_countries[] = [
                'id' => $id,
                'label' => $name . ' (' . $phone_code . ')',
            ];

            // $props['selected_country'] = !isset($props['selected_country']) && $id == $user->country_id = $i;
            if ($id == $user->country_id) {
                $props['selected_country'] = $i;
            }
        }
        

        $props['countries'] = $real_countries;
        $props['users'] = $users;
        $props['length'] = $length;
        $props['name'] = $request->query('name') ? $request->query('name') : NULL;
        $props['user_name'] = $request->query('user_name') ? $request->query('user_name') : NULL;
        
        $props['country'] = $request->query('country') ? $request->query('country') : $real_countries[$props['selected_country']];
        $props['phone'] = $request->query('phone') ? $request->query('phone') : NULL;
        $props['email'] = $request->query('email') ? $request->query('email') : NULL;
        $props['created_date'] = $request->query('created_date') ? $request->query('created_date') : NULL;
        $props['start_date'] = $request->query('start_date') ? $request->query('start_date') : NULL;
        $props['end_date'] = $request->query('end_date') ? $request->query('end_date') : NULL;



        return Inertia::render("Admin/MembersList", $props);
    }
}
