<?php namespace NukaCode\Core\Controllers;

use Illuminate\Routing\Controller;
use Auth;
use CoreView;
use Session;
use Str;
use View;
use Event;

class BaseController extends Controller {

    protected $activeUser = null;

    protected $layout;

    public    $menu;

    /**
     * Create a new Controller instance.
     * Assigns the active user
     */
    public function __construct()
    {
        // Set up the active user
        $this->setActiveUser();

        // Set up the menu
        $this->getMenu();

        // Set up the layout and the initial view
        CoreView::setUp($this->menu);
    }

    /**
     * Master template method
     * Sets the template based on location and passes variables to the view.
     *
     * @return void
     */
    public function setupLayout()
    {
        $this->layout = CoreView::getLayout();
    }

    public function setActiveUser()
    {
        // Make sure a user is logged in
        if (Auth::check()) {
            // Set the active user in session
            if (!Session::has('activeUser')) {
                Session::put('activeUser', Auth::user());
            }
            $this->activeUser = Session::get('activeUser');
            $this->activeUser->updateLastActive();
        }

        View::share('activeUser', $this->activeUser);
    }

    /********************************************************************
     * Permissions
     *******************************************************************/
    public function hasRole($roles)
    {
        if (Auth::check()) {
            if ($this->activeUser->is('DEVELOPER')) {
                return true;
            }
            $access = $this->activeUser->is($roles);

            if ($access === true) {
                return true;
            }
        }
        Session::put('pre_login_url', Request::path());

        return false;
    }

    public function checkPermission($actionKeyName)
    {
        $check = $this->hasPermission($actionKeyName);

        if ($check == false) {
            $this->errorRedirect();
        }
    }

    public function hasPermission($permissions)
    {
        if (Auth::check()) {
            $access = $this->activeUser->checkPermission($permissions);

            if ($access === true) {
                return true;
            }
        }
        Session::put('pre_login_url', Request::path());

        return false;
    }

    // Sugar Methods
    // Views
    public function setViewData($key, $value)
    {
        View::share($key, $value);
    }

    public function setViewPath($view)
    {
        CoreView::setViewPath($view);
    }

    public function skipView()
    {
        $this->layout->content = null;
    }

    public function missingMethod($parameters = array())
    {
        CoreView::missingMethod($parameters);
    }

    // Menus
    protected function addItemToMenu($node, $title, $link, $index, $key)
    {
        $nodeKey = $key == null ? Str::camel($title) : $key;
        $node->item($nodeKey, $title, $link, [], $index);
    }

    public function addMenuItem($title, $link, $index = null, $key = null)
    {
        $this->addItemToMenu($this->menu, $title, $link, $index, $key);
    }

    public function addSubMenuItem($parentKey, $title, $link, $index = null, $key = null)
    {
        $parent = $this->menu->item($parentKey);
        $this->addItemToMenu($parent, $title, $link, $index, $key);
    }

    public function addRightMenuItem($title, $link, $index = null, $key = null)
    {
        $right = $this->menu->item('right');
        $this->addItemToMenu($right, $title, $link, $index, $key);
    }

    public function addRightSubMenuItem($parentKey, $title, $link, $index = null, $key = null)
    {
        $right  = $this->menu->item('right');
        $parent = $right->item($parentKey);

        $this->addItemToMenu($parent, $title, $link, $index, $key);
    }
}