<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoryFormRequest extends FormRequest
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
            'story_title' => 'required|min:6|max:63',
            'story_summary' =>  'required|min:20|max:2000',
            'story_cover' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'genre' => [
                'requrired', 
                'exists' => Rule::exists('metas,id')->where(function ($query) {
                    $query->where('type', 'category');
                }),
            ],
        ];
    }
}
