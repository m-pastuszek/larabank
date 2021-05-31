<div class="bg-gray-50 bg-opacity-25 grid grid-cols-1">
    <div class="p-6">
        @livewire('client-panel.dashboard.create-operation')
        <div class="container mx-auto px-6 py-8">
            <div class="min-w-screen flex items-center justify-center px-5 py-5">
                <div class="w-full">
                    <div class="-mx-2 md:flex items-center justify-center">
                        @if (count(Auth::user()->clientBankProducts->toArray()) == 0)
                            <h3>Brak kont.</h3>
                        @elseif (count(Auth::user()->clientBankProducts->toArray()) >= 1)
                            @php
                                $clientBankProducts = Auth::user()->clientBankProducts;
                            @endphp
                            @foreach($clientBankProducts as $clientBankProduct)
                                @php
                                    $bankProduct = \App\Models\BankProduct::where('id', $clientBankProduct->bank_product_id)->first();
                                @endphp
                                <div class="w-full md:w-1/3 px-2">
                                    <div class="rounded-lg shadow-sm mb-4">
                                        <div class="rounded-lg bg-gray-100 hover:bg-gray-200 border-4 border-gray-200 hover:border-gray-300 shadow-lg md:shadow-xl relative overflow-hidden">
                                            <div class="px-3 pt-8 pb-10 text-center relative z-10">
                                                <h4 class="text-sm uppercase text-gray-500 leading-tight">{{ $bankProduct->type->name }} </h4>
                                                <h3 class="text-3xl text-gray-700 font-semibold leading-tight my-3">
                                                    {{ $clientBankProduct->BalanceFrenchNotation }}
                                                </h3>
                                                <p class="text-small leading-tight font-weight-light">{{ $bankProduct->name }}</p>
                                                <p class="text-small leading-tight font-weight-light">{{ $clientBankProduct->FormattedIban }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1 overflow-x-hidden overflow-y-auto">
            <div class="container mx-auto px-6 py-8">
                <h3 class="text-gray-700 text-3xl font-medium">Historia operacji</h3>
                @livewire('client-panel.dashboard.operations')
            </div>
        </div>
    </div>
</div>
