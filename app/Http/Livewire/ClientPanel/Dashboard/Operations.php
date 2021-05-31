<?php

namespace App\Http\Livewire\ClientPanel\Dashboard;

use App\Models\ClientBankProduct;
use App\Models\Operation;
use App\Models\OperationType;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Operations extends Component
{
    use WithPagination;

    public $perPage = 10;
    private $clientBankProducts;

    public function render()
    {
        $clientBankProducts = ClientBankProduct::where('user_id', Auth::user()->id)->get();
        $operationTypes = OperationType::all();

        // Tworzenie tablicy z id wszystkich produktów bankowych, jakie posiada klient.
        $allClientBankProducts = array();
        foreach ($clientBankProducts as $clientBankProduct)
        {
            $allClientBankProducts[] = $clientBankProduct->id;
        }

        $clientOperations = Operation::whereIn('from_bank_account_id', $allClientBankProducts)
            ->orWhereIn('to_bank_account_id', $allClientBankProducts)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.client-panel.dashboard.operations', compact('clientOperations', 'operationTypes'));

    }
}
