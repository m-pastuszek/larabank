<div>
    <div class="max-w-full px-10 my-4 py-6 bg-white rounded-lg shadow-md">
        <div class="flex justify-start items-center">
            <a class="px-2 py-1 bg-gray-600 text-gray-100 font-bold rounded hover:bg-gray-500" href="#">{{ $bankProduct->type->name }}</a>
            <a class="text-2xl text-gray-700 font-bold hover:text-gray-600 mx-5" href="#">{{ $bankProduct->name }}</a>
        </div>
        <div class="mt-2">
            <p class="mt-2 text-gray-600">{{ $bankProduct->description }}</p>
        </div>
        <div class="flex justify-end items-center mt-4">
            <div>
                <x-jet-danger-button wire:click="addingClientBankProductModal">
                    {{ __('Złóż wniosek') }}
                </x-jet-danger-button>
            </div>
        </div>
    </div>
    <x-jet-dialog-modal wire:model="addClientBankProductConfirmation">
        <x-slot name="title">
            {{ __('Składanie wniosku') }}
        </x-slot>

        <x-slot name="content">

            <div class="mt-4">
                <p>Czy na pewno chcesz złożyć wniosek o dodanie nowego produktu?</p>
                <br/>
                W laraBanku wszystko robimy od ręki ;)
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('addClientBankProductConfirmation')">
                {{ __('Rezygnuję') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="addClientBankAccount({{ $bankProduct->id }})">
                {{ __('Tak, chcę!') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>
