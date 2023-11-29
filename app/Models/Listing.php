<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Listing
 * @package App\Models
 * @version July 14, 2021, 2:03 pm UTC
 *
 * @property string $title
 * @property string $slug
 * @property integer $type_id
 * @property integer $no_of_room
 * @property string $price
 * @property string $image
 */
class Listing extends Model
{
    public $table = 'listings';
    public $fillable = [
        'admin_id',
        'user_id',
        'title',
        'slug',
        'type_id',
        'category_id',
        'price',
        'no_of_room',
        'no_of_bed',
        'no_of_bath',
        'image',
        'city',
        'country',
        'zip_code',
        'state',
        'location',
        'lat',
        'lng',
        'address',
        'description',
        'area'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'slug' => 'string',
        'type_id' => 'integer',
        'no_of_room' => 'integer',
        'price' => 'string',
        'image' => 'string',
        'description' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'type_id' => 'required|exists:types,id',
        'price' => 'required',
        'no_of_room' => 'required',
        'city' => 'required',
        'location' => 'required',
        'image_ids' => 'required|array',
    ];

    public function images()
    {
        return $this->hasMany(ListingImage::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favorite()
    {
        return $this->belongsToMany(User::class);
    }
}
