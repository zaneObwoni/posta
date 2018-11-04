<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Picking as Picking;
use App\Models\Notification as Notification;

use Auth, DB, Input, Validator, Session, Request, Redirect;

use App\Models\Email as Email;
use App\Models\SMS as SMS;

class PickingController extends Controller
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

        $pickings = Picking::where('user_id', $id)->get();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.pickings.index', compact('user', 'pickings', 'notifications', 'notifications_count'));
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
        $senderName = $senderFirstName . " " . $senderLastName;

        $notifications = Notification::where('recipient_phone', $senderPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $senderPhone)->count();

        $destination_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');
        $destination_codes = \DB::table('post_codes')->orderBy('number', 'asc')->lists('number', 'number');

        $delivery_rates = \DB::table('delivery_rates')->orderBy('id', 'asc')->lists('name', 'price');

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        $weight = "10 KGS";
        $code = $code;

        return view('backend.pickings.create', compact('code', 'user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName', 'delivery_rates', 'weight'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        $input = Input::all();

        if (!empty($input['picking_select'])) {
            $picking_type = $input['picking_type'];
            $code = $input['stamp_code'];


            if ($picking_type == 1) //Picking type normal 1
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
                $code = $code;
                $pick = $picking_type;

                return view('backend.pickings.create', compact('pick', 'code', 'user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName', 'delivery_rates', 'weight'));
            } // Picking type equla 2 EMS
            else {
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
                $code = $code;
                $pick = $picking_type;

                return view('backend.pickings.create', compact('pick', 'code', 'user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName', 'delivery_rates', 'weight'));


            }

        }

        $validator = Validator::make($input, Picking::$rules);

        if ($validator->fails()) {
            Session::flash('message', 'Error Creating Picking Details!');

            return Redirect::back()->withInput()
                ->withErrors($validator)
                ->with('message', 'There were Input errors.');

        } else {
            // store
            $picking = new \App\Models\Picking;

            $picking->building_name = Input::get('building_name');
            $picking->street = Input::get('street');
            $picking->town = Input::get('town');
            $picking->weight = Input::get('weight');
            $picking->phone = Auth::user()->phone;
            $picking->fullname = Auth::user()->first_name." ".Auth::user()->last_name;
            $picking->amount = Input::get('amount');

            $key = \Config::get('app.key');
            $generatedCode = hash_hmac('sha256', str_random(40), $key);

            $picking->code = "PICKING";
            $picking->stamp_code = Input::get('stamp_code');

            $picking->category         = Input::get('category');

            if($picking->category == 'NORMAL'){
                $picking->sub_category     = "None";
            }else{
                
                $picking->sub_category     = Input::get('sub_category');
                $picking->distance         = Input::get('distance');
                $picking->extra_weight     = Input::get('weight');
            }

            $picking->rider_no = 1;
            $picking->user_id = Auth::user()->id;
            $picking->active = 0;


            $user_delivery = DB::table('pickings')
                ->where('user_id', '=', Auth::user()->id)
                ->where('stamp_code', '=', Input::get('stamp_code'))
                ->exists();

            if ($user_delivery) {

                // redirect
                return redirect()->route('pickings.show', $picking->id)
                    ->with('message', 'Your Parcel is in the process of being Picked!');

            } else {

                $picking->save();                

                // redirect
                return redirect()->route('pickings.show', $picking->id)
                    ->with('message', 'Successfully Created delivery!');
            }

        }
    }

    //Show picking type Ems or normal

    public function create_select($code, $picking_type)
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
        $code = $code;
        $pick = $picking_type;

        return view('backend.pickings.create', compact('pick', 'code', 'user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName', 'delivery_rates', 'weight'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $picking = Picking::find($id);

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.pickings.show', compact('user', 'picking', 'notifications', 'notifications_count'));
    }

    public function general_picking_delivery_get()
    {
        //dd('Okay');
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $recipientPhone = Auth::user()->phone;
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
        return view('backend.pickings.picking_delivery', compact('user', 'picking', 'notifications', 'notifications_count'));
    }
    public  function general_picking_delivery_save()
    {
        $input = Input::all();

        // store
        $picking = new \App\Models\Picking;
//Picking details
        $picking->building_name = Input::get('building_name');
        $picking->street = Input::get('street');
        $picking->town = Input::get('town');
        $picking->weight = Input::get('means');
        $picking->phone = Auth::user()->phone;
        $picking->fullname = Auth::user()->first_name." ".Auth::user()->last_name;
        $picking->amount = 10;
        // $picking->amount = Input::get('cost');

        //Delivery details
        $picking->d_building_name = Input::get('d_building_name');
        $picking->d_street = Input::get('d_street');
        $picking->d_town = Input::get('d_town');

        $key = \Config::get('app.key');
        $generatedCode = hash_hmac('sha256', str_random(40), $key);
        $picking->stamp_code=$generatedCode;
        $picking->save();
        return redirect()->route('pickings.show', $picking->id)
            ->with('message', 'Successfully Created!');
        // dd(strtoupper($generatedCode), 10);
       // dd($input);
    }

}
