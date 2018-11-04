<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatusNew extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_status_new';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount', 'description', 'merchant_transaction_id', 'msisdn'
    ];
}
