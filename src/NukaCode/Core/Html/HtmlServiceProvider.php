<?php namespace NukaCode\Core\Html;

use Illuminate\Html\HtmlServiceProvider as BaseHtmlServiceProvider;

class HtmlServiceProvider extends BaseHtmlServiceProvider {

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerHtmlBuilder()
    {
        $this->app->bindShared('html', function($app)
        {
            return $app->make('NukaCode\Core\Html\HtmlBuilder');
        });
    }

}