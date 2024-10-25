<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterPostRequest extends FormRequest
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
            'name'=> 'required|unique:users|min:8|max:255',
            'email'=> 'required|unique:users|email:rfc,dns',
            'phone_number' => 'nullable|max:11',
            'birthday'=> 'nullable',
        ];
    }

    /**
     * The URI that users should be redirected to if validation fails.
     *
     * @var string
     */

    //Validation customize the redirect
    protected $redirect = '/register';


    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */

    //Validation customize attribute in error message
    public function attributes(): array
    {
        return [
            'name' => 'username',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    //Validation customize error message
    public function messages(): array
    {
        return [
            'name.unique' => 'This username has been already existed',
            'email.unique' => 'This email address has been already existed',
        ];
    }
}
