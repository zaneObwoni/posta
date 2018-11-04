<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymentDetail extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_payment_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phonenumber','amount', 'reference'
    ];
}
