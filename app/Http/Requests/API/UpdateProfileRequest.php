<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateProfileRequest extends FormRequest
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
        $user = User::whereApiToken(request()->bearerToken())->firstOrFail();

        $rules = [
            'email' => 'unique:users,email,'.$user->id,
            'phone' => 'unique:users,phone,'.$user->id,
        ];

        return $rules;
    }
}
