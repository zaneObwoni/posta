<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Picking as Picking;

use App\Models\PickingMail as PickingMail;
use App\Models\Notification as Notification;

use Auth, DB, Input, Validator, Session, Request, Redirect;

class PickingMailController extends Controller
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

        $pickingmails = PickingMail::where('user_id', $id)->get();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        return view('backend.pickingmails.index', compact('user', 'pickingmails', 'notifications', 'notifications_count'));
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

        $delivery_rates = \DB::table('delivery_rates')->orderBy('id', 'asc')->lists('name', 'price');

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        $weight = "10 KGS";
        return view('backend.pickingmails.create', compact('user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName', 'delivery_rates', 'weight'));
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

        $validator = Validator::make($input, PickingMail::$rules);

        if ($validator->fails()) {
        	Session::flash('message', 'Error Creating PickingMail Details!');

            return Redirect::back()->withInput()
	             ->withErrors($validator)
	             ->with('message', 'There were Input errors.');

        } else {


            // store
            $pickingmail 				    = new \App\Models\PickingMail;
            
            $pickingmail->name              = Input::get('name');
            $pickingmail->id_number         = Input::get('id_number');
            $pickingmail->phone             = Input::get('phone');
            $pickingmail->stamp_code        = strtoupper(Input::get('stamp_code'));

            $key = \Config::get('app.key');
            $generatedCode = hash_hmac('sha256', str_random(40), $key);

            $pickingmail->tracking_code     = strtoupper($generatedCode);
         
            $pickingmail->save();

            // redirect
            Session::flash('message', 'Successfully Created picking!');            

            return redirect()->route('mail.show', $pickingmail->id)
                ->with('message', 'Successfully Created picking!');

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

        $pickingmail = PickingMail::find($id);

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

        return view('backend.pickingmails.show', compact('user', 'pickingmail', 'notifications', 'notifications_count'));
    }


}
