<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User as User;
// use App\Models\Corporate as Corporate;
use App\Models\Role as Role;
use App\Models\Location as Location;
use App\Models\Notification as Notification;
use App\Models\Email as Email;


use App\Logic\User\UserRepository;
use App\Logic\User\CorporateRepository;
use App\Http\Controllers\SendSMSController;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\MessageBag;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Validator, Auth;
use Redirect;
use Input, Request;

use Image;
use DB;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $loginPath = '/login';
    // protected $redirectTo = '/user/products';
    protected $redirectAfterLogout = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */

    protected $auth;

    protected $userRepository;
    protected $corporateRepository;

    protected $businessRepository;

    public function __construct(Guard $auth, UserRepository $userRepository, CorporateRepository $corporateRepository)
    {

        $this->auth = $auth;
        $this->userRepository = $userRepository;
        $this->corporateRepository = $corporateRepository;
        // $this->captchaTrait = $captchaTrait;
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getPassword()
    {
        return view('auth.password');
    }

    public function password()
    {

        $email = Input::get('email');
        $password = Input::get('password');
        $cpassword = Input::get('cpassword');
        $remember = Input::get('remember');


        $user = DB::table('users')->where('email', $email)->where('password', '')->first();
        //dd($user);
        if($user ==null)
        {
            $errors = new MessageBag(['errors' => ['You already have password Or Your account is not valid go to login page and try to login!']]);

            return Redirect::back()->withInput()->with('errors', $errors);

        }
        $passwords= bcrypt($password );


        DB::table('users')
            ->where('email', $email)
            ->update(['password' => $passwords]);

        // ?$validator = Validator::make($input, User::$rules, User::$messages);
        if ($this->auth->attempt([
            'email' => $email,
            'password' => $password
        ], $remember == 1 ? true : false)
        ) {

            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('admin.dashboard');
                // return view('backend.admin.dashboard');
            }

            if (Auth::user()->hasRole('Corporate')) {
                return redirect()->route('user.dashboard');
            }

            if (Auth::user()->hasRole('User')) {
                return redirect()->route('user.dashboard');
            }
            //Branch manager
            if (Auth::user()->hasRole('BranchManager')) {

                $user = Auth::user();

                $recipientPhone = Auth::user()->phone;
                $recipientEmail = Auth::user()->email;

                $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
                $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
                $emails_count = Email::where('to', $recipientEmail)->count();

                return redirect()->route('admin.branchmanager');
            }
            //Agent
            if (Auth::user()->hasRole('Agent')) {
                $user = Auth::user();

                $recipientPhone = Auth::user()->phone;
                $recipientEmail = Auth::user()->email;

                $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
                $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
                $emails_count = Email::where('to', $recipientEmail)->count();

                return view('backend.agent.dashboard', compact('user', 'notifications', 'notifications_count', 'emails_count'));
            }

            if (Auth::user()->hasRole('Philately')) {
                return redirect()->route('user.dashboard');
            }

            if (Auth::user()->hasRole('Customercare')) {
                return redirect()->route('user.dashboard');
            }

        }else{

            $errors = new MessageBag(['errors' => ['You already have password in your account, go to login page']]);

            return Redirect::back()->withInput()->with('errors', $errors);
        }

    }

    public function choose(){

        return view('auth.physical.choose');
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function getAgentLogin()
    {
        return view('auth.agent-login');
    }

    public function postLogin()
    {
        $email = Input::get('email');
        $password = Input::get('password');
        $remember = Input::get('remember');

        //$a = 'How are you?';
        $val = strstr($email, '@', true);
        if ($val== false) {

            $email=$email.'@posta.co.ke';
        }

        if ($this->auth->attempt([
            'email' => $email,
            'password' => $password
        ], $remember == 1 ? true : false)
        ) {

            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('admin.dashboard');
                // return view('backend.admin.dashboard');
            }

            if (Auth::user()->hasRole('PMG')) {
                return redirect()->route('admin.dashboard');
                // return view('backend.admin.dashboard');
            }

            if (Auth::user()->hasRole('Corporate')) {
                return redirect()->route('user.dashboard');
            }

            if (Auth::user()->hasRole('User')) {
                
                if($password == is_numeric($password) && strlen($password) == 4){
                    return redirect()->route('user.changepassword');
                }else{
                    return redirect()->route('user.dashboard');
                }
            }
            //Post Master
            if (Auth::user()->hasRole('Post Master')) {
                $user = Auth::user();

                $recipientPhone = Auth::user()->phone;
                $recipientEmail = Auth::user()->email;

                $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
                $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
                $emails_count = Email::where('to', $recipientEmail)->count();

                return redirect()->route('pm.dashboard');
            }
            //Agent
            if (Auth::user()->hasRole('Agent')) {
                $user = Auth::user();

                $recipientPhone = Auth::user()->phone;
                $recipientEmail = Auth::user()->email;

                $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
                $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
                $emails_count = Email::where('to', $recipientEmail)->count();

                // dd('Agent');
                // return view('backend.user.dashboard', compact('user', 'notifications', 'notifications_count', 'emails_count'));
                return redirect()->route('user.dashboard');
            }

            //Clerk
            if (Auth::user()->hasRole('Counter Clerk')) {
                $user = Auth::user();

                $recipientPhone = Auth::user()->phone;
                $recipientEmail = Auth::user()->email;

                $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
                $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
                $emails_count = Email::where('to', $recipientEmail)->count();

                return redirect()->route('clerk.dashboard');
            }

            if (Auth::user()->hasRole('Philately')) {
                return redirect()->route('user.dashboard');
            }

            if (Auth::user()->hasRole('Customercare')) {
                return redirect()->route('user.dashboard');
            }

            if (Auth::user()->hasRole('Finance')) {
                return redirect()->route('user.dashboard');
            }

            if (Auth::user()->hasRole('AgentPay')) {
                return redirect()->route('user.dashboard');
            }
            
            //Logistics Officer
            if (Auth::user()->hasRole('Logistics')) {

                $user = Auth::user();

                $recipientPhone = Auth::user()->phone;
                $recipientEmail = Auth::user()->email;

                $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
                $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();
                $emails_count = Email::where('to', $recipientEmail)->count();

                return view('backend.logistics.dashboard', compact('user', 'notifications', 'notifications_count', 'emails_count'));
            }

            }else{

                $errors = new MessageBag(['errors' => ['Wrong Email and/or password. Retype and try again!']]);

                return Redirect::back()->withInput()->with('errors', $errors);
            }
    }

    public function postAgentLogin()
    {
        $email = Input::get('email');
        $password = Input::get('password');
        $remember = Input::get('remember');

        //$a = 'How are you?';
        $val = strstr($email, '@', true);
        if ($val== false) {

            $email=$email.'@posta.co.ke';
        }

        if ($this->auth->attempt([
            'email' => $email,
            'password' => $password
        ], $remember == 1 ? true : false)
        ) {

            //Agent
            if (Auth::user()->hasRole('Agent')) {
                $user = Auth::user();

                $recipientPhone = Auth::user()->phone;
                $recipientEmail = Auth::user()->email;

                $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
                $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();


                $emails_count = Email::where('to', $recipientEmail)->count();

                return view('backend.agent.dashboard', compact('user', 'notifications', 'notifications_count', 'emails_count'));
            }else{

                $errors = new MessageBag(['errors' => ['Make sure you are an Agent and Check if you input the correct Email and/or password and Retype and try again!']]);

                return Redirect::back()->withInput()->with('errors', $errors);
            }
        }else{
            $errors = new MessageBag(['errors' => ['Make sure you are an Agent and Check if you input the correct Email and/or password and Retype and try again!']]);

            return Redirect::back()->withInput()->with('errors', $errors);
        }
    }

    public function getPasswordReset()
    {
        return view('auth.password-reset');
    }

    public function passwordReset()
    {
        $phone = Input::get('phone');

        if(!User::where('phone', $phone)->exists()){

            $errors = new MessageBag(['errors' => ['Phone number does not exist in our records.']]);

            return Redirect::back()->withInput()->with('errors', $errors);

        }else{
            $code = rand(1000,9999);
            $new_password = bcrypt($code);

            User::where('phone', $phone)->update(array('password' => $new_password));
            $email = User::where('phone', $phone)->value('email');

            $message = 'The temporary password for your account '.$email.' is '.$code.'. You may change it after you log in.';

            $notify = new SendSMSController();
            $notify->sendSms($phone, $message);

            return redirect()->route('reset.success');
        }
    }

    public function resetSuccess()
    {
        return view('auth.resetsuccess');
    }

    public function getLogout()
    {
        \Auth::logout();

        // return redirect()->route('auth.login')
        Session::flush();
        return redirect('/')
            ->with('status', 'success')
            ->with('message', 'Logged out');

    }

    public function getregisterall()
    {
        return view('register');
    }


    public function getCreateContact()
    {
        $counties = \DB::table('counties')->orderBy('name', 'asc')->lists('name', 'id');
        $post_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');
        $post_codes = \DB::table('post_codes')->orderBy('number', 'asc')->lists('number', 'number');

        $recipientPhone = Auth::user()->phone;
        $recipientEmail = Auth::user()->email;
        $user = Auth::user();

        $notifications = Notification::where('recipient_phone', $recipientPhone)->get();
        $notifications_count = Notification::where('recipient_phone', $recipientPhone)->count();

        return view('backend.estamps.create-contact', compact('user', 'counties', 'post_boxes', 'post_codes', 'notifications', 'notifications_count'));
    }

    public function postCreateContact()
    {

        $input = Input::all();

        $user = Auth::User();

        $name = ucfirst(Input::get('first_name'));
        $phone = ucfirst(Input::get('phone'));
        $town = Input::get('town');


        $postcode_id = Input::get('postcode_id');
        $postbox_id = Input::get('postbox_id');
        $posta_email = $postbox_id . '-' . $postcode_id . '@posta.co.ke';

        DB::table('contact')->insert([
                'phone_number' => $phone,
                'user_id' => $user->id,
                'postcode_id' => $postcode_id,
                'postbox_id' => $postbox_id,
                'posta_email' => $posta_email,
                'name' => $name,
                'town' => $town
                ]
        );

        $message = 'Contact Created Successfully';
        return Redirect::route('estamps.contact')->with('message', $message);

    }

    public function validateFileUpload($image)
    {
        //Validate image upload
        $allowedExts = array(
            "jpeg",
            "jpg",
            "png"
        );

        $allowedMimeTypes = array(
            'image/jpeg',
            'image/png',
            'application/pdf'
        );

        $filename = $image->getClientOriginalName();
        $extension = pathinfo($filename, PATHINFO_EXTENSION);


        if ( ! ( in_array($extension, $allowedExts ) ) ) {
            return false;
            //dd('Please provide another file type .');
        }
        return true;
    }

    public function getRegister()
    {
        $counties = \DB::table('counties')->orderBy('name', 'asc')->lists('name', 'id');
        $post_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');

        //New post code with location knonw as zone
        $post_codes=\DB::table('post_codes')->selectRaw('CONCAT(number, " - ", zone) as post_code, number')->orderBy('post_code','asc')->lists('post_code', 'number');


        return view('auth.users.register', compact('counties', 'post_boxes', 'post_codes'));
    }

    public function postRegister()
    {

        $input = Input::all();

        $validator = Validator::make($input, User::$rules, User::$messages);

        $user = new User;

        $user->first_name = ucfirst(Input::get('first_name'));
        $user->last_name = ucfirst(Input::get('last_name'));
        $user->phone = Input::get('phone');


        $user->dob = ucfirst(Input::get('dob'));
        $user->occupation = ucfirst(Input::get('occupation'));
        $user->gender = Input::get('gender');
        $user->town = ucfirst(Input::get('town'));
        $user->county_id = Input::get('county_id');
        $user->current_email = Input::get('current_email');

        $user->password = bcrypt(Input::get('password'));

        $user->identification_number = Input::get('identification_number');
        $user->pin = Input::get('pin');
        $user->postbox_id = Input::get('postbox_id');
        $user->postcode_id = Input::get('postcode_id');
        $user->agent_phone = Input::get('agent_phone');


        if($user->postbox_id == "Select Post"){
            return redirect()->back()
                ->withErrors('Make sure you select your Post Code and Post Box Again.')
                ->withInput();
        }

        if (Input::hasFile('identification_image')) {
            $image = Input::file('identification_image');
            $image_valid=$this->validateFileUpload($image);

        if(!$image_valid)
        {
            return redirect()->back()
                ->withErrors('File type you are uploading is not supported! Only Images Supported')
                ->withInput();
        }


            $unique = mt_rand(1000000, 9999999);
            $filename = $image->getClientOriginalName();
            // $filename = 'ID-'.$unique.'-'.$image;
            $filename = 'ID-' . $unique . '-' . $filename;
            $path = public_path('uploads/id/' . $filename);

            Image::make($image->getRealPath())->resize(140, 140)->save($path);
            $user->identification_image = $filename;

        } else {
            $user->identification_image = 'noimage.png'; //no erroneous nullity  
        }

        if (Input::hasFile('identification_image_back')) {
            $image = Input::file('identification_image_back');

            $image_valid=$this->validateFileUpload($image);
            if(!$image_valid)
            {
                return redirect()->back()
                    ->withErrors('File type you are uploading is not supported! Only Images Supported')
                    ->withInput();
            }


            $unique = mt_rand(1000000, 9999999);

            $filename = $image->getClientOriginalName();
            // $filename = 'ID-'.$unique.'-'.$image;
            $filename = 'ID-' . $unique . '-' . $filename;
            $path = public_path('uploads/id/' . $filename);

            Image::make($image->getRealPath())->resize(140, 140)->save($path);
            $user->identification_image_back = $filename;

        } else {
            $user->identification_image_back = 'noimage.png'; //no erroneous nullity  
        }


        $key = \Config::get('app.key');
        $activationCode = hash_hmac('sha256', str_random(40), $key);

        $yourEmail = $user->postbox_id . "-" . $user->postcode_id . "@posta.co.ke";

        $user->email = $yourEmail;
        $user->activation_code = $activationCode;
        $user->active = 0;


        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        if (User::where('email', '=', $user->email)->exists()) {
            User::where('email', '=', $user->email)->delete();

            //$message = "Sorry! The Box Number you have selected is already in use. Kindly select another from the list provided.";
            //return redirect()->back()
                //->withErrors($message)
                //->withInput();
        } else {

            $user->save();

            //Assign Role
            $role = Role::whereName('User')->first();
            $user->assignRole($role);

            $email = $user->email;
            $password = Input::get('password');

            if (!Auth::attempt(['email' => $email, 'password' => $password])) {
                // return response()->json(array('errors'=>array('Invalid username or password')));
                $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);

                return Redirect::back()
                    ->withErrors($errors)
                    ->withInput(Input::except('password'));

            } else {
                return Redirect::route('success');
            }
        }
    }

    public function getPhysicalUserRegister()
    {
        $counties = \DB::table('counties')->orderBy('name', 'asc')->lists('name', 'id');

        return view('auth.physical.register-user', compact('counties'));
    }

    public function postPhysicalUserRegister()
    {

        $input = Input::all();

        $rules = array(
                'first_name' => 'required',
                'last_name' => 'required',
                'phone'  => 'required',
                'town' => 'required',
                'postbox' => 'required',
                'postcode' => 'required',
                'identification_number' => 'required'
            );

        $validator = Validator::make($input, $rules);

        $user = new User;

        $user->first_name = ucfirst(Input::get('first_name'));
        $user->last_name = ucfirst(Input::get('last_name'));
        $user->phone = Input::get('phone');
        $user->identification_number = Input::get('identification_number');
        $user->county_id = Input::get('county_id');
        $user->town = ucfirst(Input::get('town'));

        $user->password = bcrypt(Input::get('password'));
        $user->postbox_id = Input::get('postbox');
        $user->postcode_id = Input::get('postcode');

        $key = \Config::get('app.key');
        $activationCode = hash_hmac('sha256', str_random(40), $key);

        $yourEmail = $user->postbox_id . "-" . $user->postcode_id . "@posta.co.ke";

        $user->email = $yourEmail;
        $user->code = 1111;
        $user->activation_code = $activationCode;
        $user->active = 0;


        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        if (User::where('email', '=', $user->email)->exists()) {
            // User::where('email', '=', $user->email)->delete();

            $message = "Sorry! The Box Number you have given has been registered by someone else. If you are sure you are the owner, kindly visit your post office with the original documents for the box or send them by email to customercare@posta.co.ke for verification.";
            return redirect()->back()
                ->withErrors($message)
                ->withInput();
        } else {

            $user->save();

            //Assign Role
            $role = Role::whereName('User')->first();
            $user->assignRole($role);
            
            $message = "Dear ".$user->first_name.", your application has been received and is being processed. Kindly log in to your account using your user ID: ".$user->postbox_id."-".$user->postcode_id."@posta.co.ke and the password you provided at registration.";
            $phone = $user->phone;

            $notify = new SendSMSController();
            $notify->sendSms($phone, $message);

            $email = $user->email;
            $password = Input::get('password');
            if (!Auth::attempt(['email' => $email, 'password' => $password])) {
                // return response()->json(array('errors'=>array('Invalid username or password')));
                $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);

                return Redirect::back()
                    ->withErrors($errors)
                    ->withInput(Input::except('password'));

            } else {
                return Redirect::route('user.dashboard');
            }
        }
    }

    public function getPhysicalCorporateRegister()
    {
        $counties = \DB::table('counties')->orderBy('name', 'asc')->lists('name', 'id');

        return view('auth.physical.register-corporate', compact('counties'));
    }

    public function postPhysicalCorporateRegister()
    {

        $input = Input::all();

        // dd($input);

        $rules = array(
                'first_name' => 'required',
                'last_name' => 'required',
                'phone'  => 'required',
                'town' => 'required',
                'postbox' => 'required',
                'postcode' => 'required',
                'identification_number' => 'required'
            );

        $validator = Validator::make($input, $rules);

        $user = new User;

        $user->first_name = ucfirst(Input::get('first_name'));
        $user->last_name = ucfirst(Input::get('last_name'));
        $user->phone = Input::get('phone');
        $user->identification_number = Input::get('identification_number');
        $user->county_id = Input::get('county_id');
        $user->town = ucfirst(Input::get('town'));

        $user->password = bcrypt(Input::get('password'));
        $user->postbox_id = Input::get('postbox');
        $user->postcode_id = Input::get('postcode');

        $key = \Config::get('app.key');
        $activationCode = hash_hmac('sha256', str_random(40), $key);

        $yourEmail = $user->postbox_id . "-" . $user->postcode_id . "@posta.co.ke";

        $user->email = $yourEmail;
        $user->code = 1111;
        $user->activation_code = $activationCode;
        $user->active = 0;

        if($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if(User::where('email', '=', $user->email)->exists()) {
            // User::where('email', '=', $user->email)->delete();

            $message = "Sorry! The Box Number you have given has been registered by someone else. If you are sure you are the owner, kindly visit your post office with the original documents for the box or send them by email to customercare@posta.co.ke for verification.";
            return redirect()->back()
                ->withErrors($message)
                ->withInput();
        }else{

            $user->save();

            //Assign Role
            $role = Role::whereName('Corporate')->first();
            $user->assignRole($role);

            $message = "Dear ".$user->first_name.", your application has been received and is being processed. Kindly log in to your account using your user ID: ".$user->postbox_id."-".$user->postcode_id."@posta.co.ke and the password you provided at registration.";
            $phone = $user->phone;

            $notify = new SendSMSController();
            $notify->sendSms($phone, $message);

            $email = $user->email;
            $password = Input::get('password');
            if(!Auth::attempt(['email' => $email, 'password' => $password])) {
                // return response()->json(array('errors'=>array('Invalid username or password')));
                $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);

                return Redirect::back()
                    ->withErrors($errors)
                    ->withInput(Input::except('password'));

            }else{
                return Redirect::route('user.dashboard');
            }
        }
    }

    public function postEditstaff()
    {
        $input = Input::all();

    }

    public function postRegisterstaff()
    {

        $input = Input::all();


        $user = new User;

        $user->first_name = ucfirst(Input::get('first_name'));
        $user->last_name = ucfirst(Input::get('last_name'));
        $user->phone = Input::get('phone');
        $user->gender = Input::get('gender');
        $user->employee_no = Input::get('employee_no');


        $user->dob = ucfirst(Input::get('dob'));
        $user->occupation = ucfirst(Input::get('occupation'));
        $user->gender = Input::get('gender');
        $user->town = ucfirst(Input::get('town'));
        $user->county_id = Input::get('county_id');
        $user->current_email = Input::get('current_email');

        $user->password = bcrypt(Input::get('password'));

        $user->identification_number = Input::get('identification_number');
        $user->pin = Input::get('pin');
        $user->postcode_id = Input::get('postcode_id');
        $user->role = Input::get('role');

        if (Input::hasFile('identification_image')) {
            $image = Input::file('identification_image');

            $unique = mt_rand(1000000, 9999999);

            $filename = $image->getClientOriginalName();
            // $filename = 'ID-'.$unique.'-'.$image;
            $filename = 'ID-' . $unique . '-' . $filename;

            $path = public_path('uploads/id/' . $filename);

            Image::make($image->getRealPath())->resize(140, 140)->save($path);
            $user->identification_image = $filename;

        } else {
            $user->identification_image = 'noimage.png'; //no erroneous nullity
        }

        if (Input::hasFile('identification_image_back')) {
            $image = Input::file('identification_image_back');

            $unique = mt_rand(1000000, 9999999);

            $filename = $image->getClientOriginalName();
            // $filename = 'ID-'.$unique.'-'.$image;
            $filename = 'ID-' . $unique . '-' . $filename;

            $path = public_path('uploads/id/' . $filename);

            Image::make($image->getRealPath())->resize(140, 140)->save($path);
            $user->identification_image_back = $filename;

        } else {
            $user->identification_image_back = 'noimage.png'; //no erroneous nullity
        }


        $key = \Config::get('app.key');
        $activationCode = hash_hmac('sha256', str_random(40), $key);

        $yourEmail = input::get('posta_email');

        $user->email = $yourEmail;
        $user->activation_code = $activationCode;
        $user->active = 1;
        $user->staff = 1;
        if (User::where('email', '=', $yourEmail)->exists()) {

            User::where('email', '=', $yourEmail)->update(['staff' => 1]);
        } else {
            $user->save();
        }
        $user_id = User::select('id')->where('email', $yourEmail)->first();

        if (DB::table('role_user')->where('user_id', '=', $user_id->id)->exists()) {
            DB::table('role_user')->where('user_id', $user_id->id)->update(['role_id' => Input::get('role')]);
        } else {
            DB::table('role_user')->insert(
                ['role_id' => Input::get('role'), 'user_id' => $user_id->id]
            );
        }

        \Session::flash('message', "Staff Successfully Added to the Posta system!");
        return Redirect::back();
        //return Redirect::back()->withErrors(['msg', 'Success']);
    }

    public function getCorporate()
    {
        $counties = \DB::table('counties')->orderBy('name', 'asc')->lists('name', 'id');
        $post_boxes = \DB::table('post_boxes')->orderBy('number', 'asc')->lists('number', 'number');
        $post_codes=\DB::table('post_codes')->selectRaw('CONCAT(number, " - ", zone) as post_code, number')->orderBy('post_code','asc')->lists('post_code', 'number');

        return view('auth.users.corporate', compact('counties', 'post_boxes', 'post_codes'));
    }


    public function postCorporate()
    {
        $input = Input::all();


        $validator = Validator::make($input, User::$rules, User::$messages);


        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User;

        $user->first_name = ucfirst(Input::get('first_name'));
        $user->last_name = ucfirst(Input::get('last_name'));
        $user->phone = Input::get('phone');
        $user->director_name = ucfirst(Input::get('director_name'));
        $user->director_id = ucfirst(Input::get('director_id'));

        $user->town = ucfirst(Input::get('town'));
        $user->county_id = Input::get('county_id');
        $user->current_email = Input::get('current_email');

        $user->password = bcrypt(Input::get('password'));

        $user->identification_number = Input::get('identification_number');
        $user->pin = Input::get('pin');
        $user->postbox_id = Input::get('postbox_id');
        $user->postcode_id = Input::get('postcode_id');
        $user->agent_phone = Input::get('agent_phone');
        

        if($user->postbox_id == "Select Post"){
            return redirect()->back()
                ->withErrors('Make sure you select your Post Box Again.')
                ->withInput();
        }

        if (Input::hasFile('identification_image')) {
            $image = Input::file('identification_image');

            $image_valid=$this->validateFileUpload($image);
            if(!$image_valid)
            {
                return redirect()->back()
                    ->withErrors('File type you are uploading is supported! Only PDF and Images Supported')
                    ->withInput();
            }

            $unique = mt_rand(1000000, 9999999);

            $filename = $image->getClientOriginalName();
            // $filename = 'ID-'.$unique.'-'.$image;
            $filename = 'ID-' . $unique . '-' . $filename;

            $path = public_path('uploads/id/' . $filename);

            Image::make($image->getRealPath())->resize(140, 140)->save($path);
            $user->identification_image = $filename;

        } else {
            $user->identification_image = 'noimage.png'; //no erroneous nullity
        }


        if (Input::hasFile('pdf_certificate')) {

            $pdf_name = mt_rand(100000, 999999);
            $filename = 'Cert-' . $pdf_name . '.pdf';

            $image = Input::file('pdf_certificate');

            $image_valid=$this->validateFileUpload($image);
            if(!$image_valid)
            {
                return redirect()->back()
                    ->withErrors('File type you are uploading is supported! Only PDF and Images Supported')
                    ->withInput();
            }

            if (Input::file('pdf_certificate')->move('uploads/certificate/', $filename)) {

            } else {
            }

            $user->pdf_certificate = $filename;
        } else {
            $user->pdf_certificate = 'no_file.pdf'; //no erroneous nullity
        }

        $key = \Config::get('app.key');
        $activationCode = hash_hmac('sha256', str_random(40), $key);

        $yourEmail = $user->postbox_id . "-" . $user->postcode_id . "@posta.co.ke";

        $user->email = $yourEmail;
        $user->activation_code = $activationCode;
        $user->active = 0;

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // if (User::where('postbox_id', '=', null)) {

        //     $message = "Sorry! The Box Box Cannot be Empty.";
        //     return redirect()->back()
        //         ->withErrors($message)
        //         ->withInput();
        // }

        if (User::where('email', '=', $user->email)->exists()) {

            $message = "Sorry! The Box Number you have selected is already in use. Kindly select another from the list provided.";
            return redirect()->back()
                ->withErrors($message)
                ->withInput();
        } else {

            $user->save();

            //Update table post_code
            DB::table('post_boxes')
                ->where('post_code', '=', Input::get('postcode_id'))
                ->where('number', '=', Input::get('postbox_id'))
                ->update(['status' => 1]);


            $role = Role::whereName('Corporate')->first();
            $user->assignRole($role);

            $email = $user->email;
            $password = Input::get('password');

            if (!Auth::attempt(['email' => $email, 'password' => $password])) {
                // return response()->json(array('errors'=>array('Invalid username or password')));
                $errors = new MessageBag(['password' => ['Invalid Email and/or password']]);

                return Redirect::back()
                    ->withErrors($errors)
                    ->withInput(Input::except('password'));

            } else {
                return Redirect::route('corporatesuccess');
            }
        }
    }


    public function myBox()
    {

        return view('frontend.successful', compact('data'));
        // return view('backend.user.products', compact('products', 'user', 'productuser', 'sum'));
    }

    /**
     * User account activation page.
     *
     * @param  string $actvationCode
     * @return
     */
    public function getActivate($activationCode = null)
    {
        // Is the user logged in?

        Auth::check();
        // Get the user we are trying to activate
        // $user = User::where('activation_code', $activationCode)->exists();
        $user = User::where('activation_code', $activationCode)->first();
        // dd($user);

        // Try to activate this user account
        if (User::where('activation_code', $activationCode)->exists()) {

            $update_table = DB::table('users')
                ->where('activation_code', '=', $user['activation_code'])
                ->update(['activated' => 1]);

            // Redirect to the login page
            $message = 'Activated your Account';
            return Redirect::route('auth.login')->with('message', $message);
        } else {

            // The activation failed.
            $message = 'Error occured. Not activated';
            return Redirect::route('auth.login')->with('message', $message);
        }

    }



    public function newUser()
    {

        $user = new User;
        $user->email = 'email@email.com';
        $user->first_name = 'first_name';
        $user->last_name = 'last_name';
        // $user->username         = 'username';
        $user->password = brcypt('password');
        $user->save();

    }

    public function fakeUser()
    {

        $user = new User;

        $user->staff = 1;
        $user->first_name = 'Admin';
        $user->last_name = 'Admin';
        $user->password = bcrypt('admin');;
        $user->phone = '0720-000-000';
        $user->town = '7348';
        $user->county_id = '1';
        $user->code = '7348';

        $user->identification_number = '2934872094';
        $user->postbox_id = '1000-';
        $user->postcode_id = '00100';
        $yourEmail = 'noreply@posta.co.ke';

        $user->email = $yourEmail;


        $key = \Config::get('app.key');
        $activationCode = hash_hmac('sha256', str_random(40), $key);

        $user->activation_code = $activationCode;
        $user->active = 1;
        $user->save();

        //Assign Role
        $role = Role::whereName('admin')->first();
        $user->assignRole($role);

        dd('Done');
    }

    public function fakePMG()
    {

        $user = new User;
        $user->staff = 1;
        $user->first_name = 'Main';
        $user->last_name = 'PMG';
        $user->password = bcrypt('pmg');;
        $user->phone = '0711000111';
        $user->town = 'Nairobi';
        $user->county_id = 1;
        $user->code = '0000';

        $user->identification_number = '2934872094';
        $user->postbox_id = '10000';
        $user->postcode_id = '00100';
        $yourEmail = 'pmg@posta.co.ke';

        $user->email = $yourEmail;
        $user->role = 11;

        $key = \Config::get('app.key');
        $activationCode = hash_hmac('sha256', str_random(40), $key);

        $user->activation_code = $activationCode;
        $user->active = 1;
        $user->save();

        //Assign Role
        $role = Role::whereName('pmg')->first();
        $user->assignRole($role);

        dd('Done');
    }
}
