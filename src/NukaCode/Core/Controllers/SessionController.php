<?php namespace NukaCode\Core\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Session\SessionManager;

class SessionController extends \BaseController {

    /**
     * @var \Illuminate\Auth\Guard
     */
    private $auth;

    /**
     * @var \Illuminate\Http\Request
     */
    private $input;

    /**
     * @var \Illuminate\Routing\Redirector
     */
    private $redirect;

    /**
     * @var \Illuminate\Session\SessionManager
     */
    private $session;

    public function __construct(AuthManager $auth, Request $input, Redirector $redirect, SessionManager $session)
    {
        parent::__construct();
        $this->auth     = $auth;
        $this->input    = $input;
        $this->redirect = $redirect;
        $this->session  = $session;
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

    public function postRegister()
    {
        $input = e_array(Input::all());

        if ($input != null) {
            $user            = new User;
            $user->username  = $input['username'];
            $user->password  = $input['password'];
            $user->email     = $input['email'];
            $user->status_id = 1;

            $this->checkErrorsSave($user);

            // Assign the guest role
            $user->roles()->attach(BaseModel::ROLE_GUEST);
        }

        return $this->redirect('/');
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