<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Type
 * @package App\Models
 * @version July 14, 2021, 1:55 pm UTC
 *
 * @property string $name
 */
class Type extends Model
{


    public $table = 'types';
    



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
