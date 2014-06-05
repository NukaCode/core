<?php namespace NukaCode\Core\View;

use Illuminate\Config\Repository;
use Illuminate\View\Factory;
use Illuminate\Http\Request;
use ReflectionClass;

class Layout {

    public $layout;

    protected $view;

    protected $request;

    protected $config;

    /**
     * Layouts array
     *
     * @var string[] $layouts Array of layout templates
     */
    protected $layoutOptions = [
        'default' => 'layouts.default',
        'ajax'    => 'layouts.ajax'
    ];

    public function __construct(Factory $view, Request $request, Repository $config)
    {
        $this->view    = $view;
        $this->request = $request;
        $this->config  = $config;
    }

    public function setUp()
    {
        $this->layout = $this->determineLayout();
        $this->setPageTitle();

        return $this;
    }

    public function setPageTitle()
    {
        $area     = $this->request->segment(1);
        $location = ($this->request->segment(2) != null ? ': '. ucwords($this->request->segment(2)) : '');

        if ($area != null) {
            $this->layout->pageTitle = ucwords($area).$location;
        } else {
            $this->layout->pageTitle = $this->config->get('app.siteName'). ($this->request->segment(1) != null ? ': '.ucwords($this->request->segment(1)) : '');
        }
    }

    public function getLayout()
    {
        return $this->layout;
    }

    protected function determineLayout()
    {
        if (is_null($this->layout)) {
            if ($this->request->ajax()) {
                $layout = $this->view->make($this->layoutOptions['ajax']);
            } else {
                $layout = $this->view->make($this->layoutOptions['default']);
            }
        } else {
            $layout = $this->view->make($this->layout);
        }

        return $layout;
    }
}