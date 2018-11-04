<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bestwish extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bestwishes';

    public $timestamps = true;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = ['password', 'remember_token', 'activated', 'activation_code'];

    public static $rules = [
        'recipient_name'           => 'required',
    ];
}
