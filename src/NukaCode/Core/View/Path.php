<?php namespace NukaCode\Core\View;

use Illuminate\Routing\Router;
use Illuminate\View\Factory;
use Illuminate\View\View;
use ReflectionClass;

class Path {

	public    $path;

	public    $layout;

	protected $route;

	protected $view;

	public function __construct(Router $route, Factory $view)
	{
		$this->route = $route;
		$this->view  = $view;
	}

	public function setUp(View $layout, $view = null)
	{
		$this->layout = $layout;
		$this->setPath($view);
		$this->setContent();

		return $this->layout;
	}

	protected function setPath($view)
	{
		if ($view == null) {
			$view = $this->findView();
		}

		$this->path = $view;
	}

	protected function setContent()
	{
		if (stripos($this->path, 'missingmethod') === false && $this->view->exists($this->path)) {
			try {
				$this->layout->content = $this->view->make($this->path);
			} catch (\Exception $e) {
				$this->layout->content = null;
			}
		}
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

	/**
	 * @return string
	 */
	protected function findView()
	{
		// Get the overall route name (SomeController@someMethod)
		// Break it up into it's component parts
		$route      = $this->route->currentRouteAction();
		$routeParts = explode('@', $route);

		$method = $this->getMethodName($routeParts[0]);
		$action = $this->getActionName($routeParts[1]);
		$prefix = $this->getPrefixName($method);

		$view = $method . '.' . $action;

		if (! is_null($prefix) && $prefix != '') {
			if ($this->view->exists($prefix . '.' . $view)) {
				$view = $prefix . '.' . $view;
			}
		}

		return $view;
	}

	/**
	 * @param string $class
	 *
	 * @return string
	 */
	protected function getMethodName($class)
	{
		$class  = (new ReflectionClass($class))->getShortName();
		$method = strtolower(str_replace('Controller', '', $class));

		return $method;
	}

	/**
	 * @param string $action
	 *
	 * @return string
	 */
	protected function getActionName($action)
	{
		$action = preg_replace(['/^get/', '/^post/', '/^put/', '/^patch/', '/^delete/'], '', $action);
		$action = strtolower($action);

		return $action;
	}

	/**
	 * @param string $method
	 *
	 * @return string
	 */
	protected function getPrefixName($method)
	{
		$prefix = $this->route->getCurrentRoute()->getPrefix();
		$prefix = str_replace('/', '.', $prefix);
		$prefix = preg_replace('/\b\.'. $method .'\b/', '', $prefix);
		$prefix = preg_replace('/\b'. $method .'\.\b/', '', $prefix);

		return $prefix;
	}
}