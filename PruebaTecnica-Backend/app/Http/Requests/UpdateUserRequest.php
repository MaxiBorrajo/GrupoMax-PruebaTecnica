<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'email' => 'email|unique:users,email',
        ];
    }
}
