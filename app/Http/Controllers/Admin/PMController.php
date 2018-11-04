<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use App\Models\User as User;
use App\Models\Estamp as Estamp;
use App\Models\Staff as Staff;
use App\Models\Delivery as Delivery;
use App\Models\Email as Email;
use App\Models\Notification as Notification;

use App\Models\Picking as Picking;
use App\Models\PickingMail as PickingMail;

use App\Http\Controllers\SendSMSController as SendSMSController;

use App\Models\SMS as SMS;

use Input, DB, Validator, Session, Redirect;

class PMController extends Controller
{
    //


    public function dashboard()
    {

        $user = Auth::user();

        $recipientPhone         = Auth::user()->phone;
        $recipientEmail         = Auth::user()->email;

        $notifications          = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count    = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count   = Email::where('to', $recipientEmail)->count();

        $drivers        = Staff::all()->count();
        $staff          = User::where('staff', 1)->count();

        $matchThese     = ['staff' => 0, 'active' => 1, 'postcode_id' => $user->postcode_id];

        $users          = User::where($matchThese)->count();
        $letters        = Estamp::where('status',1)->where('destination_code', $user->postcode_id)->count();
        $estamps_sum    = Estamp::where('destination_code', $user->postcode_id)->sum('price');
        $accounts_sum   = $users * 600;
        $letters_sum    = $letters * 1;
        $total_emails   = Email::all()->count();

        $normalRentors  = User::whereHas('roles', function ($q) {
                                $q->where('name', 'User');
                            })->where('postcode_id', $user->postcode_id)->count();

        $corporateRentors = User::whereHas('roles', function ($q) {
                                $q->where('name', 'Corporate');
                            })->where('postcode_id', $user->postcode_id)->count();

        return view('backend.pm.dashboard', compact(
            'user', 'notifications', 'notifications_count', 'emails_count', 'staff', 'users', 
            'drivers', 'letters', 'estamps_sum', 'accounts_sum', 'total_emails', 'normalRentors', 'corporateRentors'
            ));
    }

    public function corporates()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'Corporate');
        })->get();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        return view('backend.admin.corporates.index', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count'));
    }

    public function users()
    {
        if(Auth::User()->isPostMaster()){
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'User');
            })
                ->where('postcode_id',Auth::user()->postcode_id)
                ->get();
        }
        else
        {
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'User');
            })->orderBy('created_at', 'desc')->get();
        }

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        return view('backend.admin.users.index', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count'));
    }

    public function staff()
    {

        $user = Auth::user();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        $users = User::where('staff', 1)->where('postcode_id', $user->postcode_id)->get();


        return view('backend.admin.staffs.index', compact('users', 'notifications', 'notifications_count', 'emails_count'));
    }

    public function emails()
    {

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        // dd(DB::table('users')->where('email', $recipientEmail)->value('first_name'));
        
        $emails = Email::where('from', $recipientEmail)->orderBy('id', 'desc')->get();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;  


        return view('backend.admin.emails.index', compact('user', 'notifications', 'notifications_count', 'emails', 'notifications_emails'));
    }

    public function notifications()
    {

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        // dd(DB::table('users')->where('email', $recipientEmail)->value('first_name'));
        
        $notifications = Notification::all();
        // dd($notifications);

        // $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;  


        return view('backend.admin.notifications.index', compact('user', 'notifications', 'notifications_count', 'emails', 'notifications_emails'));
    }

    public function showEstampSoldByTown()
    {

        $estamps = Estamp::where('status',1)->get();
        //dd($estamps[0]);
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        //Add a notification here

        $emails_count = Email::where('to', $recipientEmail)->count();
        return view('backend.estamps.stampsold', compact('estamps','user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));
    }
}
