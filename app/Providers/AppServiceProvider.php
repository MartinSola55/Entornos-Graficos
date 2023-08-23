<?php

namespace App\Providers;

use App\Models\Person;
use App\Observers\PersonObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Person::observe(PersonObserver::class);

        if($this->app->environment('production'))
        {
            URL::forceScheme('https');
        }
    }
}
