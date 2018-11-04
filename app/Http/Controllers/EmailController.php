<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Models\User as User;
use App\Models\Notification as Notification;
use App\Models\Email as Email;

use Auth, DB, Input, Validator, Session, Request, Redirect;

use App\Http\Requests;

class EmailController extends Controller
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
        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        // dd(DB::table('users')->where('email', $recipientEmail)->value('first_name'));
        
        $emails = Email::where('to', $recipientEmail)->orderBy('id', 'desc')->get();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;  


        return view('backend.emails.index', compact('user', 'notifications', 'notifications_count', 'emails', 'notifications_emails'));
    }

    public function updateNoreplyFrom(){

        Email::where('from', 'admin@posta.co.ke')->update(array('from' => 'noreply@posta.co.ke'));

        dd('Done');
    }

    public function updateNoreplyTo(){

        Email::where('to', 'admin@posta.co.ke')->update(array('from' => 'noreply@posta.co.ke'));

        dd('Done');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function outbox()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;
        
        $emails = Email::where('from', $recipientEmail)->orderBy('id', 'desc')->get();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;  


        return view('backend.emails.outbox', compact('user', 'notifications', 'notifications_count', 'emails', 'notifications_emails'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $email = Email::find($id);


        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $recipientPhone = Auth::user()->phone;

        $recipientEmail = Auth::user()->email;
        $attached_location = $_SERVER['SERVER_NAME'];

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();                
        $emails_count = Email::where('to', $recipientEmail)->count();

       // $cc_recipient = Email::where('to', $recipientEmail)->cc;
        $cc_recipient = DB::table('emails')->where('id', $email->id )->value('cc');

        $notifications_emails = $notifications_count + $emails_count; 

        return view('backend.emails.show', compact('user', 'email','notification', 'notifications', 'notifications_count', 'notifications_emails','attached_location','cc_recipient'));
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
        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  
        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;

        return view('backend.emails.create', compact('user', 'notifications', 'notifications_count', 'recipientPhone', 'notifications_emails'));
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

        $validator = Validator::make($input, email::$rules,email::$messages);

        if ($validator->fails()) {
            dd('failed');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();

        } else {
            //dd('sxe');
            // store
            $email 				= new \App\Models\Email;
            $email->from       	= Auth::user()->email;
            $email->to    		= Input::get('to');
            $email->cc  		= Input::get('cc');
            $email->bcc   		= Input::get('bcc');
            $email->subject   	= Input::get('subject');
            $email->body    	= Input::get('body');
            $email->read      	= 1;



            if(Input::hasFile('file_attachment'))
            {
                $attach_file=Input::file(('file_attachment'));
                $file_original_name=$attach_file->getClientOriginalName();

                $pdf_name = mt_rand(1000, 99999);
                $filename = $pdf_name.'_'.$file_original_name;
                if(Input::file('file_attachment')->move('uploads/mail_attach/', $filename)){

                }else{

                }

                $email->file_attachment = $filename;
                $file_name=$filename;
            }else{
                $email->file_attachment = 'NULL'; //no erroneous nullity
            }


            $email->save();


            if (Input::has('cc'))

            {
                $email_cc				= new \App\Models\Email;
                $email_cc->from       	= Auth::user()->email;
                $email_cc->to    		= Input::get('cc');
                $email_cc->cc  		= Input::get('to');
                //$email->bcc   		= Input::get('bcc');
                $email_cc->subject   	= Input::get('subject');
                $email_cc->body    	= Input::get('body');
                $email_cc->read      	= 1;
                if(Input::hasFile('file_attachment'))
                {
                    $email_cc->file_attachment = $file_name;
                }
                else{
                    $email_cc->file_attachment = 'NULL';
                }


                $email_cc->save();
            }
            if (Input::has('bcc'))

            {
                $email_bcc				= new \App\Models\Email;
                $email_bcc->from       	= Auth::user()->email;
                $email_bcc->to    		= Input::get('bcc');
                $email_bcc->cc  		= Input::get('to');
                //$email->bcc   		= Input::get('bcc');
                $email_bcc->subject   	= Input::get('subject');
                $email_bcc->body    	= Input::get('body');
                $email_bcc->read      	= 1;
                if(Input::hasFile('file_attachment'))
                {
                    $email_bcc->file_attachment = $file_name;
                }
                else{
                    $email_bcc->file_attachment = 'NULL';
                }


                $email_bcc->save();


            }

             $mail_out = new \PHPMailer(true);
             try {
                 $mail_out->isSMTP(); // tell to use smtp
                 $mail_out->CharSet = "utf-8"; // set charset to utf8
                 $mail_out->SMTPAuth = true;  // use smpt auth
                 $mail_out->SMTPDebug = 0;
                 $mail_out->SMTPSecure = "ssl"; // or ssl
                 $mail_out->Host = "ssl://mail.mobitechleo.com:465";
                 $mail_out->Port = 465; //465 most likely something different for you. This is the mailtrap.io port i use for testing.
//                 $mail_out->Username = "kenyaleo15@gmail.com";
//                 $mail_out->Password = "kenyaleo.co.ke";

                 $mail_out->Username = "mobitech";
//Password to use for SMTP authentication
                 $mail_out->Password = "pw8UYvf372";

                 $mail_out->setFrom(Auth::user()->email, Auth::user()->first_name.' '.Auth::user()->last_name);
                 $mail_out->Subject = Input::get('subject');
                 $mail_out->MsgHTML(Input::get('body'));
                 $mail_out->addAddress(Input::get('to'));
                 $mail_out->addReplyTo(Auth::user()->email, Auth::user()->first_name.' '.Auth::user()->last_name);
                 //$mail_out->AddCC(Input::get('cc'));
                 //$mail_out->AddBCC(Input::get('bcc'));
                 if(Input::hasFile('file_attachment'))
                 {
                     $mail_out->addAttachment('uploads/mail_attach/'.$filename );
                 }

                 $mail_out->SMTPOptions = array(
                     'ssl' => array(
                         'verify_peer' => false,
                         'verify_peer_name' => false,
                         'allow_self_signed' => true
                     )
                 );

                 $mail_out->send();
             } catch (phpmailerException $e) {
                 //dd($e);
                 echo "sorry something wrong happened. If it persist contact administrator!";
             } catch (Exception $e) {
                 //dd($e);
                 echo "sorry something wrong happened. If it persist contact administrator please!";
             }
            //die('success Mail sent');

            Session::flash('message', 'Successfully created email!');

            return redirect()->route('emails.index')
                ->with('message', 'Successfully created Email!');

        }


    }


    public function careCreate()
    {
        
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();  
        $emails_count = Email::where('to', $recipientEmail)->count();

        $notifications_emails = $notifications_count + $emails_count;

        return view('backend.emails.care.create', compact('user', 'notifications', 'notifications_count', 'recipientPhone', 'notifications_emails'));
    }


    public function careStore()
    {
        $input = Input::all();

        $validator = Validator::make($input, Email::$rules, Email::$messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();

        } else {
            // store
            $email              = new \App\Models\Email;
            $email->from        = Auth::user()->email;
            $email->to          = "customercare@posta.co.ke";
            $email->subject     = Input::get('subject');
            $email->body        = Input::get('body');
            $email->read        = 1;
            $email->save();

            Session::flash('message', 'Successfully created email!');

            return redirect()->route('emails.index')
                ->with('message', 'Successfully created Email!');

        }
    }

}
