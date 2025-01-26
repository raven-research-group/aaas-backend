<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password'=> [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]+$/'
            ],
            'organization_name' => 'required|string|max:255',
            'primary_contact'   => 'required|string|max:255',
            'secondary_contact' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => config('requestBody.passwordRegex.message'),
        ];
    }
}
