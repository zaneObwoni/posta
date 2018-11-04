<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Estamp as Estamp;
use App\Models\Registered as Registered;
use App\Models\Notification as Notification;

use Auth, DB, Input, Validator, Session, Request, Redirect;

use QrCode;
use Carbon\Carbon;

class RegisteredController extends Controller
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

        $registers = Registered::where('user_id', $id)->get();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        // $qrcode = QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

        return view('backend.registers.index', compact('user', 'registers', 'notifications', 'notifications_count'));
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

        $notifications = Notification::where('recipient_phone', $senderPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $senderPhone)->count();  

        $destination_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');
        $destination_codes = \DB::table('post_codes')->orderBy('number', 'asc')->lists('number', 'number');

        $postage_rates = \DB::table('registered_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        return view('backend.registers.create', compact('user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName'));
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

        // dd($input);

        $validator = Validator::make($input, Registered::$rules);

        if ($validator->fails()) {

            return redirect()->route('registers.create')
                ->withErrors($validator->errors());

        } else {
            // store
            $registered                     = new \App\Models\Estamp;
            $registered->category           = 'REGISTERED';
            $registered->sender_phone       = Auth::user()->phone;
            $registered->sender_name        = Auth::user()->first_name." ".Auth::user()->last_name;
            $registered->destination_box    = Input::get('destination_box');
            $registered->destination_code   = Input::get('destination_code');
            $registered->recipient_phone    = Input::get('recipient_phone');
            $registered->recipient_name     = Input::get('recipient_name');
            $registered->origin_town        = Input::get('origin_town');
            $registered->destination_town   = Input::get('destination_town');

            $registered->letter_weight      = Input::get('letter_weight');

            $letter_weight              = $registered->letter_weight;

            $price = 0;


            if($letter_weight == 'Up to 20g - Ksh. 20')
                $price = 20;

            if($letter_weight == 'Over 20g up to 50g - Ksh. 50')
                $price = 50;

            if($letter_weight == 'Over 50g up to 100g - Ksh. 155')
                $price = 155;            

            if($letter_weight == 'Over 100g up to 250g - Ksh. 650')
                $price = 650;

            if($letter_weight == 'Over 250g up to 500g - Ksh. 1101')
                $price = 1101;

            if($letter_weight == 'Over 500g up to 1kg - Ksh. 1165')
                $price = 1165;

            if($letter_weight == 'Over 1kg up to 2kg - Ksh. 2130')
                $price = 2130;
        

            $key = \Config::get('app.key');
            $generatedCode = hash_hmac('sha256', str_random(40), $key);

            $registered->code               = strtoupper($generatedCode);
            // $price = $distance_cost * $letter_weight;
            $registered->price              = $price;
            $registered->user_id            = Auth::user()->id;
            $registered->active             = 1;
         
            // dd($registered);
            $registered->save();

            // Registered Mail Notification to User shoould be added.
            // By Lee - See Above - Below should not sent notification before payment.

            $notification                   = new \App\Models\Notification;
            $notification->title            = "Letter from ".$registered->sender_phone."";
            $notification->content          = "There is a letter for you from ".$registered->sender_phone."; 
                                             Kindly arrange to pick it from your Box Number ".$registered->destination_box."-".$registered->destination_code." in ".$registered->destination_town.".";
            $notification->sender_phone     = $registered->sender_phone;
            $notification->recipient_phone  = $registered->recipient_phone;            

            $notification->save();

            // redirect
            Session::flash('message', 'Successfully created registered!');            

            return redirect()->route('estamps.show', $registered->id)
                ->with('message', 'Successfully created registered!');

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

        $registered = Registered::find($id);

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

        return view('backend.registers.show', compact('user', 'registered', 'notifications', 'notifications_count'));
    }


    public function download()
    {

        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        $code = $_GET['code'];
        $matchThese = ['user_id' => $userId, 'code' => $code, 'active' => 1];

        $estamp  = Estamp::where($matchThese)->first();
        
        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

        return view('backend.registers.stamp', compact('user', 'notifications', 'notifications_count', 'picking', 'estamp'));
  
    }

  }
