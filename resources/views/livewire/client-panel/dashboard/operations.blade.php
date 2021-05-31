<div>
    <div class="my-2 flex sm:flex-row flex-col">
        <div class="flex flex-row mb-1 sm:mb-0">
            <div class="relative">
                <select wire:model="perPage"
                        class="appearance-none h-full rounded-l rounded-r border block appearance-none w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option>10</option>
                    <option>20</option>
                    <option>30</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Data operacji
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Rachunek
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Nadawca / Odbiorca
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Tytuł przelewu
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Typ przelewu
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Kwota przelewu
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Akcje
                    </th>
                </tr>
                </thead>
                <tbody>
                @if ($clientOperations->total() > 0)
                    @foreach($clientOperations as $operationItem)
                        @php
                            $operation = \App\Models\Operation::where('id', $operationItem['id'])->first();
                            if (is_null($operation->from_bank_account_id)) {
                                $clientBankProduct = \App\Models\ClientBankProduct::where('id', $operation->to_bank_account_id)->first();
                            } elseif (is_null($operation->to_bank_account_id)) {
                                $clientBankProduct = \App\Models\ClientBankProduct::where('id', $operation->from_bank_account_id)->first();
                            } else
                                $clientBankProduct = \App\Models\ClientBankProduct::where('id', $operation->from_bank_account_id)->first();

                            $transaction = \App\Models\Transaction::where('id', $operation->transaction_id)->first();
                        @endphp

                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                    {{ \Carbon\Carbon::parse($operation->created_at)->format('d.m.Y') }}
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight text-center">
                                    <span aria-hidden class="absolute inset-0 bg-blue-200 opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $clientBankProduct->bankProduct->name }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    @if ($operation->toClientBankAccount->user->id == Auth::user()->id)
                                        {{ $transaction->sender_name }}
                                    @else
                                        {{ $transaction->recipient_name }}
                                    @endif
                                </p>
                                <h3></h3>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ mb_strtoupper($transaction->title, "UTF-8") }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight text-center">
                                    <span aria-hidden
                                          class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $operation->type->name }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @if ($operation->toClientBankAccount->user->id == Auth::user()->id)
                                    <span class="@if($operation->type->id == 2) text-500 @else text-green-500 @endif font-semibold">{{ $operation->transaction->FormattedAmount }}</span>
                                @else
                                    <span class="text-red-500 font-semibold">{{ '- ' . $operation->transaction->FormattedAmount }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @livewire('client-panel.dashboard.show-operation-details-button', ['operation' => $operation])
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm" colspan="7">
                            <div class="items-center">
                                <div class="text-center px-6 py-4">
                                    <div class="py-8">
                                        <div class="mb-4">
                                            <svg class="inline-block fill-current text-grey h-16 w-16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M11.933 13.069s7.059-5.094 6.276-10.924a.465.465 0 0 0-.112-.268.436.436 0 0 0-.263-.115C12.137.961 7.16 8.184 7.16 8.184c-4.318-.517-4.004.344-5.974 5.076-.377.902.234 1.213.904.959l2.148-.811 2.59 2.648-.793 2.199c-.248.686.055 1.311.938.926 4.624-2.016 5.466-1.694 4.96-6.112zm1.009-5.916a1.594 1.594 0 0 1 0-2.217 1.509 1.509 0 0 1 2.166 0 1.594 1.594 0 0 1 0 2.217 1.509 1.509 0 0 1-2.166 0z"/></svg>
                                        </div>
                                        <p class="text-2xl text-grey-darker font-medium mb-4">{{ __('Brak danych') }}</p>
                                        <p class="text-grey max-w-xs mx-auto mb-6">{{ __('Nie znaleźliśmy żadnych operacji.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            @if ($clientOperations->hasPages())
                <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row xs:justify-between">
                    {!! $allClientOperations->links() !!}
                </div>
            @endif
        </div>
    </div>
</div>
