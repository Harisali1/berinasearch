<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteListingAPIRequest extends FormRequest
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
            'listing_id' => 'required|unique:listings,id',
            'user_id' => 'required|unique:users,id',
        ];
    }
}
