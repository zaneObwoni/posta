<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Box as Box;
use App\Models\Bestwish as Bestwish;
use App\Models\Contact as Contact;
use App\Models\Notification as Notification;

use Auth, DB, Input, Validator, Session, Request, Redirect;

use QrCode;

use Carbon\Carbon;

class BoxController extends Controller
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

        $boxes = Box::paginate(25);

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        return view('backend.admin.boxes.index', compact('user', 'boxes', 'notifications', 'notifications_count'));
    }


    public function pmBoxes()
    {

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $boxes = Box::where('post_code', $user->postcode_id)->paginate(25);

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        return view('backend.admin.boxes.index', compact('user', 'boxes', 'notifications', 'notifications_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $senderPhone = Auth::user()->phone;
        $senderFirstName = Auth::user()->first_name;
        $senderLastName = Auth::user()->last_name;
        $senderName = $senderFirstName." ".$senderLastName;

        $seasons = \DB::table('seasons')->lists('name', 'name');

        $notifications = Notification::where('recipient_phone', $senderPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $senderPhone)->count();  

        $destination_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');
        $destination_codes = \DB::table('post_codes')->orderBy('number', 'asc')->lists('number', 'number');

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        return view('backend.admin.boxes.create', compact('user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'seasons', 'senderName'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $input = Input::all();

        $validator = Validator::make($input, Bestwish::$rules);

        if ($validator->fails()) {

        	Session::flash('message', 'Error Creating stamp!');
        	Session::flash('errors', 'Error Creating stamp!');
        	$errors = "Errors";
        	$messages = "Messages";

            // return redirect()->route('boxes.create')
            //     ->withErrors($validator->errors());
            return Redirect::back()->withInput()
	             ->withErrors($validator)
	             ->with('message', 'There were Input errors.');

        } else {
            // store
            $estamp 					= new Bestwish;
            $estamp->sender_phone       = Auth::user()->phone;
            $estamp->sender_name        = Auth::user()->first_name." ".Auth::user()->last_name;
            $estamp->season             = Input::get('season');
            $estamp->recipient_box      = Input::get('recipient_box');
            $estamp->recipient_code     = Input::get('recipient_code');
            $estamp->recipient_name     = Input::get('recipient_name');
            $estamp->recipient_town     = Input::get('recipient_town');

            $estamp->letter_weight      = Input::get('letter_weight');

            $estamp->recipient_email    = $estamp->recipient_box.'-'.$estamp->recipient_code.'@posta.co.ke';
            $estamp->message            = Input::get('message');

            $letter_weight              = $estamp->letter_weight;

            $price = 0;


            if($letter_weight == 'Up to 20g - Ksh. 35')
                $price = 35;

            if($letter_weight == 'Over 20g up to 50g - Ksh. 50')
                $price = 50;

            if($letter_weight == 'Over 50g up to 100g - Ksh. 55')
                $price = 55;            

            if($letter_weight == 'Over 100g up to 250g - Ksh. 65')
                $price = 65;

            if($letter_weight == 'Over 250g up to 500g - Ksh. 110')
                $price = 110;

            if($letter_weight == 'Over 500g up to 1kg - Ksh. 165')
                $price = 165;

            if($letter_weight == 'Over 1kg up to 2kg - Ksh. 230')
                $price = 230;
        

            $key = \Config::get('app.key');
            $generatedCode = hash_hmac('sha256', str_random(40), $key);

            $estamp->code               = strtoupper($generatedCode);
            $estamp->price         		= $price;
            $estamp->user_id            = Auth::user()->id;
            $estamp->active         	= 1;

            $estamp->save();

            // dd("saved");

            // $notification                   = new \App\Models\Notification;
            // $notification->title            = "Letter from ".$estamp->sender_phone."";
            // $notification->content          = "There is a letter for you from ".$estamp->sender_phone." Kindly arrange to pick it from your Box Number ".$estamp->destination_box."-".$estamp->destination_code." in ".$estamp->destination_town.".";
            // $notification->sender_phone     = $estamp->sender_phone;
            // $notification->recipient_phone  = $estamp->recipient_phone;            
            // $notification->save();

            // redirect
            Session::flash('message', 'Successfully created estamp!');            

            return redirect()->route('admin.boxes.show', $estamp->id)
                ->with('message', 'Successfully created estamp!');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $estamp = Bestwish::find($id);

        $estamp = Bestwish::where('id', $id)->first();

        // $picking = DB::table('pickings')->where('stamp_code', $estamp->code)->first();

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

        return view('backend.admin.boxes.show', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking'));
    }

    public function download()
    {

        if(Auth::User()->isUser()){

            $user_id = Auth::user()->id;
            $estamp = DB::table('post_boxes')->where('user_id', $user_id)
                ->where('code', $_GET['code'])
                ->orderBy('id', 'desc')->first();
            // dd($estamp );

            // $picking = DB::table('pickings')->where('stamp_code', $_GET['code'])->first();

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

            return view('backend.admin.boxes.download', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking'));

        }

        if(Auth::User()->isAgent()){
            $user_id = Auth::user()->id;
            $estamp = DB::table('boxes')->where('user_id', $user_id)->orderBy('id', 'desc')->first();

            $picking = DB::table('pickings')->where('stamp_code', $estamp->code)->first();
            // dd($last_record);

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

            return view('backend.boxes.stamp', compact('user', 'estamp', 'notifications', 'notifications_count'));

        }

    }

    public function destroy($id){

        $input = Input::all();

        $estamp = Estamp::find($id);    
        $estamp->delete();

        return redirect()->back();
    }

}

