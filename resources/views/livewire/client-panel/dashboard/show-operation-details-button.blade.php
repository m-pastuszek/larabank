<div>
    <button type="button" wire:click="showOperationDetails({{ $operation->id }})"
            class="border border-gray-700 text-gray-700 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-gray-800 focus:outline-none focus:shadow-outline">
        Szczegóły
    </button>

    <x-jet-dialog-modal class="sm:max-w-5xl" wire:model="modalVisible">
        <x-slot name="title">
            Szczegóły operacji #{{ $operation->id }}
        </x-slot>

        <x-slot name="content">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Rodzaj operacji
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $operation->type->name }}
                                @if($operation->operation_type_id == 1 && $operation->to_bank_account_id)
                                    przychodzący
                                @elseif($operation->operation_type_id == 1 && $operation->from_bank_account_id)
                                    wychodzący
                                @endif
                            </dd>
                        </div>
                        @if($operation->operation_type_id == 1 && $operation->to_bank_account_id)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Nadawca
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <p class="font-bold">Imię i nazwisko: <span class="font-normal">{{ $operation->transaction->sender_name }}</span></p>
                                        </li>
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <p class="font-bold">Adres: <span class="font-normal">{{ $operation->transaction->sender_address }}</span></p>
                                        </li>
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <p class="font-bold">Nr konta (IBAN): <span class="font-normal">{{ $operation->transaction->sender_iban }}</span></p>
                                        </li>
                                    </ul>

                                </dd>
                            </div>
                        @endif
                        @if($operation->operation_type_id == 1 && $operation->from_bank_account_id)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Odbiorca
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <p class="font-bold">Imię i nazwisko: <span class="font-normal">{{ $operation->transaction->recipient_name }}</span></p>
                                    </li>
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <p class="font-bold">Adres: <span class="font-normal">{{ $operation->transaction->recipient_address }}</span></p>
                                    </li>
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <p class="font-bold">Nr konta (IBAN): <span class="font-normal">{{ $operation->transaction->recipient_iban }}</span></p>
                                    </li>
                                </ul>

                            </dd>
                        </div>
                        @endif
                        @if($operation->operation_type_id == 2)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Z rachunku
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <p class="font-semibold">{{ $operation->fromClientBankAccount->bankProduct->name }}</p>
                                    <p>{{ $operation->fromClientBankAccount->iban }}</p>
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Na rachunek
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <p class="font-semibold">{{ $operation->toClientBankAccount->bankProduct->name }}</p>
                                    <p>{{ $operation->toClientBankAccount->iban }}</p>
                                </dd>
                            </div>
                        @endif
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Kwota przelewu
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if (!is_null($operation->from_bank_account_id))
                                    <span class="text-red-500 font-semibold">{{ '- ' . $operation->transaction->FormattedAmount }}</span>
                                @else
                                    <span class="text-green-500 font-semibold">{{ $operation->transaction->FormattedAmount }}</span>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Data otrzymania
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">

                                {{ \Jenssegers\Date\Date::parse($operation->created_at)->format('d F Y') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalVisible')" wire:loading.attr="disabled">
                {{ __('Powrót') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>
