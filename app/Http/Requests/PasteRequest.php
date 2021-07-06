<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasteRequest extends FormRequest
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
            'title' => 'required|max:200',
            'links' => 'array|required|min:1',
            'privacy' => 'required',
            'description' => 'max:300',
            'links.*.title' => 'required|string',
            'links.*.original_link' => 'required|url',
        ];
    }

    public function messages()
    {
        return [
            'links.*.title.required' => 'Link title field is required',
            'links.*.original_link.required' => 'Original link field is required',
            'links.*.original_link.url' => 'The link format is invalid',
        ];
    }
}
