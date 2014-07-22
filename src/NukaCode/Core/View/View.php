<?php namespace NukaCode\Core\View;

use Illuminate\View\Factory;

class View {

    public    $layout;

    protected $viewLayout;

    protected $viewPath;

    protected $viewMenu;

    protected $view;

    public function __construct(Layout $viewLayout, Path $viewPath, Menu $viewMenu, Factory $view)
    {
        $this->viewLayout = $viewLayout;
        $this->viewPath   = $viewPath;
        $this->viewMenu   = $viewMenu;
        $this->view       = $view;
    }

    public function setUp($menu)
    {
        $this->layout = $this->viewLayout->setUp();
        $this->viewPath->setUp($this->layout->layout);
        $this->viewMenu->setUp($menu);
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