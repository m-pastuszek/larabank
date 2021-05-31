<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Pesel\Exceptions\InvalidCharactersException;
use Pesel\Exceptions\InvalidChecksumException;
use Pesel\Exceptions\InvalidLengthException;
use Pesel\Exceptions\PeselValidationException;
use Pesel\Pesel;

class PeselValidation implements Rule
{
    public $errorMessage;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        try {
            Pesel::create($value);
        } catch(InvalidLengthException $e) {
            $this->errorMessage = 'Wprowadzony numer PESEL ma nieprawidłową długość.';
            return false;
        } catch(InvalidCharactersException $e) {
            $this->errorMessage = 'Wprowadzony numer PESEL zawiera nieprawidłowe znaki.';
            return false;
        } catch(InvalidChecksumException $e) {
            $this->errorMessage = 'Wprowadzony numer PESEL zawiera błędną sumę kontrolną.';
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMessage;
    }
}
