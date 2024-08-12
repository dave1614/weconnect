<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EarningsController extends Controller
{

    public UsefulFunctions $functions;

    public function __construct()
    {

        $this->functions = new UsefulFunctions();
    }

    public function transferEarningToMainWallet(Request $request)
    {
        $date = date("j M Y");
        $time = date("h:i:sa");
        $curr_date = date("j M Y");
        $curr_date_time = date("j M Y h:i:sa");
        $user = Auth::user();
        $user_id = $user->id;

        
        $response_arr = ['success' => false, 'not_referred_enough' => true,'refferal_num' => 1];

        
        if ($this->functions->checkIfUserHasEnoughReferralsFrWithdrawal($user_id, $response_arr['refferal_num'])) {
            $response_arr['not_referred_enough'] = false;


            $validationRules = [
                'amount' => 'required|numeric|max:'. $user->earnings_wallet,
            ];

            $validationMessages = [
                'amount.max' => 'Maximum transferable amount is ₦:max',
              
            ];

            $request->validate($validationRules, $validationMessages);



            $amount = $request->amount;
           
            $this->functions->debitEarningsWallet($user_id,$amount,$date,$time);
            $response_arr['success'] = true;
        }


        return back()->with('data', $response_arr);
    }

    public function showEarningsMainPage(Request $request)
    {
        $user = Auth::user();
        $user = User::find($user->id);
        $page = $request->query('page');

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


        return Inertia::render('Earnings/MainPage', $props);
    }

}
