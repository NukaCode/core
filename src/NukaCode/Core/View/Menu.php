<?php namespace NukaCode\Core\View;

use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;
use Illuminate\View\Factory;

class Menu {

    public $viewMenu;

    protected $session;

    protected $config;

    public function __construct(SessionManager $session, Repository $config, Factory $view)
    {
        $this->session = $session;
        $this->config  = $config;
        $this->view    = $view;
    }

    public function setUp($menu)
    {
        // Handle the different menus
        $menuOption = $this->session->has('activeUser') ? $this->session->get('activeUser')->getPreferenceValueByKeyName('SITE_MENU') : $this->config->get('core::menu');

        $menuViewPath = 'layouts.menus.'. $menuOption;

        if (!$this->view->exists($menuViewPath)) {
            throw new \InvalidArgumentException("Unknown menu [$menuOption] passed.");
        }

        $this->viewMenu = $menu;
        $this->viewMenu->setView($menuViewPath);

        $this->view->share('menuItems', $this->viewMenu);

        // ppd($this->viewMenu);
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
}