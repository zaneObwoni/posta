<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Models\User as User;
use App\Models\Staff as Staff;

use App\Models\Contact as Contact;
use App\Models\PostBox as PostBox;
use App\Models\PostCode as PostCode;
use App\Models\County as County;
use App\Models\Notification as Notification;
use App\Models\Invoice as Invoice;
use App\Models\Estamp as Estamp;


use Illuminate\Support\MessageBag;

use App\Logic\Mailers\UserMailer;
use Auth, DB, Input, Validator, Session, Request;

use Redirect;

use Image;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $invoices = Invoice::where('active', 1)->get();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.admin.finance.dashboard', compact('user', 'users', 'notifications', 'notifications_count'));
    }

    public function accounts()
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $invoices = Invoice::distinct()->get(['corporate_id']);

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.admin.finance.invoices', compact('user', 'users', 'invoices', 'notifications', 'notifications_count'));
    }

    public function customer($id)
    {

        $user = Auth::user();
        $mainUser = User::where('id', $id)->first();

        $recipientPhone = Auth::user()->phone;
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $invoices = Invoice::where('corporate_id', $id)->get();
        $invoicesSum = Invoice::where('corporate_id', $id)->sum('amount');
        $companyName = User::where('id', $id)->value('first_name');

        return view('backend.admin.finance.customer', compact('user', 'mainUser', 'invoices', 'invoicesSum', 'companyName', 'notifications', 'notifications_count'));
    }

    public function breakDown($id, $uniqueCode)
    {

        $user = Auth::user();
        $mainUser = User::where('id', $id)->first();

        $recipientPhone = Auth::user()->phone;
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        $invoices = Invoice::where('corporate_id', $id)->get();
        $invoicesSum = Invoice::where('corporate_id', $id)->sum('amount');
        $companyName = User::where('id', $id)->value('first_name');

        $estamps = Estamp::where('unique_number', $uniqueCode)->where('status', 1)->get();

        return view('backend.admin.finance.breakdown', compact('user', 'mainUser', 'invoices', 'estamps', 'invoicesSum', 'companyName', 'notifications', 'notifications_count'));
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

        return view('backend.admin.staff.show', compact('user', 'mainUser', 'notifications', 'notifications_count'));
    }

    

    public function edit($id)
    {

        $id = Request::segment(3);
        $user = Auth::user();

        $mainUser = User::where('id', $id)->first();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();


        return view('backend.admin.staff.edit', compact('user', 'mainUser', 'counties', 'post_boxes', 'post_codes', 'selectedCounty', 'notifications', 'notifications_count'));
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

        // dd($errors)

        if ($validator->fails()) {

            dd($validator);
            return redirect()->back()
                // ->with($messages)
                ->withErrors($validator);
        } else {

            $user = User::find($id);
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->email = Input::get('email');
            $user->phone = Input::get('phone');

            $user->employee_no = Input::get('employee_no');

            $user->save();

            Session::flash('message', 'Successfully created box!');

            return redirect('/admin/dashboard')
                ->with('message', 'Successfully created Profile!');
        }
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