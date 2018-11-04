<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Models\User as User;
use App\Models\Staff as Staff;
use App\Models\Contact as Contact;
use App\Models\PostBox as PostBox;
use App\Models\PostCode as PostCode;
use App\Models\County as County;
use App\Models\Notification as Notification;

use Illuminate\Support\MessageBag;

use App\Logic\Mailers\UserMailer;
use Auth, DB, Input, Validator, Session, Request;

use Carbon\Carbon;

use Redirect;

use Image;
use Fpdf;
use File;
use FPDI;

// File::requireOnce('../vendor/setasign/fpdi/fpdi.php');

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.user.dashboard', compact('user', 'notifications', 'notifications_count'));
    }

    public function agentDashboard()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.agent.dashboard', compact('user', 'notifications', 'notifications_count'));
    }

    public function agentCommission()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();


        $matchThese = ['agent_phone' => $recipientPhone, 'active' => 1];
        $matchUsersOnly = ['agent_phone' => $recipientPhone, 'staff' => 0, 'active' => 1];

        $users = User::where($matchUsersOnly)->get();

        $corporatesUsers = User::whereHas('roles', function ($q) {
            $q->where('name', 'Corporate');
        })->where($matchThese)->get();

        $normalUsers = User::where($matchThese)->get();

        $normalRentors = User::where($matchThese)->count();

        $corporatesRentors = User::whereHas('roles', function ($q) {
            $q->where('name', 'Corporate');
        })->where($matchThese)->count();

        $normalRentorSum = $normalRentors * 62.50;
        $corporateRentorSum = $corporatesRentors * 150;

        $totalSum = $normalRentorSum + $corporateRentorSum;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.agent.commission', compact('user', 'normalUsers', 'corporatesUsers', 'normalRentorSum', 'corporateRentorSum', 'totalSum', 'notifications', 'notifications_count'));
    }

    public function clerkDashboard()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.clerk.dashboard', compact('user', 'notifications', 'notifications_count'));
    }

    public function managerDashboard()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;
        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.branchmanager.dashboard', compact('user', 'notifications', 'notifications_count'));
    }

    public function success()
    {

        $user = Auth::user();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.success', compact('user', 'notifications', 'notifications_count'));
    }

    public function corporateSuccess()
    {

        $user = Auth::user();
        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.corporatesuccess', compact('user', 'notifications', 'notifications_count'));
    }


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

    }

    public function profile()
    {

        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;

        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.user.profile', compact('user', 'notifications', 'notifications_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function surrender()
    {
        $id = Auth::user()->id;
        $recipientPhone = Auth::user()->phone;

        $user = User::where('id', $id)->first();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.surrender_box', compact('user', 'notifications', 'notifications_count'));

    }

    //User surrenderbox post method
    public function postsurrender()
    {

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $destination_box = $user['postbox_id'];
        $post_code = $user['postcode_id'];
        $post_email = $user['email'];
        $phone = $user['phone'];

        DB::table('emails')
            ->where('from', $post_email)
            ->orwhere('to', $post_email)
            ->delete();

        //Remove notifications
        DB::table('notifications')
            ->where('sender_phone', $phone)
            ->orwhere('recipient_phone', $phone)
            ->delete();


        //Delete contact details
        Contact::where('user_id', $id)->delete();

        //Delete estamps for that user
        DB::table('estamps')->where('destination_box', $destination_box)->delete();

        //Avail the code for use by another member who register
        DB::table('post_boxes')
            ->where('post_code', $post_code)
            ->where('number', $destination_box)
            ->update(['status' => 1]);
        //delete role_user of deactivated account
        DB::table('role_user')->where('user_id', $id)->delete();

        //Delete user from the system
        User::where('id', $id)->delete();


        Auth::logout();
        return redirect()->route('home');

    }

    public function edit($id)
    {
        $user = User::find($id);
        $counties = \DB::table('counties')->lists('name', 'id');
        $selectedCounty = \DB::table('users')->where('id', $id)->pluck('county_id');
        $post_boxes = \DB::table('users')->where('id', $id)->pluck('postbox_id');
        $post_codes = \DB::table('users')->where('id', $id)->pluck('postcode_id');

        //$role = \DB::table('role_user')->where('id', $id)->pluck('postcode_id');

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();


        return view('backend.user.edit', compact('user', 'counties', 'post_boxes', 'post_codes', 'selectedCounty', 'notifications', 'notifications_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function editPic($id)
    {
        $user = User::find($id);
        $counties = \DB::table('counties')->lists('name', 'id');
        $selectedCounty = \DB::table('users')->where('id', $id)->pluck('county_id');
        $post_boxes = \DB::table('users')->where('id', $id)->pluck('postbox_id');
        $post_codes = \DB::table('users')->where('id', $id)->pluck('postcode_id');

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();


        return view('backend.user.editpic', compact('user', 'counties', 'post_boxes', 'post_codes', 'selectedCounty', 'notifications', 'notifications_count'));
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
            //$user->username                 = Input::get('username');
            $user->phone = Input::get('phone');
            $user->county_id = Input::get('county_id');
            $user->town = Input::get('town');
            $user->postbox_id = Input::get('postbox_id');
            $user->postcode_id = Input::get('postcode_id');
            $user->identification_number = Input::get('identification_number');
            $user->current_email = Input::get('current_email');

            if (Input::hasFile('pic')) {
                $image = Input::file('pic');

                $unique = $user->id;

                $filename = $image->getClientOriginalName();
                // $filename = 'ID-'.$unique.'-'.$image;
                $filename = 'user' . $unique . '-' . $filename;

                $path = public_path('uploads/user/' . $filename);

                Image::make($image->getRealPath())->resize(140, 140)->save($path);
                $user->pic = $filename;

            } else {
                $user->pic = 'noimage.png'; //no erroneous nullity  
            }


            $user->save();

            Session::flash('message', 'Successfully created box!');

            return redirect('/user/account')
                ->with('message', 'Successfully created Profile!');
        }
    }


    public function getPasswordReset()
    {
        return view('auth.password-reset');
    }

    public function passwordReset()
    {
        $phone = Input::get('phone');

        if (!User::where('phone', $phone)->exists()) {

            $errors = new MessageBag(['errors' => ['Phone number does not exist in our records.']]);

            return Redirect::back()->withInput()->with('errors', $errors);

        } else {
            $code = rand(1000, 9999);
            $new_password = bcrypt($code);

            User::where('phone', $phone)->update(array('password' => $new_password));

            $message = 'Use the code ' . $code . ' as your password to login.';

            $notify = new SendSMSController();
            $notify->sendSms($phone, $message);

            return redirect()->route('reset.success');
        }
    }

    public function getChangePassword()
    {
        $user = Auth::user();

        $recipientPhone = Auth::user()->phone;

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.user.changepassword', compact('user', 'notifications', 'notifications_count'));
    }

    public function changePassword()
    {

        $user = Auth::user();

        $user_id = $user->id;

        $password = Input::get('password');
        $repeat_password = Input::get('repeat_password');


        if ($password != $repeat_password) {

            $errors = new MessageBag(['errors' => ['Password do not match.']]);

            return Redirect::back()->withInput()->with('errors', $errors);

        } else {

            $new_password = bcrypt($password);

            User::where('id', $user_id)->update(array('password' => $new_password));

            return redirect()->route('user.dashboard');
        }
    }

    public function getPdf()
    {

        return view('backend.pdf.file');
    }


    public static function createCertificate()
    {

        $user = Auth::user();
        $userId = $user->id;
        $userName = $user->first_name . " " . $user->last_name;
        $userBox = $user->postbox_id . "-" . $user->postcode_id;
        $userTown = $user->town;
        $createdAt = $user->created_at->format('d-M-Y');

        $dt = Carbon::parse($createdAt);
        $validTo = $dt->addYear()->format('d-M-Y');

        // initiate FPDI
        $pdf = new FPDI();
        // add a page
        $pdf->AddPage();

        // set the source file
        $path = public_path();
        $pdf->setSourceFile($path . "/PostaCertificate.pdf");

        // import page 1
        $tplIdx = $pdf->importPage(1);
        // use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($tplIdx, 5, 10, 200);

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(158, 38);
        $pdf->Write(0, 'PCK-' . $userId);

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(80, 140);
        $pdf->Write(0, $userName);

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(80, 160);
        $pdf->Write(0, $userBox . ', ' . $userTown);

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(105, 175);
        $pdf->Write(0, $createdAt);

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(150, 175);
        $pdf->Write(0, $validTo);


        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(45, 216);
        $pdf->Write(0, 'Manager');

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(135, 216);
        $pdf->Write(0, 'PMG');

        $filename = $path . "/uploads/mail_attach/PCK-" . $userId . ".pdf";
        $pdf->Output($filename, 'F');
        // $pdf->Output();

    }

    public function fpdi()
    {

        $user = Auth::user();
        $userId = $user->id;

        // initiate FPDI
        $pdf = new FPDI();
        // add a page
        $pdf->AddPage();
        // set the source file
        $path = public_path();
        $pdf->setSourceFile($path . "/PostaCertificate.pdf");
        // import page 1
        $tplIdx = $pdf->importPage(1);
        // use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($tplIdx, 5, 10, 200);

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(160, 38);
        $pdf->Write(0, '983778');

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(80, 140);
        $pdf->Write(0, 'Jack Kodera');

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(80, 160);
        $pdf->Write(0, '76343-00100, Nairobi');

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(105, 175);
        $pdf->Write(0, '12-02-2016');

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(150, 175);
        $pdf->Write(0, '12-02-2017');


        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(45, 216);
        $pdf->Write(0, 'Manager');

        // now write some text above the imported page
        $pdf->SetFont('Helvetica');
        $pdf->SetXY(135, 216);
        $pdf->Write(0, 'PMG');

        $filename = $path . "/uploads/certificate/PCK-" . $userId . ".pdf";
        $pdf->Output($filename, 'F');
        // $pdf->Output();

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

    //Testing phpMail By Magige
    public function phpMail()
    {
        $mail = new \PHPMailer(true);
        try {

            $mail->isSMTP(); // tell to use smtp
            $mail->CharSet = "utf-8"; // set charset to utf8
            $mail->SMTPAuth = true;  // use smpt auth
            $mail->SMTPSecure = "tls"; // or ssl
            $mail->Host = "MAIL.2BUILDWEALTH.COM";
            $mail->Port = 25; // most likely something different for you. This is the mailtrap.io port i use for testing.

            $mail->Username = "buildwea";
            $mail->Password = "kenX2Build";

            $mail->setFrom("100010-00100@posta.co.ke", "Magige Daniel");
            $mail->Subject = "Mail Test from Enjiwa Address";
            $mail->MsgHTML("This is to show that Enjiwa address can send mail out! We are waiting to get SMTP Credentials from posta to make receiving possible");
            $mail->addAddress("magigedaniel@gmail.com", "Magige Daniel");
            //$mail->AddCC('kodera.jack@gmail.com', 'Jack Kodera');
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->send();
        } catch (phpmailerException $e) {
            dd($e);
        } catch (Exception $e) {
            dd($e);
        }
        die('success Mail sent');
    }

    //Postboxes management that is insert and updates
    public function getPostcode()
    {

        //Staff::where('active', 0)->update(array('postcode' => '00100'));
//        $counties = \DB::table('counties')->orderBy('name', 'asc')->lists('name', 'id');
//        $post_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');
        $post_codes = \DB::table('post_codes')->selectRaw('CONCAT(number, " - ", zone) as post_code, number')->orderBy('post_code', 'asc')->lists('post_code', 'number');


        return view('bulkboxgenerate', compact('post_codes'));

        dd('Done');
    }

    public function addPostcode()
    {

        // dd(Input::all());

        $min = Input::get('min');
        $max = Input::get('max');
        $posta = Input::get('postcode_id');

        for ($count = $min; $count <= $max; $count++) {
            $box              = new \App\Models\Box;
            $box->post_code=$posta;
            $box->number=$count;
            //$box->status=1;
            $box->save();
        }
        Session::flash('message', "Box Generated");
        return Redirect::back();
    }

    public function deleteUsers(){

        DB::table('users')->where('created_at', '<', '2016-12-15')->delete();
        

        echo "Deleted";
    }

    public function test(){

        $user = User::where('agent_phone', '0721989812')->get();

        dd($user);
    }
}