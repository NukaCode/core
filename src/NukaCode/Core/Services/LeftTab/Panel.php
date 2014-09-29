<?php namespace NukaCode\Core\Services\LeftTab;

use HTML;

class Panel {

    /**
     * The id of the panel used in collapse.
     */
    public $id = null;

    /**
     * The title of the panel.
     */
    public $title = 'Left Tabs';

    /**
     * The base path used in each tab.
     */
    public $basePath = null;

    /**
     * The tabs collection.
     */
    public $tabs = null;

    /**
     * Left tab parent object.
     */
    public $leftTab = null;

    /**
     * When the class is constructed assign a new collection to
     * the tabs var. Also set the left tab object so we can get back.
     */
    public function __construct($leftTab)
    {
        $this->tabs = new \Utility_Collection();
        $this->leftTab = $leftTab;
    }

    /**
     * Set the panel id used for collapse.
     *
     * @param $id The id of the panel.
     * @return LeftTab_Panel
     */
    public function setId($id)
    {
        $this->id = ucwords($id);

        return $this;
    }

    /**
     * Set the base path used for each tab.
     *
     * @param $basePath Base path used on each tab.
     * @return LeftTab_Panel
     */
    public function setBasePath($basePath)
    {
        if (!ends_with($basePath, '/')) {
            $basePath = $basePath . '/';
        }

        if (!starts_with($basePath, '/')) {
            $basePath = '/' . $basePath;
        }

        $this->basePath = $basePath;

        return $this;
    }

    /**
     * Add a new tab.
     *
     * @param $title The text displayed in the tab.
     * @param $path The url the tab should load.
     * @param $id The id of the tab. Used for default tab.
     * @param $options Extra options for the tab (Not Implemented Yet)
     * @return LeftTab_Panel
     */
    public function addTab($title, $path, $id = null, $options = array())
    {
        $newTab = new \stdClass();
        $newTab->title = $title;
        $newTab->path = $path;

        if ($id == null) {
            $newTab->id =  \Str::lower(str_replace(' ', '-', $title));
        }
        else {
            $newTab->id = $id;
        }
        
        $newTab->options = $options;

        $this->tabs->add($newTab);

        return $this;
    }

    /**
     * Set the panel title.
     *
     * @param $title The title to display at the top of the panel.
     * @return LeftTab_Panel
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param $array array
     * @param $keys  mixed
     *
     * @return mixed
     */
    public function setValues($array, $keys)
    {
        foreach ((array)$keys as $key) {
            if (isset($array[$key])) {
                call_user_func_array([$this, "set{$key}"], [$array[$key]]);
            }
        }
    }

    /**
     * Use the base path and update all tab paths.
     *
     * @return void
     */
    public function updateTabPaths()
    {
        if ($this->basePath != null) {
            foreach ($this->tabs as $key => $tab) {

                if (starts_with($tab->path, '/')) {
                    $this->tabs[$key]->path = $this->basePath . rtrim($tab->path , '/');
                }
                else {
                    $this->tabs[$key]->path = $this->basePath . $tab->path;
                }
            }
        }
    }

    /**
     * Build the panel and return to the left tab object.
     *
     * @return LeftTab
     */
    public function buildPanel()
    {
        $this->updateTabPaths();

        $leftTab = $this->leftTab;
        unset($this->leftTab);

        $leftTab->panels->add($this);

        return $leftTab;
    }

}