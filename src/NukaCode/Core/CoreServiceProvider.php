<?php namespace NukaCode\Core;

use Artisan;
use Illuminate\Support\Facades\App;
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
        $this->registerArtisan();
    }

    /**
     * Share the package with application
     *
     * @return void
     */
    protected function shareWithApp()
    {
        $this->app['core'] = $this->app->share(function ($app) {
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
        $this->app['config']->package('nukacode/core', __DIR__ . '/../../config');
    }

    /**
     * Register views
     *
     * @return void
     */
    protected function registerViews()
    {
        $this->app['view']->addLocation(__DIR__ . '/../../views');
    }

    /**
     * Register aliases
     *
     * @return void
     */
    protected function registerAliases()
    {
        $aliases = [
            'HTML'                        => 'NukaCode\Core\Facades\Html\HTML',
            'bForm'                       => 'NukaCode\Core\Facades\Html\bForm',
            'CoreView'                    => 'NukaCode\Core\Facades\View\View',
            'Ajax'                        => 'NukaCode\Core\Facades\Requests\Ajax',
            // Utilities
            'Utility_Collection'          => 'NukaCode\Core\Database\Collection',
            // Models
            'User_Preference'             => 'NukaCode\Core\Models\User\Preference',
            'User_Preference_User'        => 'NukaCode\Core\Models\User\Preference\User',
            'User_Permission_Action'      => 'NukaCode\Core\Models\User\Permission\Action',
            'User_Permission_Action_Role' => 'NukaCode\Core\Models\User\Permission\Action\Role',
            'User_Permission_Role'        => 'NukaCode\Core\Models\User\Permission\Role',
            'User_Permission_Role_User'   => 'NukaCode\Core\Models\User\Permission\Role\User',
            'Seed'                        => 'NukaCode\Core\Models\Seed',
            'Migration'                   => 'NukaCode\Core\Models\Migration',
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

    public function registerArtisan()
    {
        $this->app->bind('nukacode::command.version.core', function ($app) {
            return $app->make('NukaCode\Core\Commands\VersionCommand');
        });
        $this->app->bind('nukacode::command.theme', function ($app) {
            return $app->make('NukaCode\Core\Commands\ThemeCommand');
        });
        $this->app->bind('nukacode::command.database', function ($app) {
            return $app->make('NukaCode\Core\Commands\DatabaseCommand');
        });

        $this->commands([
            'nukacode::command.version.core',
            'nukacode::command.theme',
            'nukacode::command.database',
        ]);
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