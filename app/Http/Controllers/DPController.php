<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Estamp as Estamp;
use App\Models\Contact as Contact;
use App\Models\Notification as Notification;

use App\Models\Picking as Picking;

use Auth, DB, Input, Validator, Session, Request, Redirect;

class DPController extends Controller
{
    
    public function dpLanding()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.dp.landing', compact('user', 'notifications', 'notifications_count'));
    }

    public function backofficeDelivery()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.dp.backoffice', compact('user', 'notifications', 'notifications_count'));
    }
}
