<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Models\User as User;
use App\Models\Contact as Contact;
use App\Models\PostBox as PostBox;
use App\Models\PostCode as PostCode;
use App\Models\County as County;
use App\Models\Notification as Notification;

use Illuminate\Support\MessageBag;
use App\Http\Controllers\SendSMSController as SendSMSController;

use App\Logic\Mailers\UserMailer;
use Auth, DB, Input, Validator, Session, Request;

use Redirect;

use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $users = User::where('staff', 0)->get();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.admin.users.index', compact('user', 'users', 'notifications', 'notifications_count'));
    }


    //Admin cannot create nor store

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = Auth::user();
        $mainUser = User::where('id', $id)->first();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.admin.users.show', compact('user', 'mainUser', 'notifications', 'notifications_count'));
    }

    

    public function edit($id)
    {

        $user = Auth::user();
        $mainUser = User::where('id', $id)->first();
        // $user = User::find($id);


        $counties = \DB::table('counties')->lists('name', 'id');
        $selectedCounty = \DB::table('users')->where('id', $id)->pluck('county_id');
        $post_boxes = \DB::table('users')->where('id', $id)->pluck('postbox_id');
        $post_codes = \DB::table('users')->where('id', $id)->pluck('postcode_id');

        //$role = \DB::table('role_user')->where('id', $id)->pluck('postcode_id');

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();


        return view('backend.admin.users.edit', compact('user', 'mainUser', 'counties', 'post_boxes', 'post_codes', 'selectedCounty', 'notifications', 'notifications_count'));
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

        $user = User::find($id);
        $input = array_except(Input::all(), '_method');
        $rules = array();
        $validator = Validator::make($input, $rules);


        if ($validator->fails()) {

            return redirect()->back()
                // ->with($messages)
                ->withErrors($validator);
        } else {

            $user = User::find($id);
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->email = Input::get('email');
            $user->phone = Input::get('phone');
            $user->county_id = Input::get('county_id');
            $user->town = Input::get('town');
            $user->postbox_id = Input::get('postbox_id');
            $user->postcode_id = Input::get('postcode_id');
            $user->identification_number = Input::get('identification_number');
            $user->current_email = Input::get('current_email');

            $user->save();

            Session::flash('message', 'Successfully created box!');

            return redirect('/admin/dashboard')
                ->with('message', 'Successfully created Profile!');
        }
    }

    public function activate($id)
    {

        $user = User::find($id);
        
        User::where('id', $id)->update(array('code' => 1, 'active' => 1));

        $message = "Dear ".$user->first_name.", your account ".$user->postbox_id."-".$user->postcode_id." has been verified. Login with ".$user->postbox_id."-".$user->postcode_id."@posta.co.ke and use the password you provided at registration.";
        $phone = $user->phone;

        $notify = new SendSMSController();
        $notify->sendSms($phone, $message);

        return redirect('/admin/dashboard')
            ->with('message', 'Successfully Verified User!');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}