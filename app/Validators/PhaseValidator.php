<?php namespace App\Validators;

/**
 * Class PhaseValidator
 *
 * Parent class for other validators
 *
 * @package App\Validators
 */
class PhaseValidator
{
    protected $fails = false; // For adding additional validations that don't use a validator
    protected $validator;

    /**
     * Failure indicator. Return true if 'fails' is true otherwise
     * check the validator
     *
     * @return bool
     */
    public function fails()
    {
        return ($this->fails || $this->validator->fails());
    }

    /**
     * Return the inverse of fails()
     *
     * @return bool
     */
    public function passes()
    {
        return !$this->fails();
    }
}