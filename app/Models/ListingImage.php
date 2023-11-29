<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'path',
        'size',
        'format',
        'listing_id'

    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
