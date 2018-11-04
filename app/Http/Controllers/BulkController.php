<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Models\User as User;
use App\Models\Estamp as Estamp;
use App\Models\Contact as Contact;
use App\Models\Notification as Notification;

use App\Models\Picking as Picking;
use App\Models\Invoice as Invoice;

use Auth, DB, Input, Validator, Session, Request, Redirect;

use QrCode;

use Carbon\Carbon;

class BulkController extends Controller
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        
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

        //********************************************************************//
        // Change this to LOOP through Estamp Codes and update unique Number  //
        //********************************************************************// 
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        $dt             = Carbon::now();        
        $todayBatch     = $dt->toDateString();
        $uniqueNumber = $_GET['unique_number'];

        $matchThese = ['today_date' => $todayBatch, 'user_id' => $userId, 'status' => 0];
        Estamp::where($matchThese)->update(['unique_number' => $uniqueNumber, 'batch_number' => $uniqueNumber, 'status' => 1]);

        $matchThese = ['unique_number' => $_GET['unique_number'], 'user_id' => $userId];
        $estamps   = Estamp::where($matchThese)->get();

        $recipientPhone = Auth::user()->phone;
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                

        return view('backend.bulk.stamps', compact('user', 'estamps', 'notifications', 'notifications_count', 'picking'));
        
    }

    public function advanceCustomer()
    {

        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        $dt             = Carbon::now();        
        $todayBatch     = $dt->toDateString();
        $uniqueNumber   = Request::segment(5);
        $amount         = Request::segment(4);

        $matchThese = ['today_date' => $todayBatch, 'user_id' => $userId, 'status' => 0];
        Estamp::where($matchThese)->update(['unique_number' => $uniqueNumber, 'batch_number' => $uniqueNumber, 'status' => 1]);

        $matchThese = ['unique_number' => $uniqueNumber, 'user_id' => $userId];
        $estamps   = Estamp::where($matchThese)->get();
        $recipientPhone = Auth::user()->phone;
        
        $invoice                = new Invoice;
        $invoice->unique_number = $uniqueNumber;
        $invoice->amount        = $amount;
        $invoice->corporate_id  = $userId;
        $invoice->status        = "ADVANCE";
        $invoice->active        = 1;
        $invoice->save();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();      

        return view('backend.bulk.stamps', compact('user', 'estamps', 'notifications', 'notifications_count', 'picking'));
        
    }

    public function accountCustomer()
    {

        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        $dt             = Carbon::now();        
        $todayBatch     = $dt->toDateString();
        $uniqueNumber   = Request::segment(5);
        $amount         = Request::segment(4);

        $matchThese = ['today_date' => $todayBatch, 'user_id' => $userId, 'status' => 0];
        Estamp::where($matchThese)->update(['unique_number' => $uniqueNumber, 'batch_number' => $uniqueNumber, 'status' => 1]);

        $matchThese = ['unique_number' => $uniqueNumber, 'user_id' => $userId];
        $estamps   = Estamp::where($matchThese)->get();

        $recipientPhone = Auth::user()->phone;

        $invoice                = new Invoice;
        $invoice->unique_number = $uniqueNumber;
        $invoice->amount        = $amount;
        $invoice->corporate_id  = $userId;
        $invoice->status        = "ACCOUNT";
        $invoice->active        = 1;
        $invoice->save();
        
        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.bulk.stamps', compact('user', 'estamps', 'notifications', 'notifications_count', 'picking'));
        
    }

}