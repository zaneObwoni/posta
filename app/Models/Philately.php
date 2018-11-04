<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Philately extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'philately';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cost', 'branch', 'stamps', 'phone'
    ];

    public static $rules = [
        'cost'         => 'required',
        'branch'       => 'required',
        'stamps'       => 'required',
        'phone'        => 'required'
    ];
}
