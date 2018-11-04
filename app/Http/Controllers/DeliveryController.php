<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Delivery as Delivery;
use App\Models\Notification as Notification;

use App\Models\SMS as SMS;

use App\Models\Email as Email;

use Auth, DB, Input, Validator, Session, Request, Redirect;

class DeliveryController extends Controller
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

        $deliveries = Delivery::where('user_id', $id)->get();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        return view('backend.deliveries.index', compact('user', 'deliveries', 'notifications', 'notifications_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($code)
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

        $delivery_rates = \DB::table('delivery_rates')->orderBy('id', 'asc')->lists('name', 'price');

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        $code = $code;

        return view('backend.deliveries.create', compact('user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName', 'delivery_rates', 'code'));
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

        if (!empty($input['delivery_select'])) {
            $delivery = $input['delivery_type'];
            $code = $input['stamp_code'];

            // If delivery is NORMAL DELIVERY
            if($delivery == 1)
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

                $delivery_rates = \DB::table('delivery_rates')->orderBy('id', 'asc')->lists('name', 'price');

                $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
                $towns = \DB::table('towns')->lists('name', 'name');

                $code = $code;                              

                return view('backend.deliveries.create', compact('delivery','user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName', 'delivery_rates', 'code'));

            }            
            else // Else delivery is EMS
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

                $delivery_rates = \DB::table('delivery_rates')->orderBy('id', 'asc')->lists('name', 'price');

                $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
                $towns = \DB::table('towns')->lists('name', 'name');

                $code = $code;

                return view('backend.deliveries.create', compact('delivery','user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName', 'delivery_rates', 'code'));


            }

        }

        $validator = Validator::make($input, Delivery::$rules);

        if ($validator->fails()) {
        	Session::flash('message', 'Error Creating Delivery Details!');

            return Redirect::back()->withInput()
	             ->withErrors($validator)
	             ->with('message', 'There were Input errors.');

        } else {

            // store
            $delivery 					= new \App\Models\Delivery;
            
            $delivery->building_name    = Input::get('building_name');
            $delivery->street           = Input::get('street');
            $delivery->town             = Input::get('town');

            $delivery->phone            = Auth::user()->phone;
            $delivery->fullname         = Auth::user()->first_name." ".Auth::user()->last_name;

            $delivery->amount           = Input::get('amount');

            $key = \Config::get('app.key');
            $generatedCode = hash_hmac('sha256', str_random(40), $key);

            $delivery->code             = $generatedCode;
            $delivery->stamp_code       = Input::get('stamp_code');

            $delivery->category         = Input::get('category');

            if($delivery->category == 'NORMAL'){
                $delivery->sub_category     = "None";
            }else{
                $delivery->sub_category     = Input::get('sub_category');
                $delivery->distance         = Input::get('distance');
                $delivery->extra_weight     = Input::get('weight');
            }

            $delivery->rider_no         = 0;
            $delivery->user_id          = Auth::user()->id;    
            $delivery->active         	= 0;
         
            $user_delivery = DB::table('deliveries')
                ->where('user_id', '=', Auth::user()->id)
                ->where('stamp_code', '=', Input::get('stamp_code'))
                ->exists();

            if($user_delivery){

                // redirect
                return redirect()->route('deliveries.show', $delivery->id)
                    ->with('message', 'Your Parcel is in the process of being delivered!');

            }else{

                $delivery->save();

                // redirect
                Session::flash('message', 'Successfully Created delivery!');            

                return redirect()->route('deliveries.show', $delivery->id)
                    ->with('message', 'Successfully Created delivery!');
            }
                        
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

        $delivery = Delivery::find($id);

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

        return view('backend.deliveries.show', compact('user', 'delivery', 'notifications', 'notifications_count'));
    }


}
