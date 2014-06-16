<?php namespace NukaCode\Core\Html;

use Illuminate\Html\HtmlServiceProvider as BaseHtmlServiceProvider;

class HtmlServiceProvider extends BaseHtmlServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHtmlBuilder();

        $this->registerFormBuilder();

        $this->registerBFormBuilder();
    }

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

    /**
     * Register the form builder instance.
     *
     * @return void
     */
    protected function registerBFormBuilder()
    {
        $this->app->bindShared('bform', function($app)
        {
            return $app->make('NukaCode\Core\Html\FormBuilder');
        });
    }

}