<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'name' => 'bail|required|min:3|max:15',
            'email' => 'bail|required|email|unique:users,email',
            'password' => 'bail|required|min:8|confirmed'

        ];
    }

    // public function messages() :array 
    // {
    // return [
    //     'password' =>'your password must be 8 or more characters'
    // ];
    // }
}
