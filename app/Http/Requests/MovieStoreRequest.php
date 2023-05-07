<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:1', 'max:240',],
            'description' => ['required', 'min:1', 'max:2400',],
            'image' => ['required', ],
            'release_date' => ['required', 'date'],
            'rating' => ['required', ],
            'award_winning' => ['nullable', 'sometimes', 'numeric'],
            'genres' => ['array', 'required', 'exists:genres,id'],
        ];
    }
}
