<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Listing;

class UpdateListingRequest extends FormRequest
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
           'type_id' => 'required',
           'no_of_room' => 'required',
           'price' => 'required',
           'description' => 'required'
       ];
    }
}
