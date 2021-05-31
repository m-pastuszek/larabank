<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\PeselValidation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Pesel\Pesel;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $validator = Validator::make($input, [
            'first_name'        => ['required', 'string', 'max:20', 'min:3'],
            'last_name'         => ['required', 'string', 'max:20', 'min:3'],
            'pesel_number'      => ['required', 'min:11', 'max:11', 'unique:users', new PeselValidation],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'street'            => ['string', 'max:255', 'nullable'],
            'street_number'     => ['required', 'max:10'],
            'city'              => ['required', 'max:255'],
            'voivodeship'       => ['required'],
            'postcode'          => ['required', 'max:6'],
            'password'          => $this->passwordRules(),
        ])->validate();

        return User::create([
            'first_name'        => $input['first_name'],
            'last_name'         => $input['last_name'],
            'pesel_number'      => $input['pesel_number'],
            'email'             => $input['email'],
            'street'            => $input['street'],
            'street_number'     => $input['street_number'],
            'city'              => $input['city'],
            'voivodeship_id'    => $input['voivodeship'],
            'zip'               => $input['postcode'],
            'birth_date'        => Pesel::create($input['pesel_number'])->getBirthDate(),
            'password'          => Hash::make($input['password']),
            'locale'            => 'pl',
            'status'            => 1, // konto nieaktywne
            'role_id'           => 2
        ]);
    }
}
