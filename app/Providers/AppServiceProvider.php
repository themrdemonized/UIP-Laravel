<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        Relation::morphMap([
            'офис' => 'App\Office',
            'квартира' => 'App\Flat',
            'кладовка' => 'App\Pantry',
        ]);

        if(env('APP_ENV') !== 'local')
        {
            $url->forceScheme('https');
        }

    }
}
