<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Estamp as Estamp;
use App\Models\Contact as Contact;
use App\Models\Notification as Notification;

use App\Models\Picking as Picking;
use App\Models\Delivery as Delivery;
use App\Models\Staff as Staff;
use App\Models\Email as Email;

use Auth, DB, Input, Validator, Session, Request, Redirect;

class ReportsController extends Controller
{

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estamps = Estamp::where('status',1)->get();

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        //Add a notification here

        $emails_count = Email::where('to', $recipientEmail)->count();
        return view('backend.reports.index', compact('estamps','user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));

        // return view('backend.reports.index', compact('user', 'notifications', 'notifications_count'));
    }

    public function estampsReports($startDate, $endDate)
    {

        $estamps = Estamp::where('status',1)->whereBetween('created_at', [$startDate, $endDate])->get();
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
        return view('backend.admin.stamps.index', compact('estamps','user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));

    }

    public function usersReports($startDate, $endDate)
    {

        $estamps = User::where('status',1)->whereBetween('created_at', [$startDate, $endDate])->get();
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
        return view('backend.admin.reports.users', compact('estamps','user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));

    }

    public function deliveriesReports($startDate, $endDate)
    {

        $deliveries = Delivery::whereBetween('created_at', [$startDate, $endDate])->get();

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        //Add a notification here

        $emails_count = Email::where('to', $recipientEmail)->count();
        return view('backend.admin.reports.deliveries', compact('deliveries','user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));

    }

    public function pickingsReports($startDate, $endDate)
    {

        $pickings = Picking::whereBetween('created_at', [$startDate, $endDate])->get();

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        //Add a notification here

        $emails_count = Email::where('to', $recipientEmail)->count();
        return view('backend.admin.reports.picking', compact('pickings','user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));

    }

    public function staffReports($startDate, $endDate)
    {

        $staff_reports = Staff::where('status',1)->whereBetween('created_at', [$startDate, $endDate])->get();

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        //Add a notification here

        $emails_count = Email::where('to', $recipientEmail)->count();
        return view('backend.admin.reports.staff', compact('staff_reports','user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));

    }

}
    