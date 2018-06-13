<?php

namespace App\Providers;

use Carbon\Carbon;
use Laravel\Horizon\Horizon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale', config('app.fallback_locale', 'en')));

        Horizon::auth(function ($request) {
            return Auth::check();
        });

        foreach (config('observers') as $model => $observer) {
            /* @var \Illuminate\Database\Eloquent\Model $model */
            $model::observe($observer);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
