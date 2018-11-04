<?php

namespace App\Http\Controllers\Api;

use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Models\Estamp as Estamp;
use App\Models\Delivery as Delivery;
use App\Models\Email as Email;

use App\Models\Underpayment as Underpayment;

use DB, Response;

class RTSController extends Controller
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


        $code         = $json_data[0]['code'];

        $postal_code_array = DB::table('estamps')->pluck('code');        

        // dd($postal_code_array);
    
        if(in_array($code, $postal_code_array)){

            $record = DB::table('estamps')->where('code', $code)->first();    
            
            // dd($record);
            $sender_phone       = $record->sender_phone;
            $sender_name       = $record->sender_name;
            $receiver_name       = $record->recipient_name;

            $message = "Dear, ".$sender_name." we are returning the letter you send to ".$receiver_name." for non Collection. Confirm if you need it back or to have us destroy it. Please dial *483*567# for options.";
            // $message = "Dear, ".$sender_name." we are returning the letter you send to ".$receiver_name." for non Collection. Confirm if you need it back or to have us destroy it. Please follow this link for further instructions.";

            

            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = DB::table('users')->where('phone', $sender_phone)->value('email');

            // dd($sender_phone);
            $email->subject = "Mail Delivery Options";
            $email->body    = "Dear, ".$sender_name." we are returning the letter you send to ".$receiver_name." for non Collection. Confirm if you need it back or to have us destroy it. Please follow this link for further instructions.";
            $email->save();

            $notify = new SendSMSController();
            $notify->sendSms($sender_phone, $message); 
            // dd($receiver_name);
        }else{

            return Response::json(['status' => '0', 'message' => 'Stamp is Invalid.']);
       
        }
    }

    public function pay($data)
    {
        $json_data      = json_decode($data, true);  
        
        $code           = $json_data[0]['stamp_code'];
        $balance        = $json_data[0]['amount'];

        $estamp_code_array = DB::table('underpayments')->pluck('stamp_code');        
    
        if(in_array($code, $estamp_code_array)){

            $underpayment = Underpayment::where('stamp_code', $code)->first();

            if($balance == $underpayment->amount){

                Underpayment::where('stamp_code', $code)->update(array('status' => 'PAID'));

                return Response::json(['status' => '1', 'message' => 'Stamp paid fully.']);
            }else{

                return Response::json(['status' => '0', 'message' => 'Money paid not Enough.']);
            }
                

        }else{
            return Response::json(['status' => '0', 'message' => 'Stamp is Invalid.']);
        }
    }

}
