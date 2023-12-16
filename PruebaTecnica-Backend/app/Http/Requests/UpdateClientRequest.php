<?php

namespace App\Http\Requests;

class UpdateClientRequest extends ApiRequest
{

    public function rules(): array
    {
        return [
            'email' => 'email',
            'age' => 'integer|min:1',
            'status' => 'in:ACTIVE,INACTIVE',
        ];
    }
}
