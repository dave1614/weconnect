<?php

namespace App\Http\Controllers;

use App\Functions\UsefulFunctions;
use App\Models\PaystackLog;
use App\Models\PaystackReference;
use App\Models\PaystackTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class BlockBeeController extends Controller
{


    public UsefulFunctions $functions;

    public function __construct()
    {
        $this->functions = new UsefulFunctions();
    }

    public function processPaystackWebhooks(Request $request)
    {
        // echo json_encode($_SERVER);

        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER))
            exit();



        $json_post = file_get_contents('php://input');
        // echo hash_hmac('sha512', $json_post, env('PAYSTACK_SECRET_KEY'));




        // validate event do all at once to avoid timing attack
        if ($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $json_post, env('PAYSTACK_SECRET_KEY')))
            exit();



        http_response_code(200);

        $post = json_decode($json_post);
        $date = date("j M Y");
        $time = date("h:i:sa");

        // return $post;


        // return var_dump($post->event);
        PaystackLog::create([
            'log' => $json_post,
        ]);
        

        
        PaystackTransaction::create([

            'event' => isset($post->event) ? $post->event : null,
            'transaction_id' => isset($post->data->id) ? $post->data->id : null,
            'domain' => isset($post->data->domain) ? $post->data->domain : null,
            'status' => isset($post->data->status) ? $post->data->status : null,
            'reference' => isset($post->data->reference) ? $post->data->reference : null,
            'amount' => isset($post->data->amount) ? $post->data->amount : null,
            'message' => isset($post->data->message) ? $post->data->message : null,
            'gateway_response' => isset($post->data->gateway_response) ? $post->data->gateway_response : null,
            'paid_at' => isset($post->data->paid_at) ? $post->data->paid_at : null,
            'created' => isset($post->data->created_at) ? $post->data->created_at : null,
            'channel' => isset($post->data->channel) ? $post->data->channel : null,
            'currency' => isset($post->data->currency) ? $post->data->currency : null,
            'ip_address' => isset($post->data->ip_address) ? $post->data->ip_address : null,
            'metadata' => isset($post->data->metadata) ? $post->data->metadata : null,
            'fees_breakdown' => isset($post->data->fees_breakdown) ? $post->data->fees_breakdown : null,
            'log' => isset($post->data->log) ? json_encode($post->data->log) : null,
            'fees' => isset($post->data->fees) ? $post->data->fees : null,
            'fees_split' => isset($post->data->fees_split) ? $post->data->fees_split : null,
            'authorization' => isset($post->data->authorization) ? json_encode($post->data->authorization) : null,
            'customer' => isset($post->data->customer) ? json_encode($post->data->customer) : null,
            'source' => isset($post->data->source) ? json_encode($post->data->source) : null,

        ]);




        
        if (isset($post->event) && isset($post->data->reference) && isset($post->data->amount)) {
            
            if ($post->event == "charge.success") {

                $reference = $post->data->reference;
                $amount = $post->data->amount;


                // echo "string";
                $response_arr = array();

                $headers = getallheaders();

                // return $headers;
                // $X_Auth_Signature = $headers['X-Patreon-Event'];
                // $X_Patreon_Signature = $headers['X-Patreon-Signature'];

                // return ($this->functions->checkIfMonnifyTransactionIsValid($transactionReference));
                if ($this->functions->checkIfThisPaystackReferenceIsValid($reference) && !$this->functions->checkIfThisPaystackReferenceHasBeenCredited($reference)) {
                    $reference_details = PaystackReference::where('reference', $reference)->first();
                    // return var_dump($user_monnify_details);
                    // $user = $user_monnify_details->getUser()->get();
                    $user = User::find($reference_details->user_id);
                    // return $user;

                    // return $amount . ' ' . $reference_details->amount;
                    if ($amount == $reference_details->amount) {
                        
                        $amount_to_credit = $amount / 100;

                        // $amount_to_credit = ($user->created == 1) ? $amount_to_credit - 30 : $amount_to_credit;


                        $summary = "Direct Credit Of ₦" . number_format($amount_to_credit, 2) . " Using Online Payment";

                        $this->functions->creditUser($user->id, $amount_to_credit, $summary);

                        $reference_details->credited = 1;
                        $reference_details->save();

                        $form_array = array(
                            'user_id' => $user->id,
                            'amount' => $amount_to_credit,
                            'type' => 'naira',
                            'date' => $date,
                            'time' => $time,
                            
                            'payment_option' => 'paystack',
                            'reference' => $reference
                        );
                        if ($this->functions->addNewAccountCreditHistory($form_array)) {
                        }
                    }
                }
            }
        }
    }
}
