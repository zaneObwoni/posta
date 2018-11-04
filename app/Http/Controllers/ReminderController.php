<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\User as User;

use Input, Auth, DB;

use Carbon\Carbon;

class ReminderController extends Controller
{
    //

    public function reminderDue()
    {
        $now = Carbon::now();
        $inTenMinutes = Carbon::now()->addMinutes(10);

        // Add to database

        $reminder 				= new \App\Models\Reminder;
        $reminder->subject   	= 'Subject A';
        $reminder->message  	= 'Message A';
        // $reminder->save();

        $users = DB::table('users')->where('active', 0)->get();

        // return $query->where('notificationTime', '>=', $now)
        //     ->where('notificationTime', '<=', $inTenMinutes);

    }


    public function onceEveryMinute(){

    	
    }

    public function onceEveryTwoMinutes(){

    	$unPaidUsers = DB::table('users')->where('active', 0)->get();

    	if($unPaidUsers > 0){

    		foreach($unPaidUsers as $user){

    			$message = "Please, Pay to activate your account to continue using our Virtual Postal Services.";

    			$reminder 				= new \App\Models\AccountReminder;
		        $reminder->subject   	= 'Account Activate';
		        $reminder->message  	= $message;
		        $reminder->user_id  	= $user->id;
		        $reminder->save();


		        $notify = new SendSMSController();
                $notify->sendSms($user->phone, $message); 

    		}
    	}

    	echo "Inserted";
    }

    public function onceEveryThreeMinutes(){


    	$created_code_array = DB::table('users')
                                ->where('created_at', '<', Carbon::now()->subYears(1))
                                ->pluck('created_at');        


    	foreach($created_code_array as $date){

    		$cDate = Carbon::parse($date);
			$months = $cDate->diffInMonths();

            $day = $cDate->addyear();
            $expiryDay  = $day->toDateString();

            $users = DB::table('users')->where('created_at', $date)->get();

            foreach($users as $user){

                $message = "Dear ".$user->first_name.", your PO Box Number ".$user->postbox_id."-".$user->postcode_id.", ".$user->town." is expiring on ".$expiryDay." kindly arrange to pay for renewal.";                


                $reminder               = new \App\Models\RenewalReminder;
                $reminder->subject      = 'Account Renewal';
                $reminder->message      = $message;
                $reminder->user_id      = $user->id;
                $reminder->save();

                $phone = DB::table('users')->where('created_at', $date)->value('phone');

                $notify = new SendSMSController();
                $notify->sendSms($phone, $message); 
            }

    	}
    	
    }

    public function getReminderAttribute($date)
	{
	    $carbonReminder = new Carbon($date);
	    //$carbonReminder->setToStringFormat('d/m/Y H:i');
	    //$carbonReminder->toDateTimeString();
	    $carbonReminder->diffForHumans();
	    
	    return $carbonReminder;
	}
}
