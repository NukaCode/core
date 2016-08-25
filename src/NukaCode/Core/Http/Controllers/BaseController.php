<?php

namespace NukaCode\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Blade;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;
use NukaCode\Core\View\ViewBuilder;

abstract class BaseController extends Controller
{

    protected $layout;

    protected $layoutOptions = [
        'default' => 'layouts.default',
        'ajax'    => 'layouts.ajax',
    ];

    /********************************************************************
     * View helpers
     ******************************************************************

    /**
     * Find the view for the called method.
     *
     * @param null|string $view
     * @param null|string $layout
     *
     * @return $this
     */
    public function view($view = null, $layout = null)
    {
        if (! is_null($layout)) {
            $this->layoutOptions = [
                'default' => $layout,
                'ajax'    => $layout,
            ];
        }

        // Set up the default view resolution
        viewBuilder()->setUp($this->layoutOptions, $view);
        $this->setupLayout();
    }

    /**
     * Pass data to the view.
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return $this
     */
    public function setViewData($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $name => $data) {
                view()->share($name, $data);
            }
        } else {
            view()->share($key, $value);
        }
    }

    /**
     * Pass data directly to Javascript.
     *
     * @link https://github.com/laracasts/PHP-Vars-To-Js-Transformer
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return $this
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
     * Force the layout for the view.
     *
     * @param $view
     */
    public function setViewLayout($view)
    {
        viewBuilder()->setViewLayout($view);
        
        $this->layout = viewBuilder()->getLayout();
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
        $this->layout = viewBuilder()->getLayout();
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
        viewBuilder()->missingMethod($parameters);
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
    protected function resetBladeSyntax()
    {
        Blade::setEchoFormat('%s');
        Blade::setContentTags('{{', '}}');
        Blade::setEscapedContentTags('{{{', '}}}');
    }
}
