<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplicationRequest extends FormRequest
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
        $unique = $this->isMethod('POST') ? 'unique:users,email' : 'unique:users,email,'.$this->profile->load('user')->user->id;

        return [
            'available_job_id' => ['required', 'integer', 'exists:available_jobs,id'],
            'first_name' => ['required', 'string', 'min:3', 'max:25'],
            'last_name' => ['required', 'string', 'min:3', 'max:25'],
            'email' => ['required', 'string', 'email', $unique],
            'phone' => ['required', 'string', 'min:11', 'max:15'],
            'nationality' => ['required', 'string', 'min:3', 'max:100'],
            'driving_license' => ['required', 'string', 'min:3', 'max:100'],
            'birth_place' => ['required', 'string', 'min:4', 'max:100'],
            'birth_date' => ['required', 'integer'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'address' => ['required', 'string', 'min:4'],
            'postal_code' => ['required', 'digits_between:3,15'],
        ];
    }
}
