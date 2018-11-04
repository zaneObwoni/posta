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

class EMSController extends Controller
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

        $estamps = Estamp::where('user_id', $id)->where('status', 1)->get();
        
        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        // $qrcode = QrCode::format('png')->size(399)->color(40,40,40)->generate('Make me a QrCode!');

        return view('backend.estamps.index', compact('user', 'estamps', 'notifications', 'notifications_count'));
    }

    //Ems estamps pickings and delivery
    public function create()
    {

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $senderPhone = Auth::user()->phone;
        $senderFirstName = Auth::user()->first_name;
        $senderLastName = Auth::user()->last_name;
        $senderName = $senderFirstName . " " . $senderLastName;

        $notifications = Notification::where('recipient_phone', $senderPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $senderPhone)->count();

        $destination_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');
        $destination_codes = \DB::table('post_codes')->orderBy('number', 'asc')->lists('number', 'number');

        $delivery_rates = \DB::table('delivery_rates')->orderBy('id', 'asc')->lists('name', 'price');

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        $weight = "10 KGS";

        return view('backend.ems.create', compact( 'user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName', 'delivery_rates', 'weight'));
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

        $rules = array(

                'd_street'          => 'required',
                'd_town'          => 'required',  
                'recipient_phone'          => 'required',
                'recipient_name'          => 'required',

                'town'          => 'required',
                'weight'          => 'required',
                'amount'          => 'required',
                'building_name'          => 'required',
                'street'          => 'required',
                'town'          => 'required',
                'category'          => 'required',
            
            );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {

            return redirect()->back()
                        ->withErrors($validator->errors());
            // return Redirect::back()->withInput()
	           //   ->withErrors($validator)
	           //   ->with($validator->errors());

        } else {

            // store
            $estamp 					= new Estamp;
            $estamp->category           = Input::get('category');
            $estamp->sender_phone       = Auth::user()->phone;
            $estamp->sender_name        = Auth::user()->first_name." ".Auth::user()->last_name;
            $estamp->destination_box    = Input::get('d_street');
            $estamp->destination_code   = Input::get('d_town');
            $estamp->recipient_phone    = Input::get('recipient_phone');
            $estamp->recipient_name     = Input::get('recipient_name');
            $estamp->origin_town        = Input::get('town');
            $estamp->destination_town   = Input::get('d_town');

            $estamp->letter_weight      = Input::get('weight');

            $estamp->price              = Input::get('amount');
        

            $key = \Config::get('app.key');
            $generatedCode = hash_hmac('sha256', str_random(40), $key);

            $estamp->code               = substr(strtoupper($generatedCode), 0, 10);
         
            $estamp->user_id            = Auth::user()->id;
            $estamp->active         	= 1;
         
            $estamp->save();

            // store
            $picking = new \App\Models\Picking;

            $picking->building_name = Input::get('building_name');
            $picking->street        = Input::get('street');
            $picking->town          = Input::get('town');

            $picking->d_building_name = Input::get('d_building_name');
            $picking->d_street        = Input::get('d_street');
            $picking->d_town          = Input::get('d_town');

            $picking->weight        = Input::get('weight');
            $picking->phone         = Auth::user()->phone;
            $picking->fullname      = Auth::user()->first_name." ".Auth::user()->last_name;
            $picking->amount        = Input::get('amount');

            $key = \Config::get('app.key');
            $generatedCode = hash_hmac('sha256', str_random(40), $key);

            $picking->code          = "PICKING";
            $picking->stamp_code    = $estamp->code;

            $picking->category      = Input::get('category');

            if(Input::get('sub_category') == 1)
                $picking->sub_category     = "Bahasha Kasha (Domestic Document Express)";
            if(Input::get('sub_category') == 2)
                $picking->sub_category     = "EMS (Overnight)";
            if(Input::get('sub_category') == 3)
                $picking->sub_category     = "EMS BAG RATE - Overnight";
            if(Input::get('sub_category') == 4)
                $picking->sub_category     = "EMS BULK RATE";
            if(Input::get('sub_category') == 5)
                $picking->sub_category     = "EMS (Nairobi to selected Destination By Road)";
            if(Input::get('sub_category') == 6)
                $picking->sub_category     = "EMS (Nairobi to selected Destination by Air)";

            $picking->distance      = Input::get('distance');
            $picking->extra_weight  = Input::get('weight');

            $picking->rider_no      = 1;
            $picking->user_id       = Auth::user()->id;
            $picking->active        = 0;
            $picking->save();


            // Notification for EMS
            $notification                   = new \App\Models\Notification;
            $notification->title            = "Letter from ".$estamp->sender_phone."";
            $notification->content          = "There is a letter for you from ".$estamp->sender_phone."; 
                                             Kindly arrange to pick it from your Box Number ".$estamp->destination_box."-".$estamp->destination_code." in ".$estamp->destination_town.".";
            $notification->sender_phone     = $estamp->sender_phone;
            $notification->recipient_phone  = $estamp->recipient_phone;            

            $notification->save();

            // redirect
            Session::flash('message', 'Successfully created EMS!');            

            return redirect()->route('ems.show', $estamp->id)
                ->with('message', 'Successfully created EMS Stamp!');

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

        $estamp = Estamp::find($id);

        $picking = DB::table('pickings')->where('stamp_code', $estamp->code)->first();

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

        return view('backend.ems.show', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking'));
    }


    public function download()
    {


        if(Auth::User()->isUser()){
            $user_id = Auth::user()->id;
            $estamp = DB::table('estamps')->where('user_id', $user_id)->orderBy('id', 'desc')->first();
            $picking = DB::table('pickings')->where('stamp_code', $_GET['code'])->first();

            Estamp::where('code', $_GET['code'])->update(array('status' => 1));

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

            return view('backend.ems.stamp', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking'));

        }if(Auth::User()->isAgent()){
            $user_id = Auth::user()->id;
            $estamp = DB::table('estamps')->where('user_id', $user_id)->orderBy('id', 'desc')->first();

            $picking = DB::table('pickings')->where('stamp_code', $estamp->code)->first();
            // dd($last_record);

            Estamp::where('code', $_GET['code'])->update(array('status' => 1));
            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

            return view('backend.ems.stamp', compact('user', 'estamp', 'notifications', 'notifications_count'));

        }elseif(Auth::User()->isCorporate()){

            $userId = Auth::user()->id;
            $user = User::where('id', $userId)->first();

            $estamp = DB::table('estamps')->where('user_id', $userId)->orderBy('id', 'desc')->first();

            $picking = DB::table('pickings')->where('stamp_code', $_GET['code'])->first();
            // dd($picking);

            $matchThese = ['code' => $_GET['code'], 'user_id' => $userId];

            $estamp   = Estamp::where($matchThese)->first();

            Estamp::where('code', $_GET['code'])->update(array('status' => 1));

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

            return view('backend.ems.stamp', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking'));
        }

    }

}