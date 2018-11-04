<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Models\User as User;
use App\Models\Email as Email;
use App\Models\Estamp as Estamp;
use App\Models\SMS as SMS;
use App\Models\Notification as Notification;

use App\Models\Staff as Staff;

use Auth, DB, Input, Validator, Session, Request, Redirect, Response;

use App\Http\Requests;

class NotificationEMSController extends Controller
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

            if($tag == 1){

                // Tag 1 - Sender Post office
                NotificationEMSController::senderPostOffice($code); 

            }elseif($tag == 2){

                //Tag 2 - Receiver Post Office
                NotificationEMSController::receiverPostOffice($code); 
            
            }elseif($tag == 3){

                // Tag 3 - Picking Scanner. Notification to Receiver
                NotificationEMSController::pickingScanner($code);
            
            }elseif($tag == 4){

                // Tag 4 - Delivery Scanner. Notification to Receiver
                NotificationEMSController::deliveryScanner($code);
            
            }else{

                // No tag 
            }
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

                $sender_message = "Your EMS Tracking Code: ".$code." to ".$receiver_name." has left the Post Office.";

                // Check this line for error -  Lee
                $sender_email = DB::table('users')->where('phone', $sender_phone)->value('email');

                $email          = new Email;
                $email->from    = "noreply@posta.co.ke";
                $email->to      = $sender_email;
                $email->subject = "Mail on the way.";
                $email->body    = $sender_message;

                $email->save();

                $receiver_message = "A EMS from ".$sender_name." is on its way to you from ".$sender_town.". You will be notified when it arrives in your Door.";

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

                echo "Stamp has been used";
                return Response::json(['status' => '0', 'message' => 'Stamp has been used.']);
            }

            echo "Stamp Has already been Created";
            return Response::json(['status' => '1', 'message' => 'Stamp Created.']);
        }else{
            echo "Stamp is Invalid";
            return Response::json(['status' => '0', 'message' => 'Stamp is Invalid.']);
        }   
    
    }

    public function receiverPostOffice($code){

        $postal_code_array = DB::table('estamps')->pluck('code');        
    
        if(in_array($code, $postal_code_array)){

            $record = DB::table('estamps')->where('code', $code)->first();   

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
            $email->body    = "Dear, ".$receiver_name.". A EMS from ".$sender_name." is in your Box Number ".$receiver_box."-".$receiver_code.", ".$receiver_town.". Kindly arrange to pick it up. To have it delivered to you please follow this link -> <a href='http://www.enjiwa.com/user/deliveries/create/".$code."'>Click this Delivery Link</a>";
            $email->save();

            $sender_message = "Your EMS Tracking code: ".$code." has been delivered at the Post Office.";
            $receiver_message = "A EMS Tracking code: ".$code." has been received at the Post Office.";

            $sms                = new SMS;
            $sms->to            = "RECEIVER";
            $sms->subject       = "DELIVERY";
            $sms->message       = $receiver_message;
            $sms->phone         = $receiver_phone;
            $sms->status        = "PROGRESS";
            $sms->active        = 1;
            $sms->save();

            $notify = new SendSMSController();
            $notify->sendSms($sender_phone, $sender_message);

            $notify = new SendSMSController();
            $notify->sendSms($receiver_phone, $receiver_message);

            echo "1";
            return Response::json(['status' => '1', 'message' => 'Success.']);
        }else{
            
            echo "Stamp is Invalid";
            return Response::json(['status' => '10', 'message' => 'Stamp is Invalid.']);
        }   
    
    }

    public function pickingScanner($code){

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

            // echo "Message to Receiver Sent";
            return Response::json(['status' => '1', 'message' => 'Success.']);

        }else{

            // echo "Code not Found";
            return Response::json(['status' => '11', 'message' => 'Stamp is Invalid.']);
        }   
    
    }

    public function deliveryScanner($code){

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
            $email->subject = "EMS Arrived";
            $email->body    = "The EMS to ".$receiver_name." has been successfully delivered by ".$rider_name.".";

            $email->save();

            $receiver_message = "Your EMS has been successfully delivered. For complaints or compliments call/SMS office No. 0724424353.";

            // Free rider to status = 0;
            Staff::where('id', $record->rider_no)->update(array('status' => 0));

            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = $receiver->email;
            $email->subject = "EMS Arrived";
            $email->body    = $receiver_message;
            $email->save();
    
            $sms                = new SMS;
            $sms->to            = "RECEIVER";
            $sms->subject       = "EMS DELIVERED";
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
            return Response::json(['status' => '0', 'message' => 'Stamp is Invalid.']);
        }   
    
    }

}
