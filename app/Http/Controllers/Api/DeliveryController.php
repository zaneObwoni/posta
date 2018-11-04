<?php

namespace App\Http\Controllers\Api;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Models\Estamp as Estamp;
use App\Models\Delivery as Delivery;

use DB, Response;

class DeliveryController extends Controller
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


    	$building_name 		 = $json_data[0]['building_name'];
    	$street 		     = $json_data[0]['street'];
    	$town 	             = $json_data[0]['town'];
    	$phone 	             = $json_data[0]['phone'];

    	$fullname 	         = $json_data[0]['fullname'];
    	
    	$amount 	         = $json_data[0]['amount'];
    	$parcel_code 		 = $json_data[0]['parcel_code'];

        $category            = $json_data[0]['category'];
        $sub_category        = $json_data[0]['sub_category'];
        $distance            = $json_data[0]['distance'];
        $quantity            = $json_data[0]['quantity'];
        $extra_weight        = $json_data[0]['extra_weight'];

        $user_id             = $json_data[0]['user_id'];
        

        // $payment_data = DB::table('payment_status')->where('merchant_transaction_id', $code)->first();

        $delivery_code_array = DB::table('estamps')->pluck('code');        
        if(in_array($parcel_code, $delivery_code_array)){

            $delivery                            = new Delivery;
            $delivery->building_name             = $building_name;
            $delivery->street                    = $street;     
            $delivery->town                      = $town;
            $delivery->phone                     = $phone;
            $delivery->fullname                  = $fullname;

            
            $delivery->amount                    = $amount;  

            $delivery->category                  = $category;  
            $delivery->sub_category              = $sub_category;  
            $delivery->distance                  = $distance;  
            $delivery->quantity                  = $quantity;  
            $delivery->extra_weight              = $extra_weight;                 
        
            $key                                 = \Config::get('app.key');
            $generatedCode                       = hash_hmac('sha256', str_random(40), $key);
            $generatedCode                       = substr($generatedCode, 0,  8);

            $delivery->code                      = $generatedCode;
            $delivery->stamp_code                = $parcel_code;
            $delivery->user_id                   = $user_id;

            $delivery->save();

            // DB::table('payment_status_new')->where('msisdn', $trans_id)->delete();

            return Response::json(['status' => '1', 'message' => 'Payment Successful. We will notify you when the rider leaves the Office.']);

        }else{

            // echo "False";
            return Response::json(['status' => '0', 'message' => 'Code not Found.']);
        }
        
    }

}
