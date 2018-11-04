<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentCollection extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agent_collection';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id', 'stamp_code'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // protected $hidden = ['password', 'remember_token', 'activated', 'activation_code'];

    public static $rules = [
        'agent_id'     => 'required',
        'stamp_code'          	=> 'required',
    ];
}
