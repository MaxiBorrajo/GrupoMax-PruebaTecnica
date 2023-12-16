<?php

namespace App\Http\Requests;

class CreateUserRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:1|max:255',
            'last_name' => 'required|min:1|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => "The value of 'password' attribute must have at least one lowercase letter, one uppercase letter, one digit, one special character, and be 8 characters or longer"
        ];
    }
}
