<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use App\Models\User as User;
use App\Models\Estamp as Estamp;
use App\Models\Staff as Staff;
use App\Models\Delivery as Delivery;
use App\Models\Email as Email;
use App\Models\Notification as Notification;

use App\Models\Picking as Picking;
use App\Models\PickingMail as PickingMail;

use App\Http\Controllers\SendSMSController as SendSMSController;

use App\Models\SMS as SMS;

use Input, DB, Validator, Session, Redirect;

class AdminController extends Controller
{
    public function dashboard()
    {

        $user = Auth::user();

        $recipientPhone = $user->phone;
        $recipientEmail = $user->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        $drivers = Staff::all()->count();
        $staff = User::where('staff', 1)->count();

        $matchThese = ['staff' => 0, 'active' => 1];

        $users = User::where($matchThese)->count();
        $letters = Estamp::all()->where('status',1)->count();
        $estamps_sum = Estamp::all()->sum('price');


        
        $total_emails = Email::all()->count();

        $normalRentors = User::whereHas('roles', function($q)
        {
            $q->where('name', 'User');
        })->count();

        $corporatesRentors = User::whereHas('roles', function($q)
        {
            $q->where('name', 'Corporate');
        })->count();

        $normalRentorSum = $normalRentors * 600;
        $corporateRentorSum = $corporatesRentors * 2000;

        $accounts_sum = $normalRentorSum + $corporateRentorSum;

        return view('backend.admin.dashboard', compact(
            'user', 'notifications', 'notifications_count', 'emails_count', 'staff', 'users', 
            'drivers', 'letters', 'estamps_sum', 'accounts_sum', 'total_emails', 'normalRentors', 'corporatesRentors'
            ));
    }

    public function dashboardRange($startDate, $endDate)
    {

        $user = Auth::user();

        $recipientPhone = $user->phone;
        $recipientEmail = $user->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        // dd($startDate."-".$endDate);

        $drivers = Staff::whereBetween('created_at', [$startDate, $endDate])->count();
        $staff = User::where('staff', 1)->whereBetween('created_at', [$startDate, $endDate])->count();

        $matchThese = ['staff' => 0, 'active' => 1];

        $users = User::where($matchThese)->whereBetween('created_at', [$startDate, $endDate])->count();

        // $users = DB::table('users')->whereBetween('created_at', [$startDate, $endDate])->get();
        // dd($users);

        $letters = Estamp::where('status',1)->whereBetween('created_at', [$startDate, $endDate])->count();
        $estamps_sum = Estamp::whereBetween('created_at', [$startDate, $endDate])->sum('price');


        
        $total_emails = Email::whereBetween('created_at', [$startDate, $endDate])->count();

        $normalRentors = User::whereHas('roles', function($q)
        {
            $q->where('name', 'User');
        })->whereBetween('created_at', [$startDate, $endDate])->count();

        $corporatesRentors = User::whereHas('roles', function($q)
        {
            $q->where('name', 'Corporate');
        })->whereBetween('created_at', [$startDate, $endDate])->count();

        $normalRentorSum = $normalRentors * 600;
        $corporateRentorSum = $corporatesRentors * 2000;

        $accounts_sum = $normalRentorSum + $corporateRentorSum;

        return view('backend.admin.dashboard', compact(
            'user', 'notifications', 'notifications_count', 'emails_count', 'staff', 'users', 
            'drivers', 'letters', 'estamps_sum', 'accounts_sum', 'total_emails', 'normalRentors', 'corporatesRentors'
            ));
    }

    public function createstaff()
    {
        $id = Auth::user()->id;
        $user_postcode_id=Auth::user()->postcode_id;
        $user = User::where('id', $id)->first();
        $senderPhone = Auth::user()->phone;
        $senderFirstName = Auth::user()->first_name;
        $senderLastName = Auth::user()->last_name;
        $senderName = $senderFirstName . " " . $senderLastName;
        $counties = \DB::table('counties')->orderBy('name', 'asc')->lists('name', 'id');
        if(Auth::User()->isAdmin()){
        $role = \DB::table('roles')
            ->where('id', '!=', [3])
            // ->where('id', '!=', [6])
            ->where('id', '!=', [1])
            ->where('id', '!=', [2])
            ->where('id', '!=', [4])
            ->where('id', '!=', [8])
            ->orderBy('name', 'asc')->lists('name', 'id');
            $post_codes = \DB::table('post_codes')->orderBy('number', 'asc')->lists('number', 'number');

        }
        if(Auth::User()->isPostMaster()){
            $role = \DB::table('roles')
                ->where('id', '!=', [3])
                ->where('id', '!=', [6])
                ->where('id', '!=', [1])
                ->where('id', '!=', [2])
                ->where('id', '!=', [8])
                ->where('id', '!=', [2])
                ->where('id', '!=', [4])
                ->where('id', '!=', [11])
                ->orderBy('name', 'asc')->lists('name', 'id');
            $post_codes = \DB::table('post_codes')->where('number',$user_postcode_id)->orderBy('number', 'asc')->lists('number', 'number');

        }
        $notifications = Notification::where('recipient_phone', $senderPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $senderPhone)->count();

       // $destination_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');
        //$destination_codes = \DB::table('post_codes')->orderBy('number', 'asc')->lists('number', 'number');

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        return view('backend.admin.staffs.createstaff', compact('counties', 'role', 'user', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName','post_codes'));
    }

    //Create a new rider

    public function create()
    {

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $senderPhone = Auth::user()->phone;
        $senderFirstName = Auth::user()->first_name;
        $senderLastName = Auth::user()->last_name;
        $senderName = $senderFirstName . " " . $senderLastName;
        $counties = \DB::table('counties')->orderBy('name', 'asc')->lists('name', 'id');
        $means = \DB::table('means')->orderBy('name', 'asc')->lists('name', 'id');

        $notifications = Notification::where('recipient_phone', $senderPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $senderPhone)->count();

        $destination_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');
        $destination_codes = \DB::table('post_codes')->orderBy('number', 'asc')->lists('number', 'number');

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        return view('backend.admin.staffs.create', compact('counties', 'means', 'user', 'destination_codes', 'destination_boxes', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName'));
    }


    //Save staff to table staff

    public function storestaff()
    {
        $input = Input::all();

        // dd($input);

        $validator = Validator::make($input, Staff::$rules, Staff::$messages);

        $staff = new Staff;

        $staff->first_name      = ucfirst(Input::get('first_name'));
        $staff->last_name       = ucfirst(Input::get('last_name'));
        $staff->phone           = Input::get('phone');
        $staff->city            = ucfirst(Input::get('city'));
        $staff->postcode        = Input::get('postcode');
        $staff->employee_no     = ucfirst(Input::get('employee_no'));
        $staff->email           = ucfirst(Input::get('email'));
        $staff->vehicle         = ucfirst(Input::get('vehicle_type'));
        $staff->vehicle_type    = ucfirst(Input::get('vehicle_type'));
        $staff->reg_no          = ucfirst(Input::get('reg_no'));
        $staff->insurance_no    = ucfirst(Input::get('insurance_no'));
        $staff->expiry_date          = ucfirst(Input::get('expiry_date'));

        $staff->driving_licence    = ucfirst(Input::get('driving_licence'));
        $staff->licence_expiry          = ucfirst(Input::get('licence_expiry'));

        $staff->id_no           = Input::get('identification_number');

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $staff->save();

        $users = Staff::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        return view('backend.admin.staffs.index', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count'));

    }

    public function editstaff($id)
    {

        // dd($id);
        $staff = User::where('id', $id)->first();

        $id = Auth::user()->id;
        $user_postcode_id=Auth::user()->postcode_id;
        $user = User::where('id', $id)->first();
        $senderPhone = Auth::user()->phone;
        $senderFirstName = Auth::user()->first_name;
        $senderLastName = Auth::user()->last_name;
        $senderName = $senderFirstName . " " . $senderLastName;
        $counties = \DB::table('counties')->orderBy('name', 'asc')->lists('name', 'id');
        if(Auth::User()->isAdmin()){
            $role = \DB::table('roles')
                ->where('id', '!=', [3])
                ->where('id', '!=', [6])
                ->where('id', '!=', [1])
                ->where('id', '!=', [8])
                ->orderBy('name', 'asc')->lists('name', 'id');
            $post_codes = \DB::table('post_codes')->orderBy('number', 'asc')->lists('number', 'number');

        }
        if(Auth::User()->isPostMaster()){
            $role = \DB::table('roles')
                ->where('id', '!=', [3])
                ->where('id', '!=', [6])
                ->where('id', '!=', [1])
                ->where('id', '!=', [8])
                ->where('id', '!=', [2])
                ->orderBy('name', 'asc')->lists('name', 'id');
            $post_codes = \DB::table('post_codes')->where('number',$user_postcode_id)->orderBy('number', 'asc')->lists('number', 'number');

        }
        $notifications = Notification::where('recipient_phone', $senderPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $senderPhone)->count();

        // $destination_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');
        //$destination_codes = \DB::table('post_codes')->orderBy('number', 'asc')->lists('number', 'number');

        $postage_rates = \DB::table('postage_rates')->lists('name', 'name');
        $towns = \DB::table('towns')->lists('name', 'name');

        return view('backend.admin.staffs.editstaff', compact('staff','counties', 'role', 'user', 'notifications', 'notifications_count', 'senderPhone', 'postage_rates', 'towns', 'senderName','post_codes'));
    }


    //Staffs dashboard
    public function allstaffs()
    {

        $user = Auth::user();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();
        $users = User::where('staff', 1)->get();


        return view('backend.admin.staffs.index', compact('users', 'notifications', 'notifications_count', 'emails_count'));
    }

    public function physicalBoxes(){

        $user = Auth::user();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();
        $users = User::where('code', 1111)->where('active', 0)->get();


        return view('backend.admin.users.physical.index', compact('users', 'user', 'notifications', 'notifications_count', 'emails_count'));
    }

    public function drivers()
    {

        $user = Auth::user();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();


        $emails_count = Email::where('to', $recipientEmail)->count();

        $users = Staff::all();


        return view('backend.drivers.index', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count'));
    }

    //Staff function


    public function staffs()
    {

        $users = Staff::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        return view('backend.admin.staffs.index', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count'));
    }

    //managers view

    public function allstaffshow()
    {
        if(Auth::User()->isPostMaster() || Auth::User()->isAdmin())
        {

                $id = Input::get('id');

                if( Auth::User()->isPostMaster() )
                {

                    $users = DB::table('users')->where([
                        ['role', '=', $id],
                        ['postcode_id', '=',Auth::user()->postcode_id],
                    ])->get();                    
                }
                else
                {

                    $users = DB::table('users')->where('role', $id)->get();

                }


                $user = Auth::user();
                
                $user_tittle    =  DB::table('roles')->where('id', $id)->first();

                $recipientPhone = Auth::user()->phone;
                $recipientEmail = Auth::user()->email;

                $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
                $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

                $emails_count = Email::where('to', $recipientEmail)->count();

                return view('backend.admin.staffs.managers', compact('user', 'users', 'user_tittle','notifications', 'notifications_count', 'emails_count'));
        }else{
            return redirect()->back();
        }
    }


    public function users()
    {
        if(Auth::User()->isPostMaster()){
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'User');
            })
                ->where('postcode_id',Auth::user()->postcode_id)
                ->get();
        }
        else
        {
            $users = User::whereHas('roles', function ($q) {
                $q->where('name', 'User');
            })->orderBy('created_at', 'desc')->get();
        }


        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
       // $users = User::all();



        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        return view('backend.admin.users.index', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count'));
    }

    public function corporates()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'Corporate');
        })->get();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        return view('backend.admin.corporates.index', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count'));
    }

    public function deliveries()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $deliveries = Delivery::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        return view('backend.admin.deliveries.index', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count', 'deliveries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function editDelivery($id)
    {
        $delivery = Delivery::find($id);

        $user = Auth::user();
        $counties = \DB::table('counties')->lists('name', 'id');
        $selectedCounty = \DB::table('users')->where('id', $id)->pluck('county_id');
        $post_boxes = \DB::table('users')->where('id', $id)->pluck('postbox_id');
        $post_codes = \DB::table('users')->where('id', $id)->pluck('postcode_id');

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        // $riders = $counties = \DB::table('staffs')->lists('employee_no', 'id');
        $riders = DB::table('staffs')->where('status',0)
            ->get();        

        return view('backend.admin.deliveries.edit', compact('user', 'delivery', 'counties', 'post_boxes', 'post_codes', 'selectedCounty', 'notifications', 'notifications_count', 'riders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateRiderDelivery($id)
    {
        $rider_no=Input::get('rider_no');

        Staff::where('id', $rider_no)->update(['Status' => 1]);

        $delivery = Delivery::find($id);



        $input = array_except(Input::all(), '_method');

        $rules = array();

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect()->back()
                // ->with($messages)
                ->withErrors($validator);
        } else {

            $delivery = Delivery::find($id);
            $delivery->rider_no = Input::get('rider_no');
            $delivery->active = 1;

            $delivery->save();

            $phone  = $delivery->phone;

            //assign SMS Email.
            //Dear ".$delivery->fullname.", our driver ".$delivery->rider->first_name.", phone no.".$delivery->rider->phone." [riding/driving] ".$delivery->rider->vehicle_type." ".$delivery->rider->reg_no." is on the way to deliver your letter/parcel no.".$delivery->stamp_code.". Thank you.
            $message = "Dear ".$delivery->fullname.", our driver ".$delivery->rider->first_name." ".$delivery->rider->last_name.", phone(".$delivery->rider->phone.") driving a ".$delivery->rider->vehicle_type." ".$delivery->rider->reg_no." is on the way to deliver your parcel No. ".$delivery->stamp_code.". Thanks.";

            $receiver_email = User::where('phone', $delivery->phone)->value('email');

            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = $receiver_email;
            $email->subject = "Mail Delivery Options";
            $email->body    = $message;
            $email->save();
        

            $sms                = new SMS;
            $sms->to            = "SENDER";
            $sms->subject       = "DELIVERY";
            $sms->message       = $message;
            $sms->phone         = $delivery->rider->phone;
            $sms->status        = "PROGRESS";
            $sms->active        = 1;
            $sms->save();



            $notify = new SendSMSController();
            $notify->sendSms($phone, $message);                

            Session::flash('message', 'Successfully Updated Rider!');

            // return redirect('/admin/deliveries/')
            //     ->with('message', 'Successfully created Profile!');

            return redirect()->route('admin.deliveries.sign_form', $delivery->id);
        }
    }


    public function showDeliveryForm($id){

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;

        $delivery = Delivery::where('id', $id)->first();

        return view('backend.estamps.signforms.delivery', compact('user', 'delivery', 'notification', 'notifications', 'notifications_count'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showRiderCode($id)
    {

        $delivery = Delivery::find($id);

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;

        return view('backend.admin.deliveries.show', compact('user', 'delivery', 'notification', 'notifications', 'notifications_count', 'notifications_emails', 'attached_location', 'cc_recipient'));
    }


    public function pickings()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $pickings = Picking::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        return view('backend.admin.pickings.index', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count', 'pickings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function editPicking($id)
    {

        $picking = Picking::find($id);

        $user = Auth::user();
        $counties = \DB::table('counties')->lists('name', 'id');
        $selectedCounty = \DB::table('users')->where('id', $id)->pluck('county_id');
        $post_boxes = \DB::table('users')->where('id', $id)->pluck('postbox_id');
        $post_codes = \DB::table('users')->where('id', $id)->pluck('postcode_id');

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();


        // SELECT s.first_name, m.name FROM staffs s, means m where s.means=m.id
        $riders = DB::table('staffs')->where('status',0)
            ->get();

        return view('backend.admin.pickings.edit', compact(
            'user', 'picking', 'counties', 'post_boxes',
            'post_codes', 'selectedCounty', 'notifications', 'notifications_count', 'riders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateRiderPicking($id)
    {
        $rider_no=Input::get('rider_no');

        Staff::where('id', $rider_no)->update(['Status' => 1]);
        //dd(Input::get('rider_no'));


        $picking = Picking::find($id);

        $input = array_except(Input::all(), '_method');

        $rules = array();

        $validator = Validator::make($input, $rules);



        if ($validator->fails()) {

            return redirect()->back()
                // ->with($messages)
                ->withErrors($validator);
        } else {

            $picking->rider_no = Input::get('rider_no');
            $picking->active = 1;

            $picking->save();

            $rider = Staff::where('id', $picking->rider_no)->first();


            $rider_name         = $rider->first_name . " " . $rider->last_name;
            $rider_phone        = $rider->phone;
            $rider_vehicle_type = $rider->vehicle_type;
            $rider_regno        = $rider->reg_no;



            //Dear ".$picking->fullname.", our driver ".$rider_name." is on the way to collect your item. Kindly reach them on ".$rider_phone." for ETA, or call our office on 0710101010
            $message = "Dear ".$picking->fullname.", our driver ".$rider_name." driving a ".$rider_vehicle_type." ".$rider_regno ." is on the way to collect your item. Kindly reach them on ".$rider_phone." for ETA, or call our office on 0720242535.";

            $receiver_phone = $picking->phone;
            $receiver_email = User::where('phone', $receiver_phone)->value('email');

            $email          = new Email;
            $email->from    = "noreply@posta.co.ke";
            $email->to      = $receiver_email;
            $email->subject = "Picking Email";
            $email->body    = $message;
            $email->save();

            $notify = new \App\Http\Controllers\SendSMSController;
            $notify->sendSms($receiver_phone, $message);

            // return redirect('/admin/pickings/')
            //     ->with('message', 'Successfully created Profile!');


            return redirect()->route('admin.pickings.sign_form', $picking->id);
        }
    }

    public function showPickingForm($id){

        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;

        $picking = Picking::where('id', $id)->first(); 

        return view('backend.estamps.signforms.picking', compact('user', 'picking', 'notification', 'notifications', 'notifications_count'));
    }

    public function mainPickingCreate()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $pickings = Picking::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        $reference_code = 'uiafdsk';

        return view('backend.admin.pickingmails.create', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count', 'pickings', 'reference_code'));
    }

    public function getReference()
    {


        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $pickings = Picking::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        return view('backend.admin.pickingmails.create', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count', 'pickings'));
    }


    public function getPickingCode()
    {

        $input = Input::all();

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $emails_count = Email::where('to', $recipientEmail)->count();

        if (PickingMail::where('tracking_code', '=', $input['reference_code'])->exists()) {
            // if ($input['reference_code'])->exists()) {

            $picking = PickingMail::where('tracking_code', $input['reference_code'])->first();
            return view('backend.admin.pickingmails.show', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));
        } else {

            Session::flash('message', 'The Reference Code you used does not Exist on our database. Please go back and try another Reference Code.');
            return view('backend.admin.pickingmails.blank', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));
        }

    }

    public function updateTable($code)
    {


        PickingMail::where('tracking_code', $code)->update(array('status' => 'CONFIRMED'));

        $messages = "Successfully Confirmed the Picking.";

        //Send Notification to the sender
        $pickingMail = PickingMail::where('tracking_code', $code)->first();

        $estampInfo = Estamp::where('code', $pickingMail->stamp_code)->first();
        
        $sender_phone = $estampInfo->sender_phone;
        $sender_message = "Dear ".$estampInfo->sender_name. " your Registered Mail tracking code No: ".$estampInfo->code." has been collected by ".$pickingMail->name.", ID: ".$pickingMail->id_number.", Phone: ".$pickingMail->phone.".";

        $notify = new SendSMSController();
        $notify->sendSms($sender_phone, $sender_message);

        return redirect()->route('admin.main.picking.success')->with('messages', $messages);
    }

    public function picked()
    {

        $input = Input::all();

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $users = User::all();

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        //Add a notification here

        $emails_count = Email::where('to', $recipientEmail)->count();
        return view('backend.admin.pickingmails.success', compact('user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));
    }


    public function emails()
    {

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        // dd(DB::table('users')->where('email', $recipientEmail)->value('first_name'));
        
        $emails = Email::where('from', $recipientEmail)->orderBy('id', 'desc')->get();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;  


        return view('backend.admin.emails.index', compact('user', 'notifications', 'notifications_count', 'emails', 'notifications_emails'));
    }

    public function notifications()
    {

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        // dd(DB::table('users')->where('email', $recipientEmail)->value('first_name'));
        
        $notifications = Notification::all();
        // dd($notifications);

        // $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;  


        return view('backend.admin.notifications.index', compact('user', 'notifications', 'notifications_count', 'emails', 'notifications_emails'));
    }

    public function showEstampSoldByTown()
    {

        $estamps = Estamp::where('status',1)->get();
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
        return view('backend.estamps.stampsold', compact('estamps','user', 'users', 'notifications', 'notifications_count', 'emails_count', 'picking'));

    }
}
