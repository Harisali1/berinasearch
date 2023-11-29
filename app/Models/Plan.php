<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Plan
 * @package App\Models
 * @version August 26, 2021, 4:37 pm UTC
 *
 * @property string $title
 * @property string $limit
 * @property integer $price
 * @property integer $no_of_listing
 * @property string $description
 */
class Plan extends Model
{


    public $table = 'plans';
    



    public $fillable = [
        'title',
        'limit',
        'price',
        'no_of_listing',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'limit' => 'string',
        'price' => 'integer',
        'no_of_listing' => 'integer',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
