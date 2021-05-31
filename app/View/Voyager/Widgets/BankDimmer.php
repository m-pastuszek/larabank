<?php

namespace App\View\Voyager\Widgets;

use App\Models\ClientBankProduct;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;

class BankDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $balanceSum = ClientBankProduct::sum('balance');
        $formattedSum = str_replace('.', ',', sprintf('%0.2f', $balanceSum)) . " zł";

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-news',
            'title'  => "$formattedSum",
            'text'   => __('Tyle pieniędzy trzymają Klienci na swoich rachunkach.'),
            'button' => [
                'text' => __('Przejdź do rachunków'),
                'link' => route('voyager.client-bank-products.index'),
            ],
            'image' => ('storage/images/widget-backgrounds/transaction.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', Voyager::model('User'));
    }
}
