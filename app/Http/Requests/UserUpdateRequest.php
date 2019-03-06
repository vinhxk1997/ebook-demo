<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'loginname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'confirmed',
            'avatar_file' => 'image|mimes:jpg,jpeg,png,gif',
            'cover_image' => 'image|mimes:jpg,jpeg,png,gif',
        ];
    }
}
