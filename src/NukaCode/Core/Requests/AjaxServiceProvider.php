<?php namespace NukaCode\Core\Requests;

use Illuminate\Support\ServiceProvider;

class AjaxServiceProvider extends ServiceProvider {

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('ajax', function($app)
        {
            return $app->make('NukaCode\Core\Requests\Ajax');
        });
    }

}