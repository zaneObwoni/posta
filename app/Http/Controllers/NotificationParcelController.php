<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Models\User as User;
use App\Models\Email as Email;
use App\Models\Estamp as Estamp;
use App\Models\SMS as SMS;
use App\Models\Notification as Notification;

use Auth, DB, Input, Validator, Session, Request, Redirect, Response;

use App\Http\Requests;

class NotificationParcelController extends Controller
{
    
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();   

        return view('backend.notifications.index', compact('user', 'notifications', 'notifications_count'));
    }


        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $notification = Notification::find($id);

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();    

        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;             

        return view('backend.notifications.show', compact('user', 'notification', 'notifications', 'notifications_count', 'notifications_emails'));
    }



    public function mobileApp($data){


        $main_data = json_decode($data);
        
        foreach($main_data as $data){

            $tag = $data->{'tag'};
            $code = $data->{'code'};

            // echo $tag;
            // echo "<br>";
            // echo $code;

            if($tag == 1){

                //Tag 1 - Receiver Post Office
                NotificationParcelController::receiverPostOffice($code);                

            }elseif($tag == 2){

                // Tag 2 - Sender Post office
                NotificationParcelController::senderPostOffice($code);
            
            }elseif($tag == 3){

                // Tag 3 - Back office Scanner. Notification to Receiver
                NotificationParcelController::backOffice($code);
            
            }elseif($tag == 4){

                // Tag 4 - Parcel delivered Scanner. Notification to Receiver
                NotificationParcelController::parcelDelivered($code);
            
            }elseif($tag == 5){

                // Tag 5 - Return to Sender. Notification to Receiver
                NotificationParcelController::rts($code);
            
            }elseif($tag == 6){

                // Tag 6 - Agents Scanner. Notification to Receiver
                NotificationParcelController::agents($code);
            
            }elseif($tag == 7){

                // Tag 7 - Under Payment. Notification to Receiver
                NotificationParcelController::under($code);
            
            }else{

                // No tag 
            }
        }

    }


    public function receiverPostOffice($code){

        $postal_code_array = DB::table('estamps')->pluck('code');        

        // dd($postal_code_array);
    
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


            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = $receiver_box."-".$receiver_code."@posta.co.ke";
            $email->subject = "Mail Delivery Options";
            $email->body    = "Dear, ".$receiver_name.". A Parcel from ".$sender_name." is in your Box Number ".$receiver_box."-".$receiver_code.", ".$receiver_town.". Kindly arrange to pick it up. To have it delivered to you please follow this link -> <a href='http://www.enjiwa.com/user/deliveries/create/".$code."'>Click this Delivery Link</a>";
            $email->save();

            // dd($email->to);

            // $sender_message = "Your Parcel Tracking code: ".$code." to ".$receiver_name." has been delivered.";
            $sender_message = "Your Parcel Tracking code: ".$code." to ".$receiver_name.", ".$receiver_box."-".$receiver_code.", ".$receiver_town." is now at their post office awaiting collection.";
            $receiver_message = "A Parcel Tracking code: ".$code." from ".$sender_name." is at your Post Office. Either pick it or dial *483*567# for delivery.";

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

            echo "1";
            // echo "Message to Receiver Sent";
            return Response::json(['status' => '1', 'message' => 'Success.']);
        }else{
            
            echo "Stamp is Invalid";
            return Response::json(['status' => '10', 'message' => 'Stamp is Invalid.']);
        }   
    
    }

    public function senderPostOffice($code){

        $postal_code_array = DB::table('estamps')->pluck('code');        

        // dd($postal_code_array);
    
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

            if($active_value == 1){

                $sender_message = "Your Parcel Tracking Code: ".$code." to ".$receiver_name." has left the Post Office.";

                // Check this line for error -  Lee
                $sender_email = DB::table('users')->where('phone', $sender_phone)->value('email');

                $email          = new Email;
                $email->from    = "noreply@posta.co.ke";
                $email->to      = $sender_email;
                $email->subject = "Mail on the way.";
                $email->body    = $sender_message;

                $email->save();

                $receiver_message = "A Parcel from ".$sender_name." is on its way to you from ".$sender_town.". You will be notified when it arrives at your Post Office.";

                $email          = new Email;
                $email->from    = "noreply@posta.co.ke";
                $email->to      = $receiver_box."-".$receiver_code."@posta.co.ke";
                $email->subject = "Mail on the way.";
                $email->body    = $receiver_message;

                $email->save();

                $sms                = new SMS;
                $sms->to            = "SENDER";
                $sms->subject       = "DELIVERY";
                $sms->message       = $sender_message;
                $sms->phone         = $sender_phone;
                $sms->status        = "PROGRESS";
                $sms->active        = 1;
                $sms->save();

                Estamp::where('code', $code)->update(array('active' => 0));

                $notify = new SendSMSController();
                $notify->sendSms($sender_phone, $sender_message);

                SMS::where('id', $sms->id)->update(array('status' => 'SEND'));

                // Second SMS
                $sms                = new SMS;
                $sms->to            = "RECEIVER";
                $sms->subject       = "DELIVERY";
                $sms->message       = $receiver_message;
                $sms->phone         = $receiver_phone;
                $sms->status        = "PROGRESS";
                $sms->active        = 1;
                $sms->save();

                $notify = new SendSMSController();
                $notify->sendSms($receiver_phone, $receiver_message); 
                
                SMS::where('id', $sms->id)->update(array('status' => 'SEND'));

                echo "1";
                return Response::json(['status' => '1', 'message' => 'Success.']);

            }else{

                echo "Stamp has been used.";
                return Response::json(['status' => '0', 'message' => 'Stamp has been used.']);
            }

            return Response::json(['status' => '1', 'message' => 'Stamp Created.']);
        }else{
            echo "Stamp is Invalid";
            return Response::json(['status' => '0', 'message' => 'Stamp is Invalid.']);
        }   
    
    }



    public function backOffice($code){

        $postal_code_array = DB::table('deliveries')->pluck('stamp_code');        
    
        // dd($postal_code_array);
        if(in_array($code, $postal_code_array)){

            $record = DB::table('deliveries')->where('stamp_code', $code)->first();
            $rider = DB::table('staffs')->where('id', $record->rider_no)->first();
            $receiver = DB::table('users')->where('id', $record->user_id)->first();

            $active_value = $record->active;

            $rider_name         = $rider->first_name;
            $rider_phone        = $rider->phone;
            $rider_vehicle_type = $rider->vehicle_type;
            $rider_vehicle_reg  = $rider->reg_no;


            $receiver_phone     = $record->phone;
            $receiver_name      = $record->fullname;


            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = $receiver->email;
            $email->subject = "Delivery Details";
            $email->body    = "Your Item has now left our Depot with ".$rider_name." driving ".$rider_vehicle_type." Reg. No. ".$rider_vehicle_reg.", ".$rider_phone.". Please call him for ETA, or our office on 0724424353. Thank you";

            $email->save();

            $receiver_message = "Your Item has now left our Depot with ".$rider_name." on ".$rider_vehicle_type." ".$rider_vehicle_reg.". For any queries call ".$rider_phone."(driver) or 0724424353(office). Thanks.";

            $sms                = new SMS;
            $sms->to            = "RECEIVER";
            $sms->subject       = "RIDER INFORMATION";
            $sms->message       = $receiver_message;
            $sms->phone         = $receiver_phone;
            $sms->status        = "PROGRESS";
            $sms->active        = 1;
            $sms->save();

            $notify = new SendSMSController();
            $notify->sendSms($receiver_phone, $receiver_message);

            SMS::where('id', $sms->id)->update(array('status' => 'SEND'));

            echo "1";
            return Response::json(['status' => '1', 'message' => 'Success.']);

        }else{

            echo "Stamp is Invalid";
            return Response::json(['status' => '11', 'message' => 'Stamp is Invalid.']);
        }   
    
    }

    public function parcelDelivered($code){

        $postal_code_array = DB::table('deliveries')->pluck('stamp_code');
    
        if(in_array($code, $postal_code_array)){

            $record = DB::table('deliveries')->where('stamp_code', $code)->first();
            $rider = DB::table('staffs')->where('id', $record->rider_no)->first();
            $receiver = DB::table('users')->where('id', $record->user_id)->first();

            $rider_name         = $rider->first_name;
            $rider_phone        = $rider->phone;
            $rider_vehicle_type = $rider->vehicle_type;
            $rider_vehicle_reg  = $rider->reg_no;
            $receiver_phone     = $record->phone;
            $receiver_name      = $record->fullname;


            $email          = new Email;
            $email->from    = "delivery@posta.co.ke";
            $email->to      = "noreply@posta.co.ke";
            $email->subject = "Parcel Arrived";
            $email->body    = "The parcel to ".$receiver_name." has been successfully delivered by ".$rider_name.".";

            $email->save();

            $receiver_message = "Your Parcel has been successfully delivered. For complaints or compliments call/SMS office No. 0724424353.";

            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = $receiver->email;
            $email->subject = "Parcel Arrived";
            $email->body    = $receiver_message;

            $email->save();
    
            $sms                = new SMS;
            $sms->to            = "RECEIVER";
            $sms->subject       = "PARCEL DELIVERED";
            $sms->message       = $receiver_message;
            $sms->phone         = $receiver_phone;
            $sms->status        = "PROGRESS";
            $sms->active        = 1;
            $sms->save();

            $notify = new SendSMSController();
            $notify->sendSms($receiver_phone, $receiver_message);

            SMS::where('id', $sms->id)->update(array('status' => 'SEND'));

            echo "1";
            return Response::json(['status' => '1', 'message' => 'Success.']);
        }else{

            echo "Stamp is Invalid.";
            return Response::json(['status' => '0', 'message' => 'Stamp is Invalid.']);
        }   
    
    }


    public function rts($data)
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

            $sender_email       = DB::table('users')->where('phone', $sender_phone)->value('email');

            $message = "Dear, ".$sender_name." we are returning the Parcel you send to ".$receiver_name." for non Collection. Confirm if you need it back or to have us destroy it. Please dial *483*567# for options.";
            // $message = "Dear, ".$sender_name." we are returning the Parcel you send to ".$receiver_name." for non Collection. Confirm if you need it back or to have us destroy it. Please follow this link for further instructions.";            

            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = $sender_email;
            $email->subject = "Mail Delivery Options";
            $email->body    = "Dear, ".$sender_name." we are returning the Parcel you send to ".$receiver_name." for non Collection. Confirm if you need it back or to have us destroy it.";
            $email->save();

            $sms                = new SMS;
            $sms->to            = "SENDER";
            $sms->subject       = "RETURNING PARCEL";
            $sms->message       = $message;
            $sms->phone         = $sender_phone;
            $sms->status        = "PROGRESS";
            $sms->active        = 1;
            $sms->save();

            $notify = new SendSMSController();
            $notify->sendSms($sender_phone, $message); 

            SMS::where('id', $sms->id)->update(array('status' => 'SEND'));

            echo "1";
            return Response::json(['status' => '1', 'message' => 'RTS Success.']);
        }else{

            echo "0";
            return Response::json(['status' => '0', 'message' => 'Stamp is Invalid.']);
       
        }
        
    }

    public function agents($data)
    {

        $json_data = json_decode($data, true);  


        $code         = $json_data[0]['code'];
        $agent_id     = $json_data[0]['agent_id'];

        // dd($code);

        $postal_code_array = DB::table('estamps')->pluck('code');        

        // dd($postal_code_array);
    
        if(in_array($code, $postal_code_array)){

            $record = DB::table('estamps')->where('code', $code)->first();    
            
            $sender_phone       = $record->sender_phone;
            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = DB::table('users')->where('phone', $sender_phone)->value('email');

            $email->subject = "Agent scanner send to Backend";
            $email->body    = "Agent ID No. ".$agent_id." has a Parcel to be collected. The tracking code is ".$code;
            $email->save();

            return Response::json(['status' => '1', 'message' => 'Email send to Backend.']);  

        }else{

            return Response::json(['status' => '0', 'message' => 'Stamp is Invalid.']);       
        }    
    }


    public function under($data)
    {

        $json_data = json_decode($data, true);  


        $code               = $json_data[0]['code'];
        $balance            = $json_data[0]['balance'];
        $price              = $json_data[0]['price'];
        $postaUserId        = $json_data[0]['user_id'];
        $postal_code        = $json_data[0]['postal_code'];

        $postal_price_array = DB::table('estamps')->pluck('code');        

    
        if(in_array($code, $postal_price_array)){

            $record = DB::table('estamps')->where('code', $code)->first();    
            
            // dd($record);
            $sender_phone       = $record->sender_phone;
            $sender_name        = $record->sender_name;
            $receiver_name      = $record->recipient_name;

            $message = "Dear, ".$sender_name." your Parcel to ".$receiver_name." is underpaid by KShs. ".$balance.". Kindly top-up for us to send the Parcel.";

            $email              = new Email;
            $email->from        = "noreply@posta.co.ke";
            $email->to          = DB::table('users')->where('phone', $sender_phone)->value('email');
            $email->subject     = "Mail Delivery Options";
            $email->body        = $message;
            $email->save();


            $sms                = new SMS;
            $sms->to            = "SENDER";
            $sms->subject       = "UNDERPAID Parcel";
            $sms->message       = $message;
            $sms->phone         = $sender_phone;
            $sms->status        = "PROGRESS";
            $sms->active        = 1;
            $sms->save();

            $notify = new SendSMSController();
            $notify->sendSms($sender_phone, $message); 

            SMS::where('id', $sms->id)->update(array('status' => 'SEND'));

            echo "1";
            return Response::json(['status' => '1', 'message' => 'Success.']);
            // dd($receiver_name);
        }else{

            echo "Stamp is Invalid";
            return Response::json(['status' => '0', 'message' => 'Stamp is Invalid.']);
       
        }
        
    }
}
