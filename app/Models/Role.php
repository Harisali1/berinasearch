<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Role
 * @package App\Models
 * @version July 14, 2021, 12:13 pm UTC
 *
 * @property integer $name
 */
class Role extends Model
{


    public $table = 'roles';




    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
