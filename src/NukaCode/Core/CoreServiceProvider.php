<?php namespace NukaCode\Core;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    const version = '1.0.0';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('nukacode/core');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->shareWithApp();
        $this->loadConfig();
        $this->registerViews();
        $this->registerAliases();
    }

    /**
     * Share the package with application
     *
     * @return void
     */
    protected function shareWithApp()
    {
        $this->app['core'] = $this->app->share(function($app)
        {
            return true;
        });
    }

    /**
     * Load the config for the package
     *
     * @return void
     */
    protected function loadConfig()
    {
        $this->app['config']->package('nukacode/core', __DIR__.'/../../config');
    }

    /**
     * Register views
     *
     * @return void
     */
    protected function registerViews()
    {
        $this->app['view']->addLocation(__DIR__.'/../../views');
    }

    /**
     * Register aliases
     *
     * @return void
     */
    protected function registerAliases()
    {
        $aliases = [
            'HTML'               => 'NukaCode\Core\Facades\Html\HTML',
            'CoreView'           => 'NukaCode\Core\Facades\View\View',
            'Utility_Collection' => 'NukaCode\Core\Database\Collection',
        ];

        $appAliases = \Config::get('core::nonCoreAliases');
        $loader     = \Illuminate\Foundation\AliasLoader::getInstance();

        foreach ($aliases as $alias => $class) {
            if (!is_null($appAliases)) {
                if (!in_array($alias, $appAliases)) {
                    $loader->alias($alias, $class);
                }
            } else {
                $loader->alias($alias, $class);
            }
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}