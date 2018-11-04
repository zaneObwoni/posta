<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estamp extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'estamps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receiver_phone'
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

        'destination_town'          => 'required',

        'destination_code'          => 'required',
        'recipient_phone'          => 'required',
        'recipient_name'          => 'required',
        'letter_weight'          => 'required',
    ];
}
