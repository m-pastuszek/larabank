<?php

namespace App\Http\Livewire\ClientPanel\Dashboard;

use App\Models\BankProduct;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.client-panel.dashboard.index');
    }
}
