<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class MovieUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $movie = $this->route()->parameter('movie');

        return Gate::allows('update', $movie);
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
            'rating' => ['required', 'min:1', 'max:10', 'numeric',],
            'award_winning' => ['nullable', 'sometimes', 'numeric',],
            'genres' => ['array', 'required', 'exists:genres,id'],
        ];
    }
}
