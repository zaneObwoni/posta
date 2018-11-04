<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenewalReminder extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'renewal_reminders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'message', 'user_id'
    ];
}
