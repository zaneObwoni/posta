<?php

namespace App\Http\Controllers\Api;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

use App\Models\User as User;
use App\Models\Staff as Staff;
use App\Models\Role as Role;
use App\Models\Email as Email;

use App\Logic\Mailers\UserMailer;
use App\Logic\User\UserRepository;

use Auth, DB, Input, Validator, Session, Request;

use \PDF, Response, FPDI;
use Carbon\Carbon;


class AuthController extends Controller
{

	public function __construct(Guard $auth, UserRepository $userRepository)
    {

        $this->auth = $auth;
        $this->userRepository = $userRepository;
        // $this->captchaTrait = $captchaTrait;
    }


	public function index()
	{
		$id = Auth::user()->id;
		$user = User::where('id', $id)->first();
		// dd($user);

        return view('backend.user.dashboard', compact('user'));
	}


	public function postLogin(){

		$input = Input::all();

		$email      = $input["email"];
        $password   = $input["password"];
        $remember   = 1;

        if (Auth::attempt(['email' => $email, 'password' => $password])){

        	// $id = User::where('email', $email)->value('id');
        	$user = User::where('email', $email)->first();

        	return Response::json([
        		'status' 				=> 'Success',
        		'message' 				=> 'Logged In',
        		'id' 					=> $user->id,
        		'first_name' 			=> $user->first_name,
        		'last_name' 			=> $user->last_name,
        		'email' 				=> $user->email,
        		'username' 				=> $user->username,
        		'phone' 				=> $user->phone,
        		'town' 					=> $user->town,
        		'identification_number' => $user->identification_number,
        		'pin' 					=> $user->pin,
        		'postcode_id' 			=> $user->postcode_id,
        		'postbox_id' 			=> $user->postbox_id,
        		'current_email' 		=> $user->current_email,
                'role'                  => $user->role,
        		'activated' 			=> $user->activated,
        		'created_at' 			=> $user->created_at
        		]);
        	// return "success: ". $id;
		}else{

		    // return "fail: Email and Password not correct.";
		    return Response::json(['status' => 'Failed', 'message' => 'Email or Password not correct.']);
		}
	}

    public function deliveryOfficerLogin(){

        $input          = Input::all();

        $email          = $input["email"];
        $idNumber = Staff::where('email', $email)->value('id_no');
        $inputIDNumber       = $input["id_no"];

        if ($inputIDNumber == $idNumber){

            $user = Staff::where('id_no', $idNumber)->first();

            return Response::json([
                    'status'        => 'Success',
                    'message'       => 'Logged In',
                    'id'            => $user->id,
                    'email'         => $user->email,
                    'first_name'    => $user->first_name,
                    'last_name'     => $user->last_name,
                    'id_no'         => $user->id_no,
                    'employee_no'   => $user->employee_no,
                    'county'        => $user->county,
                    'city'          => $user->city,
                    'postcode'      => $user->postcode,
                    'phone'         => $user->phone,
                    'vehicle_type'  => $user->vehicle_type,
                    'reg_no'        => $user->reg_no
                ]);
        }else{

            // return "fail: Email and Password not correct.";
            return Response::json(['status' => 'Failed', 'message' => 'ID or Registration Number do not match.']);
        }
    }

	public function postRegister(){

		$input = Input::all();

	    $first_name 			= $input["first_name"];
		$last_name 				= $input["last_name"];
		// $username 				= $input["username"];
		$password 				= $input["password"];
		$confirm_password 		= $input["confirm_password"];
		$phone 					= $input["phone"];
		$town 					= $input["town"];
		$county_id 				= $input["county_id"];
		$identification_number 	= $input["identification_number"];
		$pin 					= $input["pin"];
		$postcode_id 			= $input["postcode_id"];
		$postbox_id 			= $input["postbox_id"];
		$current_email 			= $input["current_email"];

        // $trans_id               = $input["trans_id"];

		$user                           = new User;

        $user->first_name               = ucfirst($first_name);
        $user->last_name                = ucfirst($last_name);
        // $user->username                 = $username;
        $user->password                 = bcrypt($password);
        $user->phone                    = $phone;
        $user->town                     = ucfirst($town);
        $user->county_id                = $county_id;
        $user->identification_number    = $identification_number;
        $user->current_email            = $current_email;

        $user->identification_number    = $identification_number;
        $user->postbox_id               = $postbox_id;
        $user->postcode_id              = $postcode_id;

        $key = \Config::get('app.key');
        $activationCode = hash_hmac('sha256', str_random(40), $key);

        $yourEmail                      = $postbox_id."-".$postcode_id."@posta.co.ke";

        $user->email                    = $yourEmail;
        $user->activation_code          = $activationCode;
        $user->active                   = 0;

        $validator = Validator::make($input, User::$rules, User::$messages);

 		if (User::where('email', '=', $user->email)->exists()) {

        	return Response::json(['status' => 'Failed', 'message' => 'The Email Address exists in our Records.']);
		}

        $user->save();

        //Assign Role
        $role = Role::whereName('user')->first();
        $user->assignRole($role);

        $data = [
            'postnumber'    => $user->postbox_id,
            'postcode'      => $user->postcode_id,
            'email'         => $user->email
            // 'password'         => $user->password
        ];

		$id = User::where('email', $user->email)->value('id');

        //Attach certificate and Send Email
        $emailMessage = "Welcome to Posta and thank you for acquiring your own P.O. Box! To login, you must use your email " . $user->email . ". Your password is the one you used at registration. Attached here with is your certificate of ownership which expires every year and it is renewed everytime you renew your subscription.";

        $email = new Email;
        $email->from = "noreply@posta.co.ke";
        $email->to = $user->email;
        $email->file_attachment = "PCK-".$user->id.".pdf";
        $email->subject = "Welcome to Posta";
        $email->body = $emailMessage;
        $email->save();

        AuthController::createCertificate($user->id);

        $to = $user->phone;
        $message = 'Registration successful! You have been allocated P.O. Box No. ' . $user->postbox_id . '-' . $user->postcode_id . ', ' . $user->town . '. Your email address at posta is ' . $user->email . ".";

        $notify = new \App\Http\Controllers\SendSMSController();
        $notify->sendSms($to, $message);



		return Response::json([
		'status' 				=> 'Success',
		'message' 				=> 'Account Created',
		'id' 					=> $id,
		'first_name' 			=> $user->first_name,
		'last_name' 			=> $user->last_name,
		'email' 				=> $user->email,
		'phone' 				=> $user->phone,
		'town' 					=> $user->town,
		'identification_number' => $user->identification_number,
		'pin' 					=> $user->pin,
		'postcode_id' 			=> $user->postcode_id,
		'postbox_id' 			=> $user->postbox_id,
		'current_email' 		=> $user->current_email,
		'activated' 			=> $user->activated,
		'created_at' 			=> $user->created_at
		]);

	}

    public static function createCertificate($id)
    {

        $user = User::where('id', $id)->first();
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

}