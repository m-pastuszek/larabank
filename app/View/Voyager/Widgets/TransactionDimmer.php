<?php

namespace App\View\Voyager\Widgets;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;

class TransactionDimmer extends BaseDimmer
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
        $transactionsSum = Transaction::sum('amount');
        $formattedSum = str_replace('.', ',', sprintf('%0.2f', $transactionsSum)) . " zł";

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-dollar',
            'title'  => "Suma przelewów: {$formattedSum}",
            'text'   => __('Suma pieniędzy, jaka przepłynęła przez bank.'),
            'button' => [
                'text' => __('Przejdź do przelewów'),
                'link' => route('voyager.transactions.index'),
            ],
            'image' => ('storage/images/widget-backgrounds/money.jpg'),
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
