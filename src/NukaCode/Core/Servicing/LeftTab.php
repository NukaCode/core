<?php namespace NukaCode\Core\Servicing;

use HTML;
use NukaCode\Core\Database\Collection as Utility_Collection;
use NukaCode\Core\View\View;

class LeftTab {

    /**
     * Template name to load at the top of the page.
     */
    public $header = null;

    /**
     * Tab that is loaded on page load.
     */
    public $defaultTab = null;

    /**
     * Html to display while the page is loaded via ajax.
     */
    public $loadingIcon = '<i class="fa fa-spinner fa-spin"></i>';

    /**
     * Should the panels collapse
     */
    public $collapsible = false;

    /**
     * Panel objects
     */
    public $panels = null;

    /**
     * Whether to use the list-glow view
     */
    public $glow = false;

    /**
     * When the class is constructed assign a new collection to
     * the panels var.
     */
    public function __construct(View $viewPath)
    {
        $this->panels = new Utility_Collection();
    }

    /**
     * Set the template that will display above the left tabs
     *
     * @param $headerPath The path to the view file.
     *
     * @return LeftTab
     */
    public function setHeader($headerPath)
    {
        if (\CoreView::checkView($headerPath)) {
            $this->header = $headerPath;
        }

        return $this;
    }

    /**
     * Add a new panel to the left tab
     *
     * @return LeftTab_Panel
     */
    public function addPanel()
    {
        return new LeftTab\Panel($this);
    }

    /**
     * The the default tab loaded at page load.
     *
     * @param $tab The id or number of the tab to load.
     *
     * @return LeftTab
     */
    public function setDefaultTab($tab)
    {
        if (intval($tab)) {
            $this->setDefaultTab($this->panels->tabs[($tab - 1)]->id);
        } else {
            $this->defaultTab = $tab;
        }

        return $this;
    }

    /**
     * Set the loading html while the tap is loaded via ajax.
     *
     * @param $loadingIcon The HTML to display.
     *
     * @return LeftTab
     */
    public function setLoadingIcon($loadingIcon)
    {
        $this->loadingIcon = $loadingIcon;

        return $this;
    }

    /**
     * Set  the panels collapse.
     *
     * @param bool $collapsible
     *
     * @return LeftTab
     */
    public function setCollapsible($collapsible)
    {
        $this->collapsible = (bool)$collapsible;

        return $this;
    }

    /**
     * Set the panels to use list-glow
     *
     * @param bool $glow
     *
     * @return LeftTab
     */
    public function setGlow($glow)
    {
        $this->glow = (bool)$glow;

        return $this;
    }

    /**
     * Build the left tab helper.
     *
     * @return void
     */
    public function make()
    {
        // Set the default tab
        if ($this->defaultTab == null) {
            $this->setDefaultTab($this->panels->tabs->first()->id);
        }

        if ($this->glow) {
            \CoreView::setViewPath('helpers.lefttabglow')->addData('settings', $this);
        } else {
            \CoreView::setViewPath('helpers.lefttab')->addData('settings', $this);
        }
    }

    public function parseConfig($config)
    {
        // Handle the unique options
        $this->setValues($config, ['Collapsible', 'LoadingIcon', 'DefaultTab']);

        // Handle the panels
        foreach ($config['panels'] as $panel) {
            $newPanel = $this->addPanel();

            // Handle the unique options
            $newPanel->setValues($panel, ['Id', 'BasePath', 'Title']);

            foreach ($panel['tabs'] as $tab) {
                $title   = $tab['title'];
                $path    = $tab['path'];
                $id      = isset($tab['id']) ? $tab['id'] : null;
                $options = isset($tab['options']) ? $tab['options'] : [];

                $newPanel->addTab($title, $path, $id, $options);
            }

            $newPanel->buildPanel();
        }

        $this->make();
    }

    /**
     * @param $array array
     * @param $keys  mixed
     *
     * @return mixed
     */
    protected function setValues($array, $keys)
    {
        foreach ((array)$keys as $key) {
            if (isset($array[$key])) {
                call_user_func_array([$this, "set{$key}"], [$array[$key]]);
            }
        }
    }
}