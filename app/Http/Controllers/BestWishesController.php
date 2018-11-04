<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Estamp as Estamp;
use App\Models\Bestwish as Bestwish;
use App\Models\Contact as Contact;
use App\Models\Notification as Notification;

use Auth, DB, Input, Validator, Session, Request, Redirect, Excel;

use QrCode;

use Carbon\Carbon;

class BestWishesController extends Controller
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

        $estamps = Bestwish::where('user_id', $id)->where('status', 1)->orderBy('id', 'DESC')->get();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();


        return view('backend.bestwishes.index', compact('user', 'estamps', 'notifications', 'notifications_count'));
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
        $senderName = $senderFirstName . " " . $senderLastName;

        $seasons = \DB::table('seasons')->lists('name', 'name');

        $notifications = Notification::where('recipient_phone', $senderPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $senderPhone)->count();

        $destination_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');
        $destination_codes = \DB::table('post_codes')->orderBy('number', 'asc')->lists('number', 'number');

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        if (!empty($_GET['id'])) {

            return view('backend.bestwishes.createbulk', compact('user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'seasons', 'senderName'));

        }

        return view('backend.bestwishes.create', compact('user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'seasons', 'senderName'));
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
        // dd($input);

        $validator = Validator::make($input, Bestwish::$rules);

        if ($validator->fails()) {

            //dd($validator);

            Session::flash('message', 'Error Creating stamp!');
            Session::flash('errors', 'Error Creating stamp!');
            $errors = "Errors";
            $messages = "Messages";

            // return redirect()->route('estamps.create')
            //     ->withErrors($validator->errors());
            return Redirect::back()->withInput()
                ->withErrors($validator)
                ->with('message', 'There were Input errors.');

        } else {
            // store
            $estamp = new Estamp;
            $estamp->sender_phone       = Auth::user()->phone;
            $estamp->sender_name        = Auth::user()->first_name . " " . Auth::user()->last_name;
            $estamp->category           = "SEASON";
            $estamp->season             = Input::get('season');
            $estamp->destination_box    = Input::get('recipient_box');
            $estamp->destination_code   = Input::get('recipient_code');
            $estamp->recipient_name     = Input::get('recipient_name');
            $estamp->recipient_phone    = Input::get('recipient_phone');
            $estamp->origin_town   = Input::get('origin_town');
            $estamp->destination_town   = Input::get('recipient_town');
            $estamp->letter_weight      = Input::get('letter_weight');
            $estamp->message            = Input::get('message');

            $letter_weight              = $estamp->letter_weight;

            $price = 0;


            if ($letter_weight == 'Up to 20g - Ksh. 35')
                $price = 35;

            if ($letter_weight == 'Over 20g up to 50g - Ksh. 50')
                $price = 50;

            if ($letter_weight == 'Over 50g up to 100g - Ksh. 55')
                $price = 55;

            if ($letter_weight == 'Over 100g up to 250g - Ksh. 65')
                $price = 65;

            if ($letter_weight == 'Over 250g up to 500g - Ksh. 110')
                $price = 110;

            if ($letter_weight == 'Over 500g up to 1kg - Ksh. 165')
                $price = 165;

            if ($letter_weight == 'Over 1kg up to 2kg - Ksh. 230')
                $price = 230;


            $key = \Config::get('app.key');
            $generatedCode = hash_hmac('sha256', str_random(40), $key);

            $estamp->code = strtoupper($generatedCode);
            $estamp->price = $price;
            $estamp->user_id = Auth::user()->id;
            $estamp->active = 1;

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

            return redirect()->route('estamps.show', $estamp->id)
                ->with('message', 'Successfully created estamp!');

        }
    }

    public function storeBulk()
    {
        $input = Input::all();


        $rules = [
            'letter_weight' => 'required',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {


            // return redirect()->route('estamps.create')
            //     ->withErrors($validator->errors());
            return Redirect::back()->withInput()
                ->withErrors($validator);
        } else {
            // store


            $key = \Config::get('app.key');
            $batch_number = hash_hmac('sha256', str_random(12), $key);


            try {

                Excel::load(Input::file('file'), function ($reader) use ($batch_number) {

//Not Looping variable

                    $estamp = new Estamp;
                    $estamp->letter_weight = Input::get('letter_weight');
                    $letter_weight = $estamp->letter_weight;

                    $price = 0;


                    if ($letter_weight == 'Up to 20g - Ksh. 35')
                        $price = 35;

                    if ($letter_weight == 'Over 20g up to 50g - Ksh. 50')
                        $price = 50;

                    if ($letter_weight == 'Over 50g up to 100g - Ksh. 55')
                        $price = 55;

                    if ($letter_weight == 'Over 100g up to 250g - Ksh. 65')
                        $price = 65;

                    if ($letter_weight == 'Over 250g up to 500g - Ksh. 110')
                        $price = 110;

                    if ($letter_weight == 'Over 500g up to 1kg - Ksh. 165')
                        $price = 165;

                    if ($letter_weight == 'Over 1kg up to 2kg - Ksh. 230')
                        $price = 230;


                    //Not looping variable


                    $array = $reader->toArray();
                    $reader->ignoreEmpty()->get();
                    foreach ($array as $row) {

                        $estamp = new Estamp;
                        $estamp->sender_phone = Auth::user()->phone;

                        $estamp->batch_number = strtoupper($batch_number);
                        $estamp->sender_name = Auth::user()->first_name . " " . Auth::user()->last_name;
                        $estamp->season = Input::get('season');
                        $estamp->recipient_town = Input::get('recipient_town');
                        $estamp->message = Input::get('message');
                        $estamp->price = $price;
                        $estamp->user_id = Auth::user()->id;
                        $estamp->active = 1;


                        //Looping variables

                        $estamp->recipient_phone = intval($row['phone']);
                        $estamp->recipient_name = $row['name'];
                        $estamp->recipient_box = intval($row['box']);
                        $estamp->recipient_code = '00' . intval($row['code']);

                        $estamp->recipient_email = $estamp->recipient_box . '-' . '00' . $estamp->recipient_code . '@posta.co.ke';


                        $key = \Config::get('app.key');
                        $generatedCode = hash_hmac('sha256', str_random(20), $key);

                        $estamp->code = strtoupper($generatedCode);


                        $estamp->save();


                        //Contact::firstOrCreate($row);


                    }

                    //$batch_number=$estamp->batch_number;

                });
                \Session::flash('success', 'Users uploaded successfully.');
                //return Redirect::back()->withMessage('Success, Data uploaded');
            } catch (\Exception $e) {
                //\Session::flash('error', $e->getMessage());
                return Redirect::back()->withErrors($e->getMessage());
                return Redirect::back()->withErrors('Your excel sheet format not correct, check sample sheet please!');
                //return redirect(route('users.index'));
            }

            Session::flash('message', 'Successfully created estamp!');
//dd($batch_number);
            return redirect()->route('bestwishes.show', $batch_number)
                ->with('message', 'Successfully created estamp!');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = $id;
        // $estamp = Bestwish::find($id);
        if (is_numeric($id)) {
            $estamp = Bestwish::where('id', $id)->first();
        } else {
            
            $estamp = Bestwish::where('batch_number', $id)->get();
        }


        // $picking = DB::table('pickings')->where('stamp_code', $estamp->code)->first();

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.bestwishes.show', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking', 'id'));
    }

    public function download()
    {
        //dd('seen');

        if (Auth::User()->isUser()) {


            $user_id = Auth::user()->id;

            if (strlen($_GET['code']) > 15)
            {
                $estamp = DB::table('bestwishes')->where('user_id', $user_id)
                    ->where('batch_number', $_GET['code'])
                    ->orderBy('id', 'desc')->get();

            }
            else
            {
            $estamp = DB::table('bestwishes')->where('user_id', $user_id)
                ->where('code', $_GET['code'])
                ->orderBy('id', 'desc')->first();
            }

            $code=$_GET['code'];
            //dd($estamp );

            // $picking = DB::table('pickings')->where('stamp_code', $_GET['code'])->first();

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;

            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

            return view('backend.bestwishes.download', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking','code'));

        }

        if (Auth::User()->isAgent()) {
            $user_id = Auth::user()->id;
            $estamp = DB::table('estamps')->where('user_id', $user_id)->orderBy('id', 'desc')->first();

            $picking = DB::table('pickings')->where('stamp_code', $estamp->code)->first();
            // dd($last_record);

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;

            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

            return view('backend.estamps.stamp', compact('user', 'estamp', 'notifications', 'notifications_count'));

        }

    }

    public function destroy($id)
    {

        $input = Input::all();

        $estamp = Estamp::find($id);
        $estamp->delete();

        return redirect()->back();
    }

}

