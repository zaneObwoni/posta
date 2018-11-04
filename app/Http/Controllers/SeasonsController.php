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

class SeasonsController extends Controller
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

    public function download()
    {
        //dd('seen');

        if (Auth::User()->isUser()) {

            $user_id = Auth::user()->id;

            if (strlen($_GET['code']) > 15)
            {
                $estamp = DB::table('estamps')->where('user_id', $user_id)
                    ->where('batch_number', $_GET['code'])
                    ->orderBy('id', 'desc')->get();

            }
            else
            {
            $estamp = DB::table('estamps')->where('user_id', $user_id)
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

            // dd($estamp);

            return view('backend.bestwishes.download', compact('user', 'estamp', 'notifications', 'notifications_count', 'picking','code'));

        }

        if (Auth::User()->isCorporate()) {


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
}