<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registered extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'registered_mails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recipient_phone', 'sender_phone'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = ['password', 'remember_token', 'activated', 'activation_code'];

    public static $rules = [
        'destination_box'           => 'required',
        'destination_code'          => 'required',

        'origin_town'          => 'required',
        'destination_town'          => 'required',

        'destination_code'          => 'required',
        'recipient_phone'          => 'required',
        'recipient_name'          => 'required',
        'origin_town'          => 'required',
        'letter_weight'          => 'required',

    ];
}
