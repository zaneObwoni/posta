<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'from', 'to', 'subject', 'body'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = ['password', 'remember_token', 'activated', 'activation_code'];

    public static $rules = [
        // 'from'           => 'required',
        // 'to'                => 'required',
        'subject'           => 'required',
         // 'body'          => 'required'
    ];

    public static $messages = [
        // 'to.required'           => 'To email address is required',
        'subject.required'      => 'Email Subject cannot be blank!'
        // 'body.required'      => 'Email body cannot be blank!'
    ];

}
