<?php namespace App\Logic\User;

use App\Logic\Mailers\UserMailer;
use App\Models\Role;

use App\Models\User;
use App\Models\ProductUser;

use App\Models\Password;
use Hash, Carbon\Carbon;

use URL, DB, Auth, Redirect, Input;

class UserRepository {

    protected $userMailer;

    public function __construct( UserMailer $userMailer )
    {
        $this->userMailer = $userMailer;
    }

    public function register( $data )
    {

        $user                           = new User;
        
        $user->first_name               = ucfirst($data['first_name']);
        $user->last_name                = ucfirst($data['last_name']);
        $user->phone                    = $data['phone'];

        $user->town                     = ucfirst($data['town']);
        $user->county_id                = $data['county_id'];
        $user->username                 = ucfirst($data['username']);
        $user->current_email            = $data['current_email'];
        
        $user->password                 = bcrypt($data['password']);

        $user->identification_number    = $data['identification_number'];
        $user->postbox_id               = $data['postbox_id'];
        $user->postcode_id              = $data['postcode_id'];
        

        if(Input::hasFile($data['identification_image']))
        {
            $image            = Input::file($data['identification_image']);

            

            $unique = mt_rand(1000000, 9999999);
            
            $filename   = $image->getClientOriginalName();
            // $filename = 'ID-'.$unique.'-'.$image;
            $filename = 'ID-'.$unique.'-'.$filename;

            $path   = public_path('uploads/id/' .$filename);

                Image::make($image->getRealPath())->resize(140, 140)->save($path);
                $user->identification_image = $filename;

        }else{
            $user->identification_image = 'noimage.png'; //no erroneous nullity  
        }        


        $key = \Config::get('app.key');
        $activationCode = hash_hmac('sha256', str_random(40), $key);

        $yourEmail                      = $data['email']."@posta.co.ke";

        $user->email                    = $yourEmail;
        $user->activation_code          = $activationCode;
        $user->active                   = 0;
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

    }
    
    


    public function resetPassword( User $user  )
    {
        $token = sha1(mt_rand());
        $password = new Password;
        $password->email = $user->email;
        $password->token = $token;
        $password->created_at = Carbon::now();
        $password->save();

        $data = [
            'first_name'    => $user->first_name,
            'token'         => $token,
            'subject'       => 'Example.com: Password Reset Link',
            'email'         => $user->email
        ];

        $this->userMailer->passwordReset($user->email, $data);
    }
}