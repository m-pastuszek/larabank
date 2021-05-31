<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('pages.profile.information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('pages.profile.information-info') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->

        <!-- Full Name -->
        <div class="col-span-6 sm:col-span-4">
            <div class="-mx-3 md:flex mb-2">
                <div class="md:w-2/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="first_name" value="{{ __('user.first_name') }}" />
                    <x-jet-input id="first_name" type="text" class="block mt-1 w-full" wire:model.defer="state.first_name" />
                    <x-jet-input-error for="first_name" class="mt-2" />
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <x-jet-label for="last_name" value="{{ __('user.last_name') }}" />
                    <x-jet-input id="last_name" type="text" class="block mt-1 w-full" wire:model.defer="state.last_name" />
                    <x-jet-input-error for="last_name" class="mt-2" />
                </div>
            </div>
        </div>
        <!-- PESEL -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="pesel_number" value="{{ __('user.pesel') }}" />
            <x-jet-input id="pesel_number" type="text" class="block mt-1 w-full" wire:model.defer="state.pesel_number" disabled/>
            <x-jet-input-error for="pesel_number" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('user.email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>

        <!-- Street & Number -->
        <div class="col-span-6 sm:col-span-4">
            <div class="-mx-3 md:flex mb-2">
                <div class="md:w-2/3 px-3 mb-6 md:mb-0">
                    <x-jet-label for="street" value="{{ __('user.street') }}" />
                    <x-jet-input id="street" type="text" class="mt-1 block w-full" wire:model.defer="state.street" />
                    <x-jet-input-error for="street" class="mt-2" />
                </div>
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <x-jet-label for="street_number" value="{{ __('user.street_number') }}" />
                    <x-jet-input id="street_number" type="number" min="1" class="mt-1 block w-full" wire:model.defer="state.street_number" />
                    <x-jet-input-error for="street_number" class="mt-2" /></div>
            </div>
        </div>

        <!-- Voivodeship -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="voivodeship" value="{{ __('user.voivodeship') }}" />
            <x-voivodeship-select id="voivodeship" type="select" name="voivodeship" wire:model.defer="state.voivodeship_id"/>
            <x-jet-input-error for="voivodeship" class="mt-2" />
        </div>
        <!-- Zip & City -->
        <div class="col-span-6 sm:col-span-4">
            <div class="-mx-3 md:flex mb-2">
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <x-jet-label for="zip" value="{{ __('user.zip') }}" />
                    <x-jet-input id="zip" type="text" class="block mt-1 w-full" wire:model.defer="state.zip" />
                    <x-jet-input-error for="zip" class="mt-2" />
                </div>
                <div class="md:w-2/3 px-3 mb-6 md:mb-0">
                    <x-jet-label for="city" value="{{ __('user.city') }}" />
                    <x-jet-input id="city" type="text" class="mt-1 block w-full" wire:model.defer="state.city" />
                    <x-jet-input-error for="city" class="mt-2" />
                </div>
            </div>
        </div>


    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('pages.profile.saved') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('pages.profile.button.save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
