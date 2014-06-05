<?php namespace NukaCode\Core\Controllers;

use Illuminate\Routing\Controller;
use Auth;
use CoreView;
use Session;
use View;

class BaseController extends Controller {

    protected $activeUser = null;

    protected $layout;

    /**
     * Create a new Controller instance.
     * Assigns the active user
     */
    public function __construct()
    {
        // Set up the menu
        $this->getMenu();

        // Set up the layout and the initial view
        CoreView::setUp();

        // Set up the actve user
        $this->setActiveUser();
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

    // Sugar Methods
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
}