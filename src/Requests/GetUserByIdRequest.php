<?php

namespace App\Requests;

class GetUserByIdRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'id' => function ($value) {
                return is_numeric($value) && $value > 0;
            }
        ];
    }
}