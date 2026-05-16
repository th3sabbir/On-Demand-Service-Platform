<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Library\CustomFailedValidation;

class AdminLoginRequest extends CustomFailedValidation
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // Allow the request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string',
            //'password' => 'required|min:6',
            'password' => 'required',
            'remember' => 'boolean', // Add this line to include the remember option
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Email or Username is required',
            'username.string' => 'Enter a valid email address or username',
            'password.required' => 'Password is required',
            //'password.min' => 'Password must be at least 6 characters long',
        ];
    }

    public function validationData()
    {
        // Read input from JSON payload
        return $this->json()->all();
    }
}