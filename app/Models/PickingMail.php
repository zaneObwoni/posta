<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Staff as Staff;

class PickingMail extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'picking_mails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'building_name', 'street', 'town'
    ];

    public static $rules = [
        'name'            => 'required',
        'id_number'       => 'required',
        'phone'           => 'required'
    ];
}
