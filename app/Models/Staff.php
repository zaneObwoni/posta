<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;



class Staff extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'staffs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
    */
    
    public static $rules = [
        'first_name'                    => 'required',
        'last_name'                     => 'required'
    ];


    public static $messages = [
        'first_name.required'           => 'First Name is required',
        'last_name.required'            => 'Last Name is required'
    ];


    
}
