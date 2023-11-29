<?php

namespace App\Repositories;

use App\Models\Listing;
use App\Repositories\BaseRepository;

/**
 * Class ListingRepository
 * @package App\Repositories
 * @version July 14, 2021, 2:03 pm UTC
*/

class ListingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'slug',
        'type_id',
        'no_of_room',
        'price',
        'image'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Listing::class;
    }
}
