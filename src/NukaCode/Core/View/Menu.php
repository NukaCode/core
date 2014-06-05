<?php namespace NukaCode\Core\View;

use Menu\Menu as MainMenu;
use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;
use Illuminate\View\Factory;

class Menu {

    public $viewMenu;

    protected $menu;

    protected $session;

    protected $config;

    public function __construct(MainMenu $menu, SessionManager $session, Repository $config, Factory $view)
    {
        $this->menu    = $menu;
        $this->session = $session;
        $this->config  = $config;
        $this->view    = $view;
    }

    public function setUp()
    {
        // Handle the different menus
        $menu = $this->session->has('activeUser') ? $this->session->get('activeUser')->getPreferenceValueByKeyName('SITE_MENU') : $this->config->get('core::menu');

        if (method_exists($this, $menu)) {
            $this->{$menu}();

            $this->view->share('menu', $menu);

            return $this;
        }

        throw new \InvalidArgumentException("Unknown menu [$this->siteMenu] passed.");
    }

    public function twitter()
    {
        // Set the menu to twitter's style
        MainMenu::handler('main')->addClass('nav navbar-nav');
        MainMenu::handler('mainRight')->addClass('nav navbar-nav navbar-right');

        // Handle children
        MainMenu::handler('main')->getItemsByContentType('Menu\Items\Contents\Link')
            ->map(function ($item) {
                if ($item->hasChildren()) {
                    $item->getContent()->addClass('dropdown-toggle')->dataToggle('dropdown');
                    if (strpos($item->getContent(), 'class="caret"') === false) {
                        $item->getContent()->value($item->getContent()->getValue() . ' <b class="caret"></b>');
                    }
                    $item->getChildren()->addClass('dropdown-menu');
                }
            });
        MainMenu::handler('mainRight')->getItemsByContentType('Menu\Items\Contents\Link')
            ->map(function ($item) {
                if ($item->hasChildren()) {
                    $item->getContent()->addClass('dropdown-toggle')->dataToggle('dropdown');
                    if (strpos($item->getContent(), 'class="caret"') === false) {
                        $item->getContent()->value($item->getContent()->getValue() . ' <b class="caret"></b>');
                    }
                    $item->getChildren()->addClass('dropdown-menu');
                }
            });
    }

    public function utopian()
    {
        // Set the menu to utopian's style
        MainMenu::handler('main')->id('utopian-navigation')->addClass('black utopian');
        MainMenu::handler('mainRight')->id('utopian-navigation')->addClass('black utopian');

        // Handle children
        MainMenu::handler('main')->getItemsByContentType('Menu\Items\Contents\Link')
            ->map(function ($item) {
                if ($item->hasChildren()) {
                    $item->addClass('dropdown');
                }
            });
        MainMenu::handler('mainRight')->getItemsByContentType('Menu\Items\Contents\Link')
            ->map(function ($item) {
                if ($item->hasChildren()) {
                    $item->addClass('dropdown');
                }
            });
    }
}