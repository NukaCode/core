<?php

namespace NukaCode\Core\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;
use NukaCode\Core\Support\Facades\View\ViewBuilder;

abstract class BaseController extends Controller
{

    protected $layout;

    protected $layoutOptions = [
        'default' => 'layouts.default',
        'ajax'    => 'layouts.ajax'
    ];

    protected $resetBlade = false;

    protected $domainDesign = false;

    public function __construct()
    {
        if ($this->resetBlade === true) {
            // Resetting blade syntax to original
            $this->resetBladeSyntax();
        }

        if (! app()->runningInConsole()) {
            // Set up the default view resolution
            ViewBuilder::setUp($this->layoutOptions, $this->domainDesign);
            $this->setupLayout();
        }
    }

    /********************************************************************
     * View helpers
     *******************************************************************/

    /**
     * Pass data to the view.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function setViewData($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $name => $data) {
                View::share($name, $data);
            }
        } else {
            View::share($key, $value);
        }
    }

    /**
     * Pass data directly to Javascript.
     *
     * @link https://github.com/laracasts/PHP-Vars-To-Js-Transformer
     *
     * @param mixed $key
     * @param mixed $value
     */
    protected function setJavascriptData($key, $value = null)
    {
        if (is_array($key)) {
            JavaScriptFacade::put($key);
        } else {
            JavaScriptFacade::put([$key => $value]);
        }
    }

    /**
     * Force the view path.
     *
     * @param $view
     */
    public function setViewPath($view)
    {
        ViewBuilder::setViewPath($view);
    }

    /**
     * Force the layout for the view.
     *
     * @param $view
     */
    public function setViewLayout($view)
    {
        ViewBuilder::setViewLayout($view, $this->domainDesign);

        $this->layout = ViewBuilder::getLayout();
    }

    /**
     * Do not display a view for this request.
     */
    public function skipView()
    {
        $this->layout->content = null;
    }

    /**
     * Master template method
     * Sets the template based on location and passes variables to the view.
     *
     * @return void
     */
    public function setupLayout()
    {
        $this->layout = ViewBuilder::getLayout();
    }

    /********************************************************************
     * Auto resolve methods
     *******************************************************************/

    /**
     * Execute an action on the controller.
     *
     * Overloading this method to make sure our layout is
     * always used.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $response = call_user_func_array([$this, $method], $parameters);

        if (is_null($response) && ! is_null($this->layout)) {
            $response = $this->layout;
        }

        return $response;
    }

    /**
     * Catch a missing method and try to figure out what
     * it should be.
     *
     * @param array $parameters
     *
     * @return mixed|void
     */
    public function missingMethod($parameters = [])
    {
        ViewBuilder::missingMethod($parameters);
    }

    /**
     * Catch any un-found method and route through
     * missing method.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed|void
     */
    public function __call($method, $parameters)
    {
        $parameters = array_merge((array)$method, $parameters);

        return $this->missingMethod($parameters);
    }

    /**
     * Resets blade syntax to Laravel 4 style.
     */
    private function resetBladeSyntax()
    {
        Blade::setEchoFormat('%s');
        Blade::setContentTags('{{', '}}');
        Blade::setEscapedContentTags('{{{', '}}}');
    }
}
