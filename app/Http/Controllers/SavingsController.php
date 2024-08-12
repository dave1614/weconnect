<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\EasySavings;
use App\Models\SavingAutoWithdrawalHistory;
use App\Models\SavingHistory;
use App\Models\SavingsDuration;
use App\Models\SavingsFrequency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SavingsController extends Controller
{
    public UsefulFunctions $functions;
    public function __construct(){

        $this->functions = new UsefulFunctions();
    }

    public function showSavingsAutoWithdHistoryPage(Request $request){
        $user = Auth::user();
        $user = User::find($user->id);
        $page = $request->query('page');

        $page = empty($page) ? 1 : $page;
        $length = $request->query("length");

        $length = empty($length) ? 10 : $length;

        $history = $user->savingsAutoWithdrawalHistory()->orderBy("id","DESC");

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


        return Inertia::render('Savings/WithdrawalHistory', $props);
    }

    public function showSavingsDebitHistoryPage(Request $request, EasySavings $easySaving){
        $saving_id = $easySaving->id;
        $user = Auth::user();
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

            
            return Inertia::render('Savings/DebitHistory', $props);
        }
    }

    public function showSavingDetailsPage(Request $request, EasySavings $easySaving){
        
        $saving_id = $easySaving->id;
        $user = Auth::user();

        if($user->id == $easySaving->user_id){
            $easySaving = $easySaving->join('savings_frequencies as frequency', 'easy_savings.savings_frequency_id', '=', 'frequency.id')->addSelect('frequency.label as frequency');

            $easySaving = $easySaving->join('savings_durations as duration', 'easy_savings.savings_duration_id', '=', 'duration.id')->addSelect('duration.label as duration');
            

            $easySaving = $easySaving->addSelect('easy_savings.*');

            $easySaving = $easySaving->where('easy_savings.id', $saving_id);
            $easySaving = $easySaving->first();

            if($easySaving->disbursed == 0){
                $easySaving->status = "pending";
            } else if ($easySaving->disbursed == 1 && $easySaving->cause_of_disbursement != "user deactivation") {
                $easySaving->status = "disbursed";
            } else if ($easySaving->disbursed == 1 && $easySaving->cause_of_disbursement == "user deactivation") {
                $easySaving->status = "deactivated";
            }

            

            $props['saving'] = $easySaving;
            // return $easySaving;
            return Inertia::render('Savings/Detail',$props);
        }
    }

    public function showSavingsHistoryPage(Request $request){
        $user = Auth::user();
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
        

        if($status_prop == "pending"){
            $savings = $savings->where('disbursed', 0);
        }else if($status_prop == "disbursed"){
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
        
        return Inertia::render('Savings/History', $props);
    }

    public function processDeactivation(Request $request){
        $curr_date = date("j M Y");
        $curr_date_time = date("j M Y h:i:sa");
        $user = Auth::user();
        $user_id = $user->id;

        
        $response_arr = ['success' => false, 'already_saving' => false];

        if ($this->functions->checkIfUserHasAnyCurrentSavingsOn($user_id)) {
            $response_arr['already_saving'] = true;
            
            $saving = EasySavings::where('user_id',$user_id)->where('disbursed',0)->first();

            $total_amount_debited_so_far = $saving->total_amount_debited_so_far;
            $amt_to_be_credited = $total_amount_debited_so_far - (0.1 * $total_amount_debited_so_far);

            $saving->disbursed = 1;
            $saving->amount_disbursed = $amt_to_be_credited;
            $saving->date_disbursed = $curr_date_time;
            $saving->cause_of_disbursement = 'user deactivation';

            $saving->save();

            SavingAutoWithdrawalHistory::create([
                'user_id' => $user_id,
                'easy_savings_id' => $saving->id,
                'amount' => $amt_to_be_credited
            ]);

            $summary = 'Credit for deactivated savings cycle';
            $this->functions->creditUser($user_id, $amt_to_be_credited, $summary);
            
            $response_arr['success'] = true;
        }


        return back()->with('data', $response_arr);
    }

    public function showDeactivateSavingPlanPage(Request $request){
        $date = date("j M Y");
        $time = date("h:i:sa");
        $user = Auth::user();
        $user_id = $user->id;

        $props['has_current_savings'] = $this->functions->checkIfUserHasAnyCurrentSavingsOn($user->id);
        if ($props['has_current_savings']) {
           
        } else {
            return redirect(route('goeasy_savings_main_page'));
        }

        return Inertia::render('Savings/DeactivatePlan', $props);
    }

    public function processApplication(Request $request)
    {
        $date = date("j M Y");
        $time = date("h:i:sa");
        $curr_date = date("j M Y");
        $curr_date_time = date("j M Y h:i:sa");
        $user = Auth::user();
        $user_id = $user->id;

        $requestData = $request->all();
        $response_arr = ['success' => false, 'already_saving' => true];

        if(!$this->functions->checkIfUserHasAnyCurrentSavingsOn($user->id)){
            $response_arr['already_saving'] = false;
            $request->merge([
                'frequency' => $requestData['frequency']['id'],
                'duration' => $requestData['duration']['id'],
            ]);

            
            $validationRules = [
                'amount' => 'required|numeric|min:100',
                'frequency' => 'required|numeric|exists:savings_frequencies,id',
                'duration' => 'required|numeric|exists:savings_durations,id',
            ];

            $validationMessages = [
                'amount.min' => 'The :attribute must be at least ₦:min',
                'frequency.exists' => 'Frequency selected is invalid',
                'duration.exists' => 'Duration selected is invalid',
            ];

            $request->validate($validationRules, $validationMessages);

            

            $amount = $request->amount;
            $frequency_id = $request->frequency;
            $duration_id = $request->duration;

            $frequency = SavingsFrequency::find($frequency_id);
            $duration = SavingsDuration::find($duration_id);
            $end_of_savings_date = date("j M Y",strtotime("+" . $duration->label));

            if($frequency_id == 1){
                $times_to_be_debited = $this->functions->datediff('d', $curr_date, $end_of_savings_date, false);
                
            } else if($frequency_id == 2){
                $times_to_be_debited = $this->functions->datediff('ww', $curr_date, $end_of_savings_date, false);
            } else if ($frequency_id == 3) {
                $date1 = $curr_date;
                $date2 = $end_of_savings_date;

                $ts1 = strtotime($date1);
                $ts2 = strtotime($date2);

                $year1 = date('Y', $ts1);
                $year2 = date('Y', $ts2);

                $month1 = date('m', $ts1);
                $month2 = date('m', $ts2);

                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                $times_to_be_debited = $diff;
            }

            
            $total_amount_to_be_debited = $times_to_be_debited * $amount;
            
            $saving = EasySavings::create([
                'user_id' => $user_id,
                'amount' => $amount,
                'start_date' => $curr_date,
                'last_date_debited' => $curr_date,
                'savings_frequency_id' => $frequency_id,
                'savings_duration_id' => $duration_id,
                'end_of_savings_date' => $end_of_savings_date,
                'total_amount_to_be_debited' => $total_amount_to_be_debited
            ]);
            
            // $this->functions->processAndDebitUserSaving($saving->id, $curr_date, $curr_date_time);
            
            $response_arr['success'] = true;
            
            

        }


        return back()->with('data', $response_arr);
    }

    public function applyForSavings(Request $request){
        $user = Auth::user();
        $props['has_current_savings'] = $this->functions->checkIfUserHasAnyCurrentSavingsOn($user->id);
        if (!$props['has_current_savings']) {
            $props['frequencies'] = SavingsFrequency::all();
            $props['duration_types'] = SavingsDuration::all();
        }else{
            return redirect(route('goeasy_savings_main_page'));
        }

        return Inertia::render('Savings/ApplyForSavings', $props);
    }

    public function showMainPage(Request $request){
        $user = Auth::user();
        $props['has_current_savings'] = $this->functions->checkIfUserHasAnyCurrentSavingsOn($user->id);
        $saving = EasySavings::where('user_id', $user->id)->where('disbursed', 0)->first();
        $props['saving_id'] = is_null($saving) ? 0 : $saving->id;
        
        return Inertia::render('Savings/MainPage',$props);
    }
}
