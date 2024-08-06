<?php

namespace App\Requests;

use App\Response\ErrorResponse;

abstract class BaseFormRequest
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    abstract public function rules(): array;

    private function sanitizeField($value): string
    {
        // Trim whitespace and remove special characters
        $value = trim($value);
        return preg_replace('/[^a-zA-Z0-9\s]/', '', $value);
    }

    public function validate(): void
    {
        foreach ($this->data as $field => $value) {
            if (is_string($value)) {
                $this->data[$field] = $this->sanitizeField($value);
            }
        }

        $rules = $this->rules();
        foreach ($rules as $field => $rule) {
            $value = $this->data[$field] ?? null;
            if (! $rule($value)) {
                $response = new ErrorResponse("Invalid value for $field", 422);
                $response->send();
                exit;
            }
        }
    }

    public function validated(): array
    {
        return $this->data;
    }
}