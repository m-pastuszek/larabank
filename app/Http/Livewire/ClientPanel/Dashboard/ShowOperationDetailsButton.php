<?php

namespace App\Http\Livewire\ClientPanel\Dashboard;

use App\Models\Operation;
use Livewire\Component;

class ShowOperationDetailsButton extends Component
{
    // Szczegóły operacji
    public $operation;
    public $modalVisible = false;

    public function showOperationDetails($operation_id)
    {
        $this->modalVisible = true;
        $operation = Operation::where('id', $operation_id)->first();
    }

    public function operationDetails($operation_id)
    {
        $operation = Operation::where('id', $operation_id)->first();

        return $operation;
    }

    public function render()
    {

        return view('livewire.client-panel.dashboard.show-operation-details-button');
    }
}
