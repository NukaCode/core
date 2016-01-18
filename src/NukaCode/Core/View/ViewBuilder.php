<?php

namespace NukaCode\Core\View;

use Illuminate\View\Factory;

class ViewBuilder
{

    public $layout;

    public $view;

    protected $viewLayout;

    protected $viewPath;

    public function __construct(Layout $viewLayout, Path $viewPath, Factory $view)
    {
        $this->viewLayout = $viewLayout;
        $this->viewPath   = $viewPath;
        $this->view       = $view;
    }

    public function setUp($layoutOptions, $domainDesign)
    {
        $this->layout         = $this->viewLayout->setUp($layoutOptions);
        $this->layout->layout = $this->viewPath->setUp($this->layout->layout, null, $domainDesign);
    }

    public function exists($view)
    {
        return $this->view->exists($view);
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

    public function setViewLayout($view, $domainDesign)
    {
        $this->layout         = $this->viewLayout->change($view);
        $this->layout->layout = $this->viewPath->setUp($this->layout->layout, null, $domainDesign);
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
