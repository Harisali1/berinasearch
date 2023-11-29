<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Agent
 * @package App\Models
 * @version July 24, 2021, 11:28 am UTC
 *
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $image
 */
class Agent extends Model
{


    public $table = 'agents';




    public $fillable = [
        'name',
        'email',
        'phone',
        'image'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'image' => 'required',
    ];


}
