<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_boxes';

    public $timestamps = true;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = ['password', 'remember_token', 'activated', 'activation_code'];

    public static $rules = [
        'post_code'           => 'required',
    ];
}
