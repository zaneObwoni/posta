<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'postal_location_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'postal_code', 'postal_town', 'county'
    ];
}
