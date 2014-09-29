<?php namespace NukaCode\Core\Html;

use Illuminate\Html\FormBuilder as BaseForm;
use Illuminate\Support\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

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

		$this->registerBBCode();
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
	protected function registerFormBuilder()
	{
		$this->app->bindShared('form', function($app)
		{
			$form = new BaseForm($app['html'], $app['url'], $app['session.store']->getToken());

			return $form->setSessionStore($app['session.store']);
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

	/**
	 * Register the BBCode instance.
	 *
	 * @return void
	 */
	protected function registerBBCode()
	{
		$this->app->bindShared('bbcode', function($app)
		{
			return $app->make('NukaCode\Core\Html\BBCode');
		});
	}

}