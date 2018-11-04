<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'user_id', 'transaction', 'payment_status','amount'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = ['password', 'remember_token', 'activated', 'activation_code'];

    public static $rules = [
        // 'first_name'            => 'required',
        // 'last_name'             => 'required',
        // 'username'              => 'required|unique:users',
        // 'email'                 => 'required|email|unique:users',
        // 'phone'                 => 'required',
        // 'password'              => 'required|min:2|max:20',
        // 'password_confirmation' => 'required|same:password',
    ];
}
