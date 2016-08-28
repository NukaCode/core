<?php

namespace NukaCode\Core\Contracts;

use Illuminate\Routing\Router;

interface Routes
{
    public function setContext($name, $uri);

    public function getContext($name);

    public function namespacing();

    public function prefix();

    public function middleware();

    public function patterns();

    public function routes(Router $router);
}
