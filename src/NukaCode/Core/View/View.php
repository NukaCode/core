<?php namespace NukaCode\Core\View;

use NukaCode\Core\View\Layout;
use NukaCode\Core\View\Path;
use NukaCode\Core\View\Menu;

class View {

    public $layout;

    protected $viewLayout;

    protected $viewPath;

    protected $viewMenu;

    public function __construct(Layout $viewLayout, Path $viewPath, Menu $viewMenu)
    {
        $this->viewLayout = $viewLayout;
        $this->viewPath = $viewPath;
        $this->viewMenu = $viewMenu;
    }

    public function setUp()
    {
        $this->layout = $this->viewLayout->setUp();
        $this->viewPath->setUp($this->layout->layout);
        $this->viewMenu->setUp();
    }

    public function getLayout()
    {
        return $this->layout->layout;
    }

    public function setViewPath($view)
    {
        $this->viewPath->setUp($this->layout->layout, $view);
    }
}