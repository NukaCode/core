<?php

namespace NukaCode\Core\View\Models;

use Illuminate\Support\Collection;
use ReflectionClass;

class ViewModel
{
    /**
     * @var null|string
     */
    public $prefix = null;

    /**
     * @var null|string
     */
    public $controller = null;

    /**
     * @var null|string
     */
    public $action = null;

    /**
     * @var null|string
     */
    public $view = null;

    /**
     * @var Collection
     */
    public $prefixes;

    /**
     * @var Collection
     */
    public $attemptedViews;

    /**
     * @param array $routeParts
     */
    public function __construct(array $routeParts)
    {
        $this->attemptedViews = collect();

        $this->parseController(head($routeParts));
        $this->parseAction(last($routeParts));
        $this->getPrefixes();
        $this->setView();
    }

    /**
     * Find the most reasonable view available.
     *
     * @return null
     */
    public function getView()
    {
        // If we don't have a prefix, just return the view.
        if (is_null($this->prefix)) {
            return $this->getBaseView();
        }

        // Set up modifiable variables.
        $view     = $this->concatViewAndPrefix($this->prefix, $this->view);
        $prefixes = clone $this->prefixes;

        $this->attempted($view);

        // Try to find a valid view.
        while (! view()->exists($view)) {
            // If we are out of prefixes and the view still isn't found, back out.
            if (is_null($this->prefix) && ! view()->exists($view)) {
                $this->view = null;
                break;
            }

            // Remove prefixes until we don't have any left.
            if ($prefixes->count() > 0) {
                $prefixes->pop();

                $prefixes     = $this->removeControllerFromPrefixes($prefixes);
                $this->prefix = $prefixes->count() > 0 ? $prefixes->implode('.') : null;
                $view         = $this->concatViewAndPrefix($this->prefix, $this->view);
            } else {
                $this->prefix = null;
                $view         = $this->view;
            }

            $this->attempted($view);
        }

        return $this->view;
    }

    /**
     * When a view is checked, add it to attempted.
     *
     * @param string $view
     */
    protected function attempted($view)
    {
        $this->attemptedViews = $this->attemptedViews->push($view);
    }

    /**
     * Combine a prefix and view to get a full path.
     *
     * @param string $prefix
     * @param string $view
     *
     * @return string
     */
    public function concatViewAndPrefix($prefix, $view)
    {
        if (is_null($prefix) || ! $prefix) {
            return $view;
        }

        return $prefix . '.' . $view;
    }

    /**
     * Get a properly formatted controller name.
     *
     * @param string $class
     *
     * @return string
     */
    protected function parseController($class)
    {
        $class            = (new ReflectionClass($class))->getShortName();
        $this->controller = strtolower(str_replace('Controller', '', $class));
    }

    /**
     * Get a properly formatted action name.
     *
     * @param string $action
     *
     * @return string
     */
    protected function parseAction($action)
    {
        $this->action = strtolower(
            preg_replace(['/^get/', '/^post/', '/^put/', '/^patch/', '/^delete/'], '', $action)
        );
    }

    /**
     * Search for any prefixes attached to this route.
     *
     * @return string
     */
    protected function getPrefixes()
    {
        $router = app(\Illuminate\Routing\Router::class);

        $this->prefixes = collect(
            explode('/', $router->getCurrentRoute()->getPrefix())
        );

        // Remove the last prefix if it matches the controller.
        $this->prefixes = $this->removeControllerFromPrefixes($this->prefixes)->filter();

        if ($this->prefixes->count() > 0) {
            $this->prefix = $this->prefixes->implode('.');
        }
    }

    /**
     * Remove the last prefix if it matches the controller.
     *
     * @param \Illuminate\Support\Collection $prefixes
     *
     * @return mixed
     */
    protected function removeControllerFromPrefixes($prefixes)
    {
        if ($prefixes->last() == $this->controller) {
            $prefixes->pop();
        }

        return $prefixes;
    }

    /**
     * Combine the controller and action to create a proper view string.
     */
    protected function setView()
    {
        $this->view = $this->controller . '.' . $this->action;
    }

    /**
     * Return the base view if it exists.
     *
     * @return null|string
     */
    private function getBaseView()
    {
        $this->attempted($this->view);

        return view()->exists($this->view) ? $this->view : null;
    }
}
