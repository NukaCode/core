<?php namespace NukaCode\Core\Controllers;

use Illuminate\Auth\AuthManager;
use Laracasts\Commander\CommanderTrait;
use NukaCode\Core\Commands\Session\RegistrationCommand;
use NukaCode\Core\Http\Requests\User\Login;
use NukaCode\Core\Http\Requests\User\Registration;

class SessionController extends \BaseController {

	use CommanderTrait;

	/**
	 * Log the user in
	 *
	 * @param AuthManager  $auth
	 * @param LoginRequest $request
	 *
	 * @return mixed
	 */
	public function postLogin(AuthManager $auth, Login $request)
    {
		// Set the auth data
		$userData = [
			'username' => $request->get('username'),
			'password' => $request->get('password')
		];

		// Log in successful
		if ($auth->attempt($userData)) {
			return $this->redirectIntended();
		}

		// Login failed
		return $this->redirectRoute('login', [], 'Your username or password was incorrect.', 'login_errors');
    }

	/**
	 * Register a user
	 *
	 * @param RegistrationRequest $request
	 *
	 * @return mixed
	 */
	public function postRegister(Registration $request)
    {
		// Run the registration command
		$result = $this->execute(RegistrationCommand::class, $request->only('username', 'password', 'email'));

		// Redirect on failure
		if ($result !== true) {
			return $this->redirectRoute('register', [], $result, 'errors');
		}

        return $this->redirect(route('home'));
    }

	/**
	 * Collapse or expand a panel and persist the state
	 *
	 * @param string $target
	 */
	public function collapse($target)
    {
		// Define the session name
        $sessionName = 'COLLAPSE_' . $target;

        if ($this->session->get($sessionName)) {
			// If it is currently true, set it to false so it collapses
            $this->session->put($sessionName, false);

            // Update the user preference
            $preference = $this->activeUser->getPreferenceByKeyName($sessionName);
            $this->activeUser->setPreferenceValue($preference->id, false);
        } else {
			// If it is currently false, set it to true so it expands
            $this->session->put($sessionName, true);

            // Update the user preference
            $preference = $this->activeUser->getPreferenceByKeyName($sessionName);
            $this->activeUser->setPreferenceValue($preference->id, true);
        }
    }

} 