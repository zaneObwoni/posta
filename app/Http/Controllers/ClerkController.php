<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Estamp as Estamp;
use App\Models\Contact as Contact;
use App\Models\Notification as Notification;

use App\Models\Picking as Picking;

use Auth, DB, Input, Validator, Session, Request, Redirect;

use QrCode;

use Carbon\Carbon;

class ClerkController extends Controller
{
    
	public function clerkLanding()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.landing', compact('user', 'notifications', 'notifications_count'));
    }

    public function sendLetter()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.search.sender-letter', compact('user', 'notifications', 'notifications_count'));
    }

    public function receiveLetter()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.search.receive-letter', compact('user', 'notifications', 'notifications_count'));
    }

    public function expiredLetter()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.search.expired-letter', compact('user', 'notifications', 'notifications_count'));
    }

    public function underpaidLetter()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.search.underpaid-letter', compact('user', 'notifications', 'notifications_count'));
    }

    public function sendParcel()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.search.sender-parcel', compact('user', 'notifications', 'notifications_count'));
    }

    public function receiveParcel()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.search.receive-parcel', compact('user', 'notifications', 'notifications_count'));
    }

    public function expiredParcel()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.search.expired-parcel', compact('user', 'notifications', 'notifications_count'));
    }

    public function underpaidParcel()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.search.underpaid-parcel', compact('user', 'notifications', 'notifications_count'));
    }

    public function sendEms()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.search.sender-ems', compact('user', 'notifications', 'notifications_count'));
    }

    public function receiveEms()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.search.receive-ems', compact('user', 'notifications', 'notifications_count'));
    }

}