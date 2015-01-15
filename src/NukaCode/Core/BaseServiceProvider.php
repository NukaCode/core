<?php namespace NukaCode\Core;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

abstract class BaseServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    protected function loadAliases($aliases, $exclude)
    {
        $loader     = AliasLoader::getInstance();

        foreach ($aliases as $alias => $class) {
            if (! is_null($aliases)) {
                if (! in_array($alias, $exclude)) {
                    $loader->alias($alias, $class);
                }
            } else {
                $loader->alias($alias, $class);
            }
        }
    }

    protected function getConfig()
    {
        return (include_once(__DIR__.'/../../config/config.php'));
    }

}