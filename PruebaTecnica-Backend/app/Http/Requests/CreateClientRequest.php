<?php

namespace App\Http\Requests;

class CreateClientRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:1|max:255',
            'last_name' => 'required|min:1|max:255',
            'email' => 'required|email',
            'age' => 'required|integer|min:1|max:99',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'phone_number' => 'required|min:1|max:255'
        ];
    }
}
