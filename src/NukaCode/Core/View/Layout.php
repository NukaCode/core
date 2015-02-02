<?php namespace NukaCode\Core\View;

use Illuminate\Config\Repository;
use Illuminate\View\Factory;
use Illuminate\Http\Request;

class Layout {

    public    $layout;

    protected $view;

    protected $request;

    protected $config;

    protected $layoutOptions;

    public function __construct(Factory $view, Request $request, Repository $config)
    {
        $this->view    = $view;
        $this->request = $request;
        $this->config  = $config;
    }

    public function setUp($layoutOptions)
    {
        $this->layoutOptions = $layoutOptions;
        $this->layout        = $this->determineLayout(null);
        $this->setPageTitle();
        $this->layout->content = null;

        return $this;
    }

    public function change($view)
    {
        $this->layout = $this->determineLayout($view);
        $this->setPageTitle();
        $this->layout->content = null;

        return $this;
    }

    public function setPageTitle()
    {
        $area     = $this->request->segment(1);
        $location = ($this->request->segment(2) != null ? ': ' . ucwords($this->request->segment(2)) : '');

        if ($area != null) {
            $pageTitle = ucwords($area) . $location;
        } else {
            $pageTitle = $this->config->get('core::siteName') . ($this->request->segment(1) != null ? ': ' . ucwords($this->request->segment(1)) : '');
        }

        $this->view->share('pageTitle', $pageTitle);
    }

    public function getLayout()
    {
        return $this->layout;
    }

    protected function determineLayout($layout)
    {
        if (is_null($layout)) {
            if (is_null($this->layout)) {
                if ($this->request->ajax()) {
                    $layout = $this->view->make($this->layoutOptions['ajax']);
                } else {
                    $layout = $this->view->make($this->layoutOptions['default']);
                }
            } else {
                $layout = $this->view->make($this->layout);
            }
        } else {
            $layout = $this->view->make($layout);
        }

        return $layout;
    }
}