<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Models\User as User;
use App\Models\Email as Email;
use App\Models\Estamp as Estamp;
use App\Models\SMS as SMS;
use App\Models\Underpayment as Underpayment;
use App\Models\Notification as Notification;

use App\Models\Staff as Staff;

use Auth, DB, Input, Validator, Session, Request, Redirect, Response;

use App\Http\Requests;

class NotificationController extends Controller
{
    
	public function receiverPostOffice($code)
    {

        $postal_code_array = DB::table('estamps')->pluck('code');        
    
        if(in_array($code, $postal_code_array)){

            $record = DB::table('estamps')->where('code', $code)->first();            

            $active_value = $record->active;

            $sender_phone       = $record->sender_phone;
            $sender_name        = $record->sender_name;
            $sender_town        = $record->origin_town;


            $receiver_phone     = $record->recipient_phone;
            $receiver_name      = $record->recipient_name;
            $receiver_town      = $record->destination_town;
            $receiver_code      = $record->destination_code;
            $receiver_box       = $record->destination_box;

            $receiver_stampcode      = $record->code;


            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = $receiver_box."-".$receiver_code."@posta.co.ke";
            $email->subject = "Mail Delivery Options";
            $email->body    = "Dear, ".$receiver_name.". A letter from ".$sender_name." is in your Box Number ".$receiver_box."-".$receiver_code.", ".$receiver_town.". Kindly arrange to pick it up. To have it delivered to you please follow this link -> <a href='http://www.enjiwa.com/user/deliveries/create/".$code."'>Click this Delivery Link</a>";
            $email->save();

            $sender_email = DB::table('users')->where('phone', $sender_phone)->value('email');
            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = $sender_email;
            $email->subject = "Mail Delivery Options";
            $email->body    = "Your letter to ".$receiver_name." ".$receiver_box."-".$receiver_code.", ".$receiver_town." with Tracking Code ".$receiver_stampcode." has been dispatched from the Post office.";
            $email->save();

            // Delivery message to the letter has been delivered to the {receivers} {postoffice}, {Nairobi} 
            $sender_message = "Your letter Tracking code: ".$code." to ".$receiver_name.", ".$receiver_box."-".$receiver_code.", ".$receiver_town." has been delivered.";
            $receiver_message = "A letter Tracking code: ".$code." from ".$sender_name." is in your Box ".$receiver_box."-".$receiver_code.", ".$receiver_town.". Either pick it or dial *483*567# for delivery.";

            $sms                = new SMS;
            $sms->to            = "SENDER";
            $sms->subject       = "DELIVERY";
            $sms->message       = $sender_message;
            $sms->phone         = $sender_phone;
            $sms->status        = "PROGRESS";
            $sms->active        = 1;
            $sms->save();

            $notify = new SendSMSController();
            $notify->sendSms($sender_phone, $sender_message);

            

            SMS::where('id', $sms->id)->update(array('status' => 'SEND'));

            $notify = new SendSMSController();
            $notify->sendSms($receiver_phone, $receiver_message);

            // echo "Message to Receiver Sent";
            return Response::json(['status' => '1', 'message' => 'Success.']);
        }else{
            
            return Response::json(['status' => '10', 'message' => 'Stamp is Invalid.']);
        }   
    
    }
}