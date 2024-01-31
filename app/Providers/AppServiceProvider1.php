<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Extensions\ExtendedView;
use Illuminate\View\Factory;


class AppServiceProvider1 extends ServiceProvider
{
    /**
     * Register any application services.
     \*
     * @return void
     */
    public function register()
    {
        $this->app->bind('view', function ($app) {
            return new ExtendedView($app['view.engine.resolver'], $app['view.finder'], $app['events']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
