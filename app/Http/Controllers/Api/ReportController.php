<?php

namespace App\Http\Controllers\Api;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User as User;
use App\Models\Estamp as Estamp;
use App\Models\Contact as Contact;
use App\Models\Notification as Notification;

use App\Models\Picking as Picking;
use App\Models\Delivery as Delivery;
use App\Models\Staff as Staff;
use App\Models\Email as Email;

use Auth, DB, Input, Validator, Session, Request, Redirect, Response;

class ReportController extends Controller
{

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estamps = Estamp::where('status',1)->count();
        $drivers = Staff::all()->count();
        $staff   = User::where('staff', 1)->count();
        $emails   = Email::all()->count();

        $deliveries = Delivery::all()->count();
        $pickings = Picking::all()->count();

        $individualBoxes = User::whereHas('roles', function($q)
        {
            $q->where('name', 'User');
        })->count();

        $corporateBoxes = User::whereHas('roles', function($q)
        {
            $q->where('name', 'Corporate');
        })->count();

        $estampsSold =  Estamp::all()->sum('price');

        $normalRentorSum = $individualBoxes * 600;
        $corporateRentorSum = $corporateBoxes * 2000;
        $boxesSold 	= $normalRentorSum + $corporateRentorSum;

        $result = array();

		$data = 
	        array(
	            'stamps' 			=> $estamps,
	            'drivers' 			=> $drivers,
	            'staff' 			=> $staff,
	            'email' 			=> $emails,
	            'individual_boxes' 	=> $individualBoxes,
	            'corporate_boxes' 	=> $corporateBoxes,
	            'deliveries'		=> $deliveries,
	            'pickings'			=> $pickings,
	            'estamps_sold'		=> $estampsSold,
	            'boxes_sold'  		=> $boxesSold
	        );

    	$result[] = $data;
		    
        return Response::json([
			$data
		], 200);
    }

    public function branchManager($postcode)
    {
        $estamps = Estamp::where('status',1)->where('destination_code', $postcode)->count();
        $drivers = Staff::all()->where('postcode', $postcode)->count();
        $staff   = User::where('staff', 1)->where('postcode_id', $postcode)->count();

        $individualBoxes = User::whereHas('roles', function($q)
        {
            $q->where('name', 'User');
        })->where('postcode_id', $postcode)->count();

        $corporateBoxes = User::whereHas('roles', function($q)
        {
            $q->where('name', 'Corporate');
        })->where('postcode_id', $postcode)->count();

        $estampsSold =  Estamp::all()->where('destination_code', $postcode)->sum('price');

        $normalRentorSum = $individualBoxes * 600;
        $corporateRentorSum = $corporateBoxes * 2000;
        $boxesSold  = $normalRentorSum + $corporateRentorSum;

        $result = array();

        $data = 
            array(
                'stamps'            => $estamps,
                'drivers'           => $drivers,
                'staff'             => $staff,
                'individual_boxes'  => $individualBoxes,
                'corporate_boxes'   => $corporateBoxes,
                'estamps_sold'      => $estampsSold,
                'boxes_sold'        => $boxesSold
            );

        $result[] = $data;
            
        return Response::json([
            $data
        ], 200);
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
