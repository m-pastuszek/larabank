<?php

namespace App\View\Components\Register;

use App\Models\Voivodeship;
use Illuminate\View\Component;

class SelectVoivodeship extends Component
{
    public $voivodeships;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $this->voivodeships = Voivodeship::all();
        return view('components.register.select-voivodeship');
    }
}
