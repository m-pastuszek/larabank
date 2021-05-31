<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'first_name'        => ['required', 'string', 'max:20', 'min:3'],
            'last_name'         => ['required', 'string', 'max:20', 'min:3'],
            'email'             => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'street'            => ['string', 'max:255', 'nullable'],
            'street_number'     => ['required', 'max:10'],
            'city'              => ['required', 'max:255'],
            'zip'               => ['required', 'max:6'],
            'photo'             => ['nullable', 'image', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'first_name'        => $input['first_name'],
                'last_name'         => $input['last_name'],
                'email'             => $input['email'],
                'street'            => $input['street'],
                'street_number'     => $input['street_number'],
                'city'              => $input['city'],
                'zip'               => $input['zip'],
                'voivodeship_id'    => $input['voivodeship_id'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
