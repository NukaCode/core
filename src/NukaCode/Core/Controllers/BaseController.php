<?php namespace NukaCode\Core\Controllers;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Routing\Controller;
use Auth, Blade, CoreView, Event, Log, Session, Str, Request, View;

class BaseController extends Controller {

	protected $activeUser = null;

	public    $layout;

	public    $menu;

	/**
	 * Create a new Controller instance.
	 * Assigns basic details
	 */
	public function __construct()
	{
		// Resetting blade syntax to original
		Blade::setEchoFormat('%s');
		Blade::setContentTags('{{', '}}');
		Blade::setEscapedContentTags('{{{', '}}}');

		// Set up the active user
		$this->setActiveUser();

		// Set up the menu
		$this->getMenu();

		// Set up the layout and the initial view
		CoreView::setUp($this->menu);
	}

	/**
	 * Execute an action on the controller.
	 *
	 * @param  string $method
	 * @param  array  $parameters
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function callAction($method, $parameters)
	{
		$response = call_user_func_array(array($this, $method), $parameters);

		if (is_null($response) && ! is_null($this->layout)) {
			$response = $this->layout;
		}

		return $response;
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

	/**
	 * Set the active user for controller and view use
	 */
	public function setActiveUser()
	{
		// Make sure a user is logged in
		if (Auth::check()) {
			// Set the active user in session
			if (! Session::has('activeUser')) {
				Session::put('activeUser', Auth::user());
			}
			$this->activeUser = Session::get('activeUser');
			$this->activeUser->updateLastActive();
		}

		View::share('activeUser', $this->activeUser);
	}

	/********************************************************************
	 * Permissions
	 ******************************************************************
	 *
	 * Check is the active user has a given set of roles
	 *
	 * @param array|string $roles
	 *
	 * @return bool
	 */
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

	/**
	 * @param $permissions
	 *
	 * @return bool
	 */
	public function hasPermission($permissions)
	{
		if (Auth::check()) {
			$access = $this->activeUser->checkPermission($permissions);

			if ($access === true) {
				return true;
			}
		}

		return false;
	}

	public function checkPermission($actionKeyName)
	{
		$check = $this->hasPermission($actionKeyName);

		if ($check == false) {
			return \App::abort(403, 'You do not have permission to access this area.');
		}
	}

	/********************************************************************
	 * Sugar
	 *******************************************************************/

	/********************************************************************
	 * Redirecting
	 ******************************************************************
	 *
	 * @param        $url
	 * @param        $message
	 * @param string $type
	 *
	 * @return
	 */
	public function redirect($url, $message, $type = 'message')
	{
		return \Redirect::to($url)->with($type, $message);
	}

	/**
	 * @param        $route
	 * @param array  $parameters
	 * @param        $message
	 * @param string $type
	 *
	 * @return mixed
	 */
	public function redirectRoute($route, array $parameters, $message, $type = 'message')
	{
		return \Redirect::route($route, $parameters)->with($type, $message);
	}

	public function redirectIntended($route = 'home')
	{
		return \Redirect::intended(route($route));
	}

	/********************************************************************
	 * Views
	 *******************************************************************/
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

	/********************************************************************
	 * Menus
	 *******************************************************************/
	protected function addItemToMenu($node, $title, $link, $index, $key, $options)
	{
		$options['link'] = $link;
		$nodeKey = $key == null ? Str::camel($title) : $key;
		$node->item($nodeKey, $title, $options, [], $index);
	}

	public function addMenuItem($title, $link, $index = null, $key = null, $options = [])
	{
		$this->addItemToMenu($this->menu, $title, $link, $index, $key, $options);
	}

	public function addSubMenuItem($parentKey, $title, $link, $index = null, $key = null, $options = [])
	{
		$parent = $this->menu->item($parentKey);
		$this->addItemToMenu($parent, $title, $link, $index, $key, $options);
	}

	public function addRightMenuItem($title, $link, $index = null, $key = null, $options = [])
	{
		$right = $this->menu->item('right');
		$this->addItemToMenu($right, $title, $link, $index, $key, $options);
	}

	public function addRightSubMenuItem($parentKey, $title, $link, $index = null, $key = null, $options = [])
	{
		$right  = $this->menu->item('right');
		$parent = $right->item($parentKey);

		$this->addItemToMenu($parent, $title, $link, $index, $key, $options);
	}

	public function __call($method, $parameters)
	{
		$parameters = array_merge((array)$method, $parameters);
		return $this->missingMethod($parameters);
	}
}