<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="name" value="{{ __('user.first_name') }}" />
                    <x-jet-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" placeholder="Jan" :value="old('first_name')" required autofocus autocomplete="first_name" />
                </div>
                <div class="md:w-1/2 px-3">
                    <x-jet-label for="name" value="{{ __('user.last_name') }}" />
                    <x-jet-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" placeholder="Kowalski" :value="old('last_name')" required autofocus autocomplete="last_name" />
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <x-jet-label for="pesel_number" value="{{ __('user.pesel') }}" />
                    <x-jet-input id="pesel_number" class="block mt-1 w-full" type="text" name="pesel_number" :value="old('pesel_number')" required />
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <x-jet-label for="email" value="{{ __('user.email') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                </div>
            </div>
            <div class="-mx-3 md:flex mb-2">
                <div class="md:w-2/3 px-3 mb-6 md:mb-0">
                    <x-jet-label for="street" value="{{ __('user.street') }}" />
                    <x-jet-input id="street" class="block mt-1 w-full" type="text" name="street" autocomplete="street" :value="old('street')" />
                </div>
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <x-jet-label for="street_number" value="{{ __('user.street_number') }}" />
                    <x-jet-input id="street_number" class="block mt-1 w-full" type="text" name="street_number" min="1" required autocomplete="street_number" :value="old('street_number')" />
                </div>
            </div>
            <div class="-mx-3 md:flex mb-5">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="city" value="{{ __('user.city') }}" />
                    <x-jet-input id="city" class="block mt-1 w-full" type="text" name="city" required autocomplete="city" :value="old('city')" />
                </div>

                <div class="md:w-1/2 px-3">
                    <x-jet-label for="voivodeship" value="{{ __('user.voivodeship') }}" />
                    <x-voivodeship-select id="voivodeship" type="select" name="voivodeship" required autocomplete="voivodeship" :value="old('voivodeship')" />
                </div>
                <div class="md:w-1/2 px-3">
                    <x-jet-label for="postcode" value="{{ __('user.zip') }}" />
                    <x-jet-input id="postcode" class="block mt-1 w-full" type="text" name="postcode" required autocomplete="postcode" placeholder="12-345" :value="old('postcode')" />
                </div>
            </div>
            <hr/>
            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('user.password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <p class="text-grey-dark text-xs italic">{{ __('user.password-tip') }}</p>
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('user.confirm-password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('user.already-registered') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('user.register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
