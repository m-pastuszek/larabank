<div>
    <button type="button" class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 border rounded-full"
            wire:click="showCreateOperationModal">
        Wykonaj przelew
    </button>

    <x-jet-dialog-modal wire:model="modalVisible">
        <x-slot name="title">
            @if (is_null($selected_operation_type)) Wybierz typ przelewu @else Wykonywanie nowego przelewu @endif
        </x-slot>
        <x-slot name="content">
            <div class="bg-white shadow overflow-y-scroll max-h-96 sm:rounded-lg">
                <div class="border-t border-gray-200">
                    <div class="p-4">
                        <x-jet-validation-errors class="mb-4" />
                        <!-- Typ przelewu -->
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <x-jet-label for="operation_type" value="{{ __('Typ przelewu') }}" />
                                <div class="relative">
                                    <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded"
                                            wire:model="operation_type">
                                        <option value="null" disabled>-- {{ __('Wybierz typ operacji') }} --</option>
                                        @foreach($operationTypes as $operationType)
                                            <option value="{{ $operationType->id }}" {{ collect(old('operation_type'))->contains($operationType->id) ? 'selected':'' }}>{{ $operationType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if(!is_null($selected_operation_type)) <!-- Jeśli nie wybrano typu, nie pokazuj pól -->
                            @if ($selected_operation_type == 1) <!-- Jeśli przelew zewnętrzny -->
                                <!-- Nazwa odbiorcy -->
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-full px-3 mb-6 md:mb-0">
                                        <x-jet-label for="recipient_name" value="{{ __('Nazwa odbiorcy') }}" />
                                        <x-jet-input id="recipient_name" class="block mt-1 w-full" type="text" name="recipient_name"
                                                     placeholder="Wpisz nazwę odbiorcy" :value="old('recipient_name')" required autofocus autocomplete="recipient_name"
                                                     wire:model="transaction_recipient_name"/>
                                    </div>
                                </div>
                                <!-- Adres odbiorcy -->
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-full px-3 mb-6 md:mb-0">
                                        <x-jet-label for="recipient_address" value="{{ __('Adres odbiorcy') }}" />
                                        <x-jet-input id="recipient_address" class="block mt-1 w-full" type="text" name="recipient_address"
                                                     placeholder="Wpisz adres odbiorcy" :value="old('recipient_address')" required autofocus autocomplete="recipient_address"
                                                     wire:model="transaction_recipient_address" />
                                    </div>
                                </div>
                                <!-- IBAN odbiorcy -->
                                <div class="-mx-3 md:flex mb-6">
                                    <div class="md:w-full px-3 mb-6 md:mb-0">
                                        <x-jet-label for="recipient_iban" value="{{ __('IBAN ( Kod kraju + Nr rachunku )') }}" />
                                        <x-jet-input id="recipient_iban" class="block mt-1 w-full" type="text" name="recipient_iban"
                                                     placeholder="Wpisz numer rachunku odbiorcy" :value="old('recipient_iban')" required autofocus autocomplete="recipient_iban"
                                                     wire:model="transaction_recipient_iban" wire:change="CheckBankByIban"/>
                                        @if($bankName)
                                            <p class="text-sm mt-2 text-blue-600">Bank: {{ $bankName }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <!-- Z rachunku -->
                            <div class="-mx-3 md:flex mb-6">
                                <div class="md:w-full px-3 mb-6 md:mb-0">
                                    <x-jet-label for="operation_from_bank_account_id" value="{{ __('Z rachunku') }}" />
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded"
                                                wire:model="operation_from_bank_account_id">
                                            <option value="">-- {{ __('Wybierz rachunek') }} --</option>
                                            @foreach($clientBankProducts as $clientBankProduct)
                                                <option value="{{ $clientBankProduct->id }}" {{ collect(old('operation_from_bank_account_id'))->contains($clientBankProduct->id) ? 'selected':'' }}>
                                                    {{ $clientBankProduct->bankProduct->name }} ({{ $clientBankProduct->BalanceFrenchNotation }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if ($selected_operation_type == 2) <!-- Jeśli przelew własny -->
                            <!-- Na rachunek -->
                            <div class="-mx-3 md:flex mb-6">
                                <div class="md:w-full px-3 mb-6 md:mb-0">
                                    <x-jet-label for="operation_to_bank_account_id" value="{{ __('Na rachunek') }}" />
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded"
                                                wire:model="operation_to_bank_account_id">
                                            <option value="">-- {{ __('Wybierz rachunek') }} --</option>
                                            @foreach($clientBankProducts as $clientBankProduct)
                                                <option value="{{ $clientBankProduct->id }}" {{ collect(old('operation_to_bank_account_id'))->contains($clientBankProduct->id) ? 'selected':'' }}>{{ $clientBankProduct->bankProduct->name }} ({{ $clientBankProduct->BalanceFrenchNotation }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- Tytuł przelewu -->
                            <div class="-mx-3 md:flex mb-6">
                                <div class="md:w-full px-3 mb-6 md:mb-0">
                                    <x-jet-label for="title" value="{{ __('Tytuł przelewu') }}" />
                                    <x-jet-input id="title" class="block mt-1 w-full" type="text" name="title"
                                                 placeholder="Wpisz tytuł przelewu" :value="old('title')" required autofocus autocomplete="title"
                                                 wire:model="transaction_title" />
                                </div>
                            </div>
                            <!-- Data wykonania przelewu -->
                            <div class="-mx-3 md:flex mb-6">
                                <div class="md:w-full px-3 mb-6 md:mb-0">
                                    <x-jet-label for="operation_scheduled_at" value="{{ __('Data wykonania przelewu') }}" />
                                    <x-jet-input id="operation_scheduled_at" class="block mt-1 w-full" type="date" name="operation_scheduled_at"
                                                 placeholder="Wybierz datę wykonania przelewu" :value="old('operation_scheduled_at')" required autofocus autocomplete="operation_scheduled_at"
                                                 wire:model="operation_scheduled_at"/>
                                </div>
                            </div>
                            <!-- Kwota przelewu -->
                            <div class="-mx-3 md:flex mb-6">
                                <div class="md:w-full px-3 mb-6 md:mb-0">
                                    <x-jet-label for="transaction_amount" value="{{ __('Kwota przelewu') }}" />
                                    <x-jet-input id="transaction_amount" class="block mt-1 w-full" type="number" min="0" step="0.01" name="transaction_amount"
                                                 placeholder="Wpisz kwotę przelewu" :value="old('transaction_amount')" required autofocus autocomplete="transaction_amount"
                                                 wire:model="transaction_amount" />
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalVisible')" wire:loading.attr="disabled">
                {{ __('Anuluj operację') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="submitOperation" wire:loading.attr="disabled">
                {{ __('Zatwierdź') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
