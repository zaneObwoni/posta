<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'activated', 'activation_code'];

    public static $rules = [
        'first_name'                    => 'required',
        'last_name'                     => 'required',
        // 'current_email'                 => 'required|email',
        'email'                         => 'email|unique:users',
        'phone'                         => 'required|numeric',
        // 'password'                      => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
        'password'                      => 'required|min:6',
        'confirm_password'              => 'required|same:password'
    ];


    public static $messages = [
        'first_name.required'           => 'First Name is required',
        'last_name.required'            => 'Last Name is required',
              
        'password.required'             => 'Sorry! Password is required',
        'password.min'                  => 'Sorry! Password must have at least 6 characters',
        'password.regex'                => 'Sorry! Password must have a special character and a digit',
        'current_email.taken'           => 'The alternative email entered is already taken'
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role')->withTimestamps();
    }

    public function hasRole($name)
    {
        foreach($this->roles as $role)
        {
            if($role->name == $name) return true;
        }

        return false;
    }

    public function assignRole($role)
    {
        return $this->roles()->attach($role);
        // return $this->roles()->sync($role, $detaching = true);
    }

    public function is_admin(){
        return $this->roles()->where('role_id', 1)->first();
    }
    
    public function isAdmin(){
        return $this->roles()->where('role_id', 1)->first();
    }

    public function isPostMaster(){
        return $this->roles()->where('role_id', 2)->first();
    }

    public function isUser(){
        return $this->roles()->where('role_id', 3)->first();
    }
    
    public function isAgent(){
        return $this->roles()->where('role_id', 5)->first();
    }

    public function isLogisticsOfficer(){
        return $this->roles()->where('role_id', 6)->first();
    }

    public function isClerk(){
        return $this->roles()->where('role_id', 7)->first();
    }

    public function isCorporate(){
        return $this->roles()->where('role_id', 8)->first();
    }

    public function isPhilately(){
        return $this->roles()->where('role_id', 9)->first();
    }

    public function isCustomerCare(){
        return $this->roles()->where('role_id', 10)->first();
    }

    public function isPMG(){
        return $this->roles()->where('role_id', 11)->first();
    }

    public function isFinance(){
        return $this->roles()->where('role_id', 12)->first();
    }

    public function isAgentPay(){
        return $this->roles()->where('role_id', 13)->first();
    }
    
    public function getIsAdminAttribute()
    {
        return true;
    }

    public function county(){

        return $this->belongsTo('App\Models\County', 'county_id');
    }
}
