<?php

namespace NukaCode\Core\View;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('viewcore', function ($app) {
            return $app->make('NukaCode\Core\View\ViewBuilder');
        });
    }
}
