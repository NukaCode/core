<?php

namespace NukaCode\Core\Providers;

abstract class Routes
{
    public $contexts = [
        'admin'   => '/admin',
        'default' => '/',
    ];

    /**
     * Add a context to the array.
     *
     * @param string $name
     * @param string $uri
     *
     * @return \NukaCode\Core\Providers\Routes
     */
    public function setContext($name, $uri)
    {
        $this->contexts[$name] = $uri;

        return $this;
    }

    /**
     * Get a context URI from the array.
     *
     * @param string $name
     *
     * @return string
     */
    public function getContext($name)
    {
        return $this->contexts[$name];
    }
}
