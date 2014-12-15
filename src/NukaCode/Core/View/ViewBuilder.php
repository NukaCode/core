<?php namespace NukaCode\Core\View;

use Illuminate\View\Factory;

class ViewBuilder {

	public    $layout;

	public    $view;

	protected $viewLayout;

	protected $viewPath;

	protected $viewMenu;

	public function __construct(Layout $viewLayout, Path $viewPath, Factory $view)
	{
		$this->viewLayout = $viewLayout;
		$this->viewPath   = $viewPath;
		//$this->viewMenu   = $viewMenu;
		$this->view = $view;
	}

	public function setUp($menu)
	{
		$this->layout         = $this->viewLayout->setUp();
		$this->layout->layout = $this->viewPath->setUp($this->layout->layout);
		//$this->viewMenu->setUp($menu);
	}

	public function exists($view)
	{
		return $this->view->exists($view);
	}

	public function setMenu($menu)
	{
		$this->viewMenu->setUp($menu);
	}

	public function getLayout()
	{
		return $this->layout->layout;
	}

	public function missingMethod($parameters)
	{
		$this->viewPath->missingMethod($this->layout->layout, $parameters);

		return $this;
	}

	public function setViewLayout($view)
	{
		$this->layout         = $this->viewLayout->setUp($view);
		$this->layout->layout = $this->viewPath->setUp($this->layout->layout);
	}

	public function setViewPath($view)
	{
		$this->layout->layout = $this->viewPath->setUp($this->layout->layout, $view);

		return $this;
	}

	public function addData($key, $value)
	{
		$this->view->share($key, $value);

		return $this;
	}

	public function getPath()
	{
		return $this->viewPath->path;
	}
}