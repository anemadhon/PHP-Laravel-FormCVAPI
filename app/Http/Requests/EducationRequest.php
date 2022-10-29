<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
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
            'school' => ['required', 'string', 'min:3', 'max:100'],
            'degree' => ['required', 'string', 'min:3', 'max:100'],
            'start_date' => ['required', 'integer'],
            'end_date' => ['required', 'integer'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'description' => ['required', 'string', 'min:3'],
        ];
    }
}
