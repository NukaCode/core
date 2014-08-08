<?php namespace NukaCode\Core\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;

class SessionController extends \BaseController {

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

    public function postLogin()
    {
        $input = e_array($this->input->all());

        if ($input != null) {
            $userData = [
                'username' => $input['username'],
                'password' => $input['password']
            ];

            if ($this->auth->attempt($userData)) {
                return $this->redirect->intended('/');
            } else {
                return $this->redirect->to('/login')->with('login_errors', 'Your username or password was incorrect.');
            }
        }
    }

    public function getRegister() {}

    public function postRegister()
    {
        $input = e_array($this->input->all());

        if ($input != null) {
            $result = $this->user->create($input);

            if ($result !== true) {
                $this->redirect->to('/register')->with('errors', $result);
            }

            // Assign the guest role
            $this->user->getEntity()->addRole(\Config::get('core::Roles.guest'));
        }

        $this->auth->login($this->user->getEntity());

        return $this->redirect->to('/');
    }

    public function getCollapse($target)
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