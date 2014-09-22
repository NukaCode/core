<?php namespace NukaCode\Core\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Session\SessionManager;
use Laracasts\Commander\CommanderTrait;
use NukaCode\Core\Commands\Session\RegistrationCommand;
use NukaCode\Core\Http\Requests\User\LoginRequest;
use NukaCode\Core\Http\Requests\User\RegistrationRequest;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;

class SessionController extends \BaseController {

	use CommanderTrait;

    /**
     * @var \Illuminate\Auth\Guard
     */
    private $auth;

    /**
     * @var \Illuminate\Session\SessionManager
     */
    private $session;

    private $user;

    public function __construct(AuthManager $auth, SessionManager $session, UserRepositoryInterface $user)
    {
        parent::__construct();
        $this->auth     = $auth;
        $this->session  = $session;
        $this->user     = $user;
    }

    public function getLogin() {}

    public function postLogin(LoginRequest $request)
    {
		$userData = [
			'username' => $request->get('username'),
			'password' => $request->get('password')
		];

		if ($this->auth->attempt($userData)) {
			return $this->redirect->intended('/');
		}

		return $this->redirect->to('/login')->with('login_errors', 'Your username or password was incorrect.');
    }

    public function getRegister() {}

    public function postRegister(RegistrationRequest $request)
    {
		// New way
		$result = $this->execute(RegistrationCommand::class, $request->only('username', 'password', 'email'));

		// Redirect on failure
		if ($result !== true) {
			return $this->redirect->to('/register')->with('errors', $result);
		}

        return $this->redirect->to('/');
    }

    public function collapse($target)
    {
        $this->skipView();

        $sessionName = 'COLLAPSE_' . $target;
        if ($this->session->get($sessionName)) {
            $this->session->put($sessionName, false);

            // Update the user preference
            $preference = $this->activeUser->getPreferenceByKeyName($sessionName);
            $this->activeUser->setPreferenceValue($preference->id, false);
        } else {
            $this->session->put($sessionName, true);

            // Update the user preference
            $preference = $this->activeUser->getPreferenceByKeyName($sessionName);
            $this->activeUser->setPreferenceValue($preference->id, true);
        }
    }

} 