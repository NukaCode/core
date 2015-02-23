<?php namespace NukaCode\Core;

class CoreServiceProvider extends BaseServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    const NAME = 'core';

    const VERSION = '2.0.3';

    const DOCS = 'nukacode-core';

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->shareWithApp();
        $this->setPublishGroups();
        $this->registerAliases();
        $this->registerArtisanCommands();
    }

    /**
     * Share the package with application
     *
     * @return void
     */
    protected function shareWithApp()
    {
        $this->app['core'] = $this->app->share(function () {
            return true;
        });
    }

    /**
     * Set up the config values
     *
     * @return void
     */
    protected function setPublishGroups()
    {
        $this->publishes(
            [
                __DIR__ . '/../../config/config.php' => config_path('nukacode-core.php')
            ], 'config'
        );

        $databaseFiles = $this->getDatabaseFiles('vendor/nukacode/core/src/database');

        $this->publishes($databaseFiles, 'database');
    }

    /**
     * Register aliases
     *
     * @return void
     */
    protected function registerAliases()
    {
        $aliases = [
            // Facades
            'ViewBuilder' => 'NukaCode\Core\Support\Facades\View\ViewBuilder',
            'Ajax'        => 'NukaCode\Core\Support\Facades\Requests\Ajax',
        ];

        $exclude = $this->app['config']->get('nukacode-core.excludeAliases');

        $this->loadAliases($aliases, $exclude);
    }

    public function registerArtisanCommands()
    {
        $this->commands(
            [
                'NukaCode\Core\Console\AppNameCommand' => 'command.app.name',
                'NukaCode\Core\Console\VersionCommand',
                'NukaCode\Core\Console\BowerCommand',
            ]
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['core'];
    }
}