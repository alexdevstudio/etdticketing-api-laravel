<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
          'user_first_name' => 'required|string|max:255',
          'user_last_name' => 'required|string|max:255',
          'user_geo_location' => 'required|numeric',
          'user_office' => 'required|numeric',
          'user_floor' => 'required|numeric',
          'user_telephone' => 'required|numeric',
          'user_email' => 'required|string|email|unique:users|max:255',
          'user_password' => 'required|string|min:6|max:255|confirmed'
            //
        ];
    }
}
