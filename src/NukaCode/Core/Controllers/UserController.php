<?php namespace NukaCode\Core\Controllers;

use Illuminate\Http\Request;
use Input;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;
use NukaCode\Core\Requests\Ajax;
use NukaCode\Core\Servicing\LeftTab;
use NukaCode\Core\View\View;
use Datatable;

class UserController extends \BaseController {

    private $user;

    /**
     * @var \NukaCode\Core\View\LeftTab
     */
    private $leftTab;

    /**
     * @var \Illuminate\Http\Request
     */
    private $input;

    /**
     * @var \NukaCode\Core\Requests\Ajax
     */
    private $ajax;

    /**
     * @var \NukaCode\Core\View\View
     */
    private $coreView;

    public function __construct(UserRepositoryInterface $user, LeftTab $leftTab, Request $input, Ajax $ajax, View $coreView)
    {
        parent::__construct();
        $this->user     = $user;
        $this->leftTab  = $leftTab;
        $this->input    = $input;
        $this->ajax     = $ajax;
        $this->coreView = $coreView;
    }

    public function getDatatable()
    {
        $dataTable = Datatable::
            collection(\User::all(array('username', 'email')))
                ->showColumns('username', 'email')
                ->searchColumns('username')
                ->orderColumns('username', 'email')
            ->make();

        return $dataTable;
    }

    public function getMemberlist()
    {
        $users = $this->user->orderByName();

        $this->setViewData('users', $users);
    }

    public function getAccount()
    {
        $this->leftTab
            ->addPanel()
                ->setTitle($this->activeUser->username)
                ->setBasePath('user')
                ->addTab('Profile', 'profile')
                ->addTab('Avatar', 'avatar')
                ->addTab('Preferences', 'preferences')
                ->addTab('Change Password', 'change-password')
                ->buildPanel()
            ->make();
    }

    public function getView($userId = null)
    {
        if ($userId == null) {
            $this->redirect('/');
        }

        $user = $this->user->find($userId);

        $this->setViewData('user', $user);
    }

    public function postProfile()
    {
        // Update the user
        $this->user->update($this->input->all());

        // Send the response
        return $this->ajax->sendResponse();
    }

    public function getChangePassword()
    {
    }

    public function postChangePassword()
    {
        // Update the user
        $this->user->updatePassword($this->input->only('oldPassword', 'newPassword', 'newPasswordAgain'));

        // Send the response
        return $this->ajax->sendResponse();
    }

    public function getPreferences()
    {
        $preferences = \User_Preference::where('hiddenFlag', 0)->orderByNameAsc()->get();

        $this->setViewData('preferences', $preferences);
    }

    public function postPreferences()
    {
        $input = e_array($this->input->all());

        if ($input != null) {
            foreach ($input['preference'] as $keyName => $value) {
                $preference = $this->activeUser->getPreferenceByKeyName($keyName);
                $this->activeUser->setPreferenceValue($preference->id, $value);
            }
        }

        return $this->ajax->setStatus('success')->sendResponse();
    }

    public function getAvatar()
    {
        $avatarPreference = $this->activeUser->getPreferenceByKeyName('AVATAR');
        $preferenceArray  = $this->activeUser->getPreferenceOptionsArray($avatarPreference->id);

        $this->setViewData('avatarPreference', $avatarPreference);
        $this->setViewData('preferenceArray', $preferenceArray);
    }

    public function postAvatar()
    {
        $input = e_array($this->input->all());

        // Set avatar preference
        $this->activeUser->setPreferenceValue($input['avatar_preference_id'], $input['avatar_preference']);

        return $this->ajax->setStatus('success')->sendResponse();
    }
}