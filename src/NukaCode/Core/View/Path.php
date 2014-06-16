<?php namespace NukaCode\Core\View;

use Illuminate\Routing\Router;
use Illuminate\View\Factory;
use ReflectionClass;

class Path {

    public $path;

    protected $route;

    protected $view;

    public function __construct(Router $route, Factory $view)
    {
        $this->route = $route;
        $this->view  = $view;
    }

    public function setUp($layout, $view = null)
    {
        $this->setPath($view);

        $layout = $this->setContent($layout);

        return $layout;
    }

    protected function setPath($view)
    {
        if ($view == null) {
            $view =  $this->findView();
        }

        $this->path = $view;
    }

    protected function setContent($layout)
    {
        if (stripos($this->path, 'missingmethod') === false) {
            try {
                $layout->content = $this->view->make($this->path);
            } catch (\Exception $e) {
                $layout->content = null;
            }
        }

        return $layout;
    }

    public function missingMethod($layout, $parameters)
    {
        $view = $this->findView();

        if (count($parameters) == 1) {
            $view = str_ireplace('missingMethod', $parameters[0], $view);
        } elseif ($parameters[0] == null && $parameters[1] == null) {
            $view = str_ireplace('missingMethod', 'index', $view);
        } else {
            $view = implode('.', $parameters);
        }

        return $this->setUp($layout, $view);
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

    protected function getMethodName($class)
    {
        $class = (new ReflectionClass($class))->getShortName();
        $method = strtolower(str_replace('Controller', '', $class));

        return $method;
    }

    protected function getActionName($action)
    {
        $action = preg_replace(['/^get/', '/^post/', '/^put/', '/^patch/', '/^delete/'], '',  $action);
        $action = strtolower($action);

        return $action;
    }
}