<?php

namespace App\Http\Requests\API;

use App\Models\Listing;
use InfyOm\Generator\Request\APIRequest;

class CreateListingAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'type_id' => 'required|exists:types,id',
            'price' => 'required',
            'no_of_room' => 'required',
            'city' => 'required',
            'location' => 'required',
            'image_ids' => 'required|array',
        ];
    }
}
