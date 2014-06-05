<?php namespace NukaCode\Core\Eventing;

use Illuminate\Support\ServiceProvider;

class EventingServiceProvider extends ServiceProvider {

    public function register()
    {
        $listeners = $this->app['config']->get('app.listeners');

        foreach ($listeners as $namespace => $listener) {
            $this->app['events']->listen($namespace .'*', $listener);
        }
    }
} 