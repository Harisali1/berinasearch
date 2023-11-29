<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Category
 * @package App\Models
 * @version August 25, 2021, 5:49 pm UTC
 *
 * @property string $title
 * @property string $image
 * @property boolean $status
 */
class Category extends Model
{


    public $table = 'categories';




    public $fillable = [
        'title',
        'image',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'image' => 'string',
        'status' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'image' => 'required',
    ];

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

}
