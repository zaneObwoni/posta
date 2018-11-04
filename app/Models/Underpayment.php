<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Underpayment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'underpayments';

    public $timestamps = true;
}
