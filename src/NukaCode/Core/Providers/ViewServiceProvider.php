<?php

namespace NukaCode\Core\Providers;

use Illuminate\Support\ServiceProvider;
use NukaCode\Core\View\ViewBuilder;

class ViewServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('viewBuilder', function ($app) {
            return $app->make(ViewBuilder::class);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../config/view-routing.php' => config_path('view-routing.php'),
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['viewBuilder'];
    }
}
