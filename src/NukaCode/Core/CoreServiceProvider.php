<?php

namespace NukaCode\Core;

class CoreServiceProvider extends BaseServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $namespace = 'nukacode/core';

    const NAME = 'core';

    const VERSION = '2.1.1';

    const DOCS = 'nukacode-core';

    public function boot()
    {
        $this->loadConfigsFrom(__DIR__ . '/../../config', $this->namespace);
        $this->loadAliasesFrom(config_path($this->namespace), $this->namespace);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->shareWithApp();
        $this->publishDatabaseFiles();
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
    protected function publishDatabaseFiles()
    {
        $databaseFiles = $this->getDatabaseFiles('vendor/nukacode/core/src/database');

        $this->publishes($databaseFiles, 'database');
    }

    public function registerArtisanCommands()
    {
        $this->commands(
            [
                'NukaCode\Core\Console\AppNameCommand' => 'command.app.name',
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
