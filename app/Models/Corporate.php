<?php 

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Corporate extends Model implements AuthenticatableContract, CanResetPasswordContract
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
        'first_name'            => 'required',
        'last_name'             => 'required',
        'current_email'                 => 'required|unique:users',
        'phone'                 => 'required|numeric|unique:users',
        'password'              => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
        'confirm_password' => 'required|same:password'
    ];


    public static $messages = [
        'first_name.required'           => 'Corporation Name is required',
        'last_name.required'            => 'Corporation Address is required',
        
        'email.required'                => 'Email is required',
        'email.email'                   => 'Email is invalid',
        'password.required'             => 'Password is required',
        'password.min'                  => 'Password needs to have at least 6 characters',
        'password.regex'                  => 'Password must have an upper letter, special character and a digit',
        'current_email.taken'       =>'The alternative email entered is already taken'
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

    public function isModerator(){
        return $this->roles()->where('role_id', 2)->first();
    }    

    public function isUser(){
        return $this->roles()->where('role_id', 3)->first();
    }
    public function isCorporate(){
        return $this->roles()->where('role_id', 4)->first();
    }

    public function getIsAdminAttribute()
    {
        return true;
    }

    public function county(){

        return $this->belongsTo('App\Models\County', 'county_id');
    }
}
