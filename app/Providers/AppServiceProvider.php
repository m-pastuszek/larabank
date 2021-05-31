<?php

namespace App\Providers;

use App\Actions\Voyager\GoToTransaction;
use App\View\Components\ClientPanel\Index;
use App\View\Components\ClientPanel\Info\InactiveAccount;
use App\View\Components\ClientPanel\Info\NoBankAccount;
use App\View\Components\Register\SelectVoivodeship;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Date\Date;
use TCG\Voyager\Facades\Voyager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // Blade components
        Blade::component('voivodeship-select', SelectVoivodeship::class);
        Blade::component('inactive-account-info', InactiveAccount::class);
        Blade::component('no-bank-account-info', NoBankAccount::class);

        Date::setLocale(config('app.locale'));
    }
}
