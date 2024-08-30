<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Username implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $value)) {
            $fail('The :attribute must only contain alphanumeric characters and underscores.');
        }
    }
}