<?php

namespace App\Http\Requests;

class ForgotPasswordRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }
}
