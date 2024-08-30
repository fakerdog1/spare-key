<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^([0-9\s\-\+\(\)]*)$/', $value) || strlen($value) < 10 || strlen($value) > 20) {
            $fail('The :attribute must be a valid phone number.');
        }
    }
}