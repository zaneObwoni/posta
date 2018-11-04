<?php

namespace App\Http\Controllers\Api;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Models\Estamp as Estamp;
use App\Models\Bestwish as Bestwish;

use DB, Response;

class StampController extends Controller
{
    //
	public function index(){

		return "index";
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromApp($data)
    {


    	$json_data = json_decode($data, true);	

    	$sender_name 		= $json_data[0]['sender_name'];
    	$sender_phone 		= $json_data[0]['sender_phone'];
    	$recipient_name 	= $json_data[0]['recipient_name'];
    	$recipient_phone 	= $json_data[0]['recipient_phone'];

    	$destination_box 	= $json_data[0]['destination_box'];
    	$destination_code 	= $json_data[0]['destination_code'];
    	$destination_town 	= $json_data[0]['destination_town'];
    	$origin_town 		= $json_data[0]['origin_town'];

    	$letter_weight 		= $json_data[0]['letter_weight'];
    	$price 				= $json_data[0]['price'];
    	$user_id 			= $json_data[0]['user_id'];
    	$trans_id 			= $json_data[0]['trans_id'];

    	// dd($trans_id);

        // Previous code to check if payment if successful - By Lee (Uncomment)
    	// $stamp_code_array = DB::table('payment_status_new')->pluck('msisdn');        
        // if(in_array($trans_id, $stamp_code_array)){
        
            // $record = DB::table('estamps')->where('code', $code)->first();
            // store
	        $stamp 							= new Estamp;
	        $stamp->sender_name       		= $sender_name;
	        $stamp->sender_phone    		= $sender_phone;     
	        $stamp->recipient_name   		= $recipient_name;
	        $stamp->recipient_phone    		= $recipient_phone;
	        $stamp->destination_box      	= $destination_box;

	        $stamp->destination_code       	= $destination_code;
	        $stamp->destination_town    	= $destination_town;     
	        $stamp->origin_town   			= $origin_town;
	        $stamp->letter_weight    		= $letter_weight;
	        $stamp->price      				= $price;
	        $stamp->user_id    				= $user_id;

	        $key 							= \Config::get('app.key');
            $generatedCode 					= hash_hmac('sha256', str_random(40), $key);

            $generatedCode 					= substr($generatedCode, 0, 8);

            $stamp->code               		= $generatedCode;

	        $stamp->save();

            DB::table('payment_status_new')->where('msisdn', $trans_id)->delete();

	        return Response::json([
	        	'status'  				    => 1, 
	        	'message' 				    => 'Stamp Created.',
	        	'sender_name' 			    => $stamp->sender_name,
        		'sender_phone' 			    => $stamp->sender_phone,
        		'recipient_name' 		    => $stamp->recipient_name,
        		'recipient_phone' 		    => $stamp->recipient_phone,
        		'destination_box' 		    => $stamp->destination_box,
        		'destination_code' 		    => $stamp->destination_code,

        		'destination_town' 		    => $stamp->destination_town,
        		'origin_town' 			    => $stamp->origin_town,
        		'letter_weight' 		    => $stamp->letter_weight,
        		'price' 				    => $stamp->price,
        		'code' 					    => $stamp->code
       
	        	]);

        // }else{

        // 	return Response::json(['status' => 0, 'message' => 'Code not Found.']);
        // }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBestWishesFromApp($data)
    {

        $json_data = json_decode($data, true);  


        $sender_name        = $json_data[0]['sender_name'];
        $sender_phone       = $json_data[0]['sender_phone'];
        $season             = $json_data[0]['season'];
        $recipient_name     = $json_data[0]['recipient_name']; 
        $recipient_phone    = $json_data[0]['recipient_phone'];
        $recipient_box      = $json_data[0]['recipient_box'];
        $recipient_code     = $json_data[0]['recipient_code'];
        $origin_town        = $json_data[0]['origin_town'];
        $recipient_town     = $json_data[0]['recipient_town'];
        $recipient_email    = $recipient_box."-".$recipient_code."@posta.co.ke";

        $message            = $json_data[0]['message'];
        $letter_weight      = $json_data[0]['letter_weight'];
        $price              = $json_data[0]['price'];
        $user_id            = $json_data[0]['user_id'];
        $status             = 1;
        $active             = 1;

        $stamp                          = new Estamp;
        $stamp->sender_name             = $sender_name;
        $stamp->sender_phone            = $sender_phone;   
        $stamp->category                  = 'SEASON';
        $stamp->season                  = $season;  
        $stamp->recipient_name          = $recipient_name;
        $stamp->recipient_phone          = $recipient_phone;
        $stamp->destination_box         = $recipient_box;
        $stamp->destination_code        = $recipient_code;
        $stamp->origin_town             = $origin_town;
        $stamp->destination_town        = $recipient_town;
        $stamp->message                 = $message;
        $stamp->letter_weight           = $letter_weight;

        $key                            = \Config::get('app.key');
        $generatedCode                  = hash_hmac('sha256', str_random(40), $key);
        $generatedCode                  = substr($generatedCode, 0, 10);
        $stamp->code                    = strtoupper($generatedCode);

        $stamp->price                   = $price;
        $stamp->user_id                 = $user_id;
        $stamp->status                  = $status;
        $stamp->active                  = $active;
        $stamp->save();

        return Response::json([
            'status'                    => 1, 
            'message'                   => 'BestWishes Created.',
            'sender_name'               => $stamp->sender_name,
            'sender_phone'              => $stamp->sender_phone,
            'category'                  => 'SEASON',
            'season'                    => $stamp->season,
            'recipient_name'            => $stamp->recipient_name,
            'recipient_phone'           => $stamp->recipient_phone,
            'origin_town'               => $stamp->origin_town,
            'destination_box'           => $stamp->destination_box,
            'destination_code'          => $stamp->destination_code,
            'destination_town'          => $stamp->destination_town,

            'message'                   => $stamp->message,
            'letter_weight'             => $stamp->letter_weight,
            'code'                      => $stamp->code,
            'price'                     => $stamp->price,
            'user_id'                   => $stamp->user_id
            ]);

    }

    public function userStamps($id){

        // $userId = Request::segment(4);
        $userId = $id;

        $userStamps = Estamp::where('user_id', $userId)->get();    

        // dd($userStamps);


        return Response::json([
            'user_stamps' => $userStamps
        ], 200);

    }

}
