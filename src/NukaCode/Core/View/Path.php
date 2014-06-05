<?php namespace NukaCode\Core\View;

use Illuminate\Routing\Router;
use Illuminate\View\Factory;
use ReflectionClass;

class Path {

    protected $route;

    protected $view;

    public function __construct(Router $route, Factory $view)
    {
        $this->route = $route;
        $this->view  = $view;
    }

    public function setUp($layout, $view = null)
    {
        if ($view == null) {
            $view = $this->findView();
        }

        if (!$this->view->exists($view)) {
            throw new \InvalidArgumentException("View [$view] not found.");
        }

        $layout->content = $this->view->make($view);

        return $this;
    }

    protected function findView()
    {
        // Get the overall route name (SomeController@someMethod)
        // Break it up into it's component parts
        $route         = $this->route->currentRouteAction();
        $routeParts    = explode('@', $route);

        $method        = $this->getMethodName($routeParts[0]);
        $action        = $this->getActionName($routeParts[1]);

        $view          = $method .'.'. $action;

        return $view;
    }

    protected function getMethodName($method)
    {
        $method = (new ReflectionClass($method))->getShortName();
        $method = strtolower(str_replace('Controller', '', $method));

        return $method;
    }

    protected function getActionName($action)
    {
        $action = preg_replace(['/^get/', '/^post/'], '',  $action);
        $action = strtolower($action);

        return $action;
    }
}