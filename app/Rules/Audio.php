<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Audio implements Rule
{
    private $allowedMimes = [
      'mp3',
      'wav'
    ];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array($value->getClientOriginalExtension(), $this->allowedMimes);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid audio file.';
    }
}
