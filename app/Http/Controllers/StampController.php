<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Estamp as Estamp;
use App\Models\Contact as Contact;
use App\Models\Picking as Picking;


use App\Models\Registered as Registered;
use App\Models\Contact_test as ContactTest;
use App\Models\Notification as Notification;
use App\Models\Underpayment as Underpayment;


use Auth, DB, Input, Validator, Session, Request, Redirect,Excel;

use QrCode;

use Carbon\Carbon;

class StampController extends Controller
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

        $estamps = Estamp::where('user_id', $id)->where('status', 1)->orderBy('id', 'DESC')->get();
        $registers = Registered::where('user_id', $id)->get();
        
        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        return view('backend.estamps.index', compact('user', 'registers', 'estamps', 'notifications', 'notifications_count'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function corporateIndex()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $estamps = Estamp::where('user_id', $id)->where('status', 1)->groupBy('code')->get();
        
        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        return view('backend.estamps.corporate.index', compact('user', 'estamps', 'notifications', 'notifications_count'));
    }

    public function corporateBatch()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $estamps = Estamp::where('unique_number', '!=', NULL)->where('status', 1)->get();        
        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        return view('backend.estamps.corporate.batch', compact('user', 'estamps', 'notifications', 'notifications_count'));
    }

    public function postContactExcel()
    {
        $rules = array(
            'file' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);
        // process the form
        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }
        else
        {
            try {
                Excel::load(Input::file('file'), function ($reader) {

                    $reader->ignoreEmpty()->get();
                    foreach ($reader->toArray() as $row) {

                        $Contact                   =  new \App\Models\Contact;
                        $Contact->user_id = Auth::user()->id;
                        $Contact->phone_number= intval($row['phone']);
                        $Contact->name= $row['name'];
                        $Contact->postbox_id= intval($row['box']);
                        $Contact->postcode_id= intval($row['code']);
                        $Contact->posta_email= $row['email'];
                        $Contact->town= $row['town'];
                        $Contact->status= 0;

                        $Contact->save();

                        //Contact::firstOrCreate($row);


                    }
                });
                \Session::flash('success', 'Users uploaded successfully.');
                return Redirect::back()->withMessage('Success, Data uploaded');
            } catch (\Exception $e) {
                //\Session::flash('error', $e->getMessage());
                return Redirect::back()->withErrors('Your excel sheet format not correct, check sample sheet please!');
                //return redirect(route('users.index'));
            }
        }
    }

    //Contacts for bulk estamp creation
    public function contact()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $contact= DB::table('contact')->where('user_id', $id)->get();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');

        return view('backend.estamps.contact', compact('user', 'contact', 'notifications', 'notifications_count', 'postage_rates'));
    }

    //Save bulk estamp to table
    public function postBulk()
    {

        $input=input::all();
        $letter_weight=$input['letter_weight'];


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

        //value selected
        $check_list=$input['check_list'];

            foreach($check_list as $selected_contact) {
                $Contact_receiver = Contact::where('id', $selected_contact)->first();

                $estamp = new \App\Models\Estamp;
                $estamp->sender_phone = Auth::user()->phone;
                $estamp->sender_name = Auth::user()->first_name . " " . Auth::user()->last_name;
                $estamp->destination_box = $Contact_receiver->postbox_id;
                $estamp->destination_code = $Contact_receiver->postcode_id;
                $estamp->recipient_phone = $Contact_receiver->phone_number;
                $estamp->recipient_name = $Contact_receiver->name;
                $estamp->origin_town = Auth::user()->town;
                $estamp->destination_town = $Contact_receiver->town;


                // dd($letter_weight);

                $key = \Config::get('app.key');
                $generatedCode = hash_hmac('sha256', str_random(40), $key);

                $estamp->code = strtoupper($generatedCode);

                $estamp->letter_weight = $letter_weight;
                $estamp->price = $price;

                $dt = Carbon::now();

                $estamp->today_date = $dt->toDateString();
                $estamp->status = 0;

                $estamp->user_id = Auth::user()->id;
                $estamp->active = 1;

                $estamp->save();


               // Contact::where('id', $input['id'])->update(array('status' => 1));
            }


            // redirect
            Session::flash('message', 'Success, Contact added to Queue!');
            return redirect()->back();

       // }

    }


    public function showBatch(){

        $userId = Auth::user()->id;

        $dt             = Carbon::now();        
        $todayBatch     = $dt->toDateString();

        $matchThese = ['today_date' => $todayBatch, 'user_id' => $userId, 'active' => 1, 'status' => 0];

        //User::where($matchThese)->get();
        $estamps   = Estamp::where($matchThese)->get();

        $price = 0;
        foreach ($estamps as $stamp) {
            # code...

            $price = $stamp->price + $price;
        }

        $totalPrice = $price;

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $senderPhone = Auth::user()->phone;
        $senderFirstName = Auth::user()->first_name;
        $senderLastName = Auth::user()->last_name;
        $senderName = $senderFirstName." ".$senderLastName;

        $notifications = Notification::where('recipient_phone', $senderPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $senderPhone)->count();

        return view('backend.estamps.batch', compact('user', 'estamps', 'totalPrice', 'notifications', 'notifications_count'));
    }

    public function calculateTotal(){

        $userId = Auth::user()->id;

        $dt             = Carbon::now();        
        $todayBatch     = $dt->toDateString();

        $matchThese = ['today_date' => $todayBatch, 'user_id' => $userId];

        //User::where($matchThese)->get();
        $the_estamps   = Estamp::where($matchThese)->get();

        $price = 0;
        foreach ($the_estamps as $stamp) {
            # code...

            $price = $stamp->price + $price;
        }


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

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        return view('backend.estamps.create', compact('user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName'));
    }

    

    //Agent create estamp method
    public function create_estamp()
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

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        return view('backend.agent.create-estamp', compact('user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName'));
    }

    //Print estamp form get
    public function print_estamp()
    {

        // dd($code);

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

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        return view('backend.agent.print-estamp', compact('user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName'));
    }

    public function pull()
    {

        $input = Input::all();

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

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        

        if (Estamp::where('code', '=', $input['stamp_code'])->exists()) {
            $estamp = Estamp::where('code', $input['stamp_code'])->first();

            if($estamp->category == 'EMS'){

                $picking = Picking::where('stamp_code', $input['stamp_code'])->first();

                return view('backend.agent.stamp-ems', compact('user', 'users', 'picking', 'estamp', 'notifications', 'notifications_count', 'emails_count', 'picking'));
            }elseif($estamp->category == 'SEASON'){

                $code = $estamp->code;
                return view('backend.agent.stamp-season', compact('user',  'code', 'users', 'estamp', 'notifications', 'notifications_count', 'emails_count', 'picking'));
            }else{

                return view('backend.agent.stamp', compact('user', 'users', 'estamp', 'notifications', 'notifications_count', 'emails_count', 'picking'));
            }
            
            
        } else {

            // dd('None');
            Session::flash('message', 'The Reference Code you used does not Exist on our database. Please go back and try another Reference Code.');
            return view('backend.agent.blank', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));
        }
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

        $validator = Validator::make($input, Estamp::$rules);

        if ($validator->fails()) {

            return redirect()->route('estamps.create')
                ->withErrors($validator->errors());
        } else {
            // store
            $estamp 					= new \App\Models\Estamp;
            $estamp->sender_phone       = Auth::user()->phone;
            $estamp->sender_name        = Auth::user()->first_name." ".Auth::user()->last_name;
            $estamp->origin_town        = Auth::user()->town;
            $estamp->destination_box    = Input::get('destination_box');
            $estamp->destination_code   = Input::get('destination_code');
            $estamp->recipient_phone    = Input::get('recipient_phone');
            $estamp->recipient_name     = Input::get('recipient_name');
            
            $estamp->destination_town   = Input::get('destination_town');

            $estamp->letter_weight      = Input::get('letter_weight');

            $letter_weight              = $estamp->letter_weight;
            $price = 0;
            //$extra_price=0;
            $extra_weight=Input::get('extra_weight');;
            $extra_price=$extra_weight*100;



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
            if($letter_weight == 'Over 2kg up to 5kg - Ksh. 300')
                $price = 300;


            $price=$extra_price+$price;
        

            $key = \Config::get('app.key');
            $generatedCode = hash_hmac('sha256', str_random(40), $key);

            $estamp->code               = strtoupper($generatedCode);
            // $price = $distance_cost * $letter_weight;
            $estamp->price         		= $price;
            $estamp->user_id            = Auth::user()->id;
            $estamp->active         	= 1;
         
            $estamp->save();



            $notification                   = new \App\Models\Notification;
            $notification->title            = "Letter from ".$estamp->sender_phone."";
            $notification->content          = "There is a letter for you from ".$estamp->sender_phone."; 
                                             Kindly arrange to pick it from your Box Number ".$estamp->destination_box."-".$estamp->destination_code." in ".$estamp->destination_town.".";
            $notification->sender_phone     = $estamp->sender_phone;
            $notification->recipient_phone  = $estamp->recipient_phone;            

            $notification->save();

            // redirect
            Session::flash('message', 'Successfully created estamp!');            

            return redirect()->route('estamps.show', $estamp->id)
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

        $estamp = Estamp::find($id);

        $picking = DB::table('pickings')->where('stamp_code', $estamp->code)->first();

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

        return view('backend.estamps.show', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking'));
    }

    public function bestWishes(){

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $estamp = DB::table('estamps')->where('user_id', $user_id)->orderBy('id', 'desc')->first();

        $recipientPhone = Auth::user()->phone;
        $recipientName = Auth::user()->first_name;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  

        // dd($estamp);

        return view('backend.estamps.bestwishes', compact('user_id', 'estamp', 'user', 'recipientPhone', 'recipientName', 'notifications', 'notifications_count'));
    }

    public function download()
    {


        if(Auth::User()->isUser()){
            $user_id = Auth::user()->id;
            $estamp = DB::table('estamps')->where('user_id', $user_id)
                ->where('code', $_GET['code'])
                ->orderBy('id', 'desc')->first();

            $underpayment_array = DB::table('underpayments')->where('status', 'UNPAID')->pluck('stamp_code');  
            $stamp_code = $_GET['code'];


            if(in_array($stamp_code, $underpayment_array)){
                $stampUnderpayed = "UNPAID";
            }else{
                $stampUnderpayed = "PAID";
            }

            // dd($stampUnderpayed);
            
            $picking = DB::table('pickings')->where('stamp_code', $_GET['code'])->first();

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

            return view('backend.normal.stamp', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking', 'stampUnderpayed'));

        }if(Auth::User()->isAgent()){
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

        }elseif(Auth::User()->isCorporate()){

            $user_id = Auth::user()->id;
            // $estamp = DB::table('estamps')->where('user_id', $user_id)->orderBy('id', 'desc')->first();

            $userId = Auth::user()->id;

            $estamp = DB::table('estamps')->where('user_id', $user_id)->orderBy('id', 'desc')->first();

            $picking = DB::table('pickings')->where('stamp_code', $estamp->code)->first();

            $dt             = Carbon::now();        
            $todayBatch     = $dt->toDateString();

            $matchThese = ['code' => $_GET['code'], 'user_id' => $userId];

            //User::where($matchThese)->get();
            $estamps   = Estamp::where($matchThese)->get();

            $user = User::where('id', $userId)->first();

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

            return view('backend.estamps.stamps', compact('user', 'estamps', 'notifications', 'notifications_count', 'picking'));
        }

    }


    public function editStampLocation($code){

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $estamp = Estamp::where('code', $code)->first();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();


        return view('backend.normal.edit', compact('user', 'estamp', 'notifications', 'notifications_count'));
    }

    public function updateLocation($id)
    {
        $estamp = Estamp::where('id', $id)->first();

        $input = array_except(Input::all(), '_method');
        $rules = array();
        $validator = Validator::make($input, $rules);


        if ($validator->fails()) {

            return redirect()->back()
                // ->with($messages)
                ->withErrors($validator);
        } else {

            $estamp = Estamp::find($id);
            $estamp->destination_box    = Input::get('destination_box');
            $estamp->destination_code   = Input::get('destination_code');
            $estamp->destination_town   = Input::get('destination_town');
            $estamp->status             = 0;
            $estamp->save();


            return redirect()->route('estamps.show', $estamp->id)
                ->with('message', 'Successfully created estamp!');
            // dd($estamp->price);
            // Session::flash('message', 'Successfully created box!');

            // return redirect('/user/normal/download?code='.$estamp->code)
            //     ->with('message', 'Successfully created Profile!');
        }
    }

    public function viewStamp($id)
    {


        if(Auth::User()->isUser()){
            $user_id = Auth::user()->id;
            $estamp = DB::table('estamps')->where('id', $id)->first();

            $picking = DB::table('pickings')->where('stamp_code', $estamp->code)->first();

            // dd($last_record);

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

            return view('backend.estamps.stamp', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking'));

        }if(Auth::User()->isAgent()){
            $user_id = Auth::user()->id;
            $estamp = DB::table('estamps')->where('user_id', $user_id)->orderBy('id', 'desc')->first();

            $picking = DB::table('pickings')->where('stamp_code', $estamp->code)->first();

            $user_id = Auth::user()->id;
            $user = User::where('id', $user_id)->first();

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

            return view('backend.estamps.stamp', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking'));

        }elseif(Auth::User()->isCorporate()){


            $userId = Auth::user()->id;

            $dt             = Carbon::now();        
            $todayBatch     = $dt->toDateString();

            $matchThese = ['id' => $id, 'user_id' => $userId, 'status' => 1];

            //User::where($matchThese)->get();
            $estamps   = Estamp::where($matchThese)->get();

            $estamp = DB::table('estamps')->where('id', $id)->first();

            $user = User::where('id', $userId)->first();

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

            return view('backend.estamps.stamp', compact('user', 'estamps', 'estamp', 'notifications', 'notifications_count'));
        }

    }

    
    public function corporateViewStamps($id, $batchNumber)
    {


        $userId = Auth::user()->id;

        $dt             = Carbon::now();        
        $todayBatch     = $dt->toDateString();

        $matchThese = ['batch_number' => $batchNumber, 'user_id' => $userId, 'status' => 1];

        //User::where($matchThese)->get();
        $estamps   = Estamp::where($matchThese)->get();

        $batch_number = $batchNumber;

        $user = User::where('id', $userId)->first();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

        return view('backend.estamps.corporate.show', compact('user', 'estamps', 'notifications', 'notifications_count', 'batch_number'));
        
    }


    public function batchCreate($batchNumber){


        $batch_number                     = new \App\Models\BatchNumber;
        $batch_number->batch_number       = $batchNumber;
        $batch_number->user_id            = Auth::user()->id;
        $batch_number->active             = 1;
        $batch_number->save();

        $batch_number   = $batchNumber;

        $from   = Estamp::where('batch_number', $batch_number)->pluck('origin_town')->first();
        $to     = Estamp::where('batch_number', $batch_number)->pluck('destination_town')->first();

        $estamp                     = new \App\Models\Estamp;
        $estamp->sender_phone       = Auth::user()->phone;
        $estamp->sender_name        = Auth::user()->first_name." ".Auth::user()->last_name;
        $estamp->destination_box    = "";
        $estamp->destination_code   = "";
        $estamp->recipient_phone    = "";
        $estamp->recipient_name     = "";
        $estamp->origin_town        = $from;
        $estamp->destination_town   = $to;

        $estamp->letter_weight      = 0;
        $estamp->price              = 0;
        $estamp->code               = $batchNumber;
        $estamp->user_id            = Auth::user()->id;
        $estamp->active             = 1;

        if(!Estamp::where('code', '=', $batchNumber)->exists())
            $estamp->save();

        
        $codes_array    = DB::table('estamps')->where('batch_number', $batch_number)->pluck('code');
        $codes          = implode(", ", $codes_array);

        $user = User::where('id', Auth::user()->id)->first();

        $from   = Estamp::where('batch_number', $batch_number)->pluck('origin_town')->first();
        $to     = Estamp::where('batch_number', $batch_number)->pluck('destination_town')->first();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count(); 

        $estamp = Estamp::where('batch_number', $batch_number)->first();
        // dd($estamp);

        return view('backend.estamps.corporate.batched', compact('user', 'estamps', 'notifications', 'notifications_count', 'batch_number', 'codes', 'from', 'to', 'estamp'));

    }

    public function showMergedBatch(){

        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count(); 

        return view('backend.estamps.corporate.batched', compact('user', 'estamps', 'notifications', 'notifications_count'));
    }


    public function getSearchEstamp(){

        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count(); 

        $estamp = "NULL";

        return view('backend.clerk.search', compact('user', 'estamp', 'notifications', 'notifications_count'));   
    }

    public function searchEstamp(){

        $code = Input::get('search');

        $codes_array = DB::table('estamps')->pluck('code');  
        if(in_array($code, $codes_array)){

            $estamp = DB::table('estamps')->where('code', $code)->first();

            $userId = Auth::user()->id;
            $user = User::where('id', $userId)->first();

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count(); 
        }else{
            $estamp = "NOT FOUND";

            $userId = Auth::user()->id;
            $user = User::where('id', $userId)->first();

            $recipientPhone = Auth::user()->phone;
            
            $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
            $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count(); 
        }

        return view('backend.clerk.search', compact('user', 'estamp', 'notifications', 'notifications_count'));   
    }

    
    public function getUnderpaidEstamp(){

        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count(); 

        $estamps = Underpayment::all();

        return view('backend.clerk.underpaid', compact('user', 'estamps', 'notifications', 'notifications_count'));   
    }

    public function destroy($id){

        $input = Input::all();

        $estamp = Estamp::find($id);    
        $estamp->delete();

        return redirect()->back();
    }

}

