<?php namespace NukaCode\Core\Controllers;

use Illuminate\Support\Str;
use NukaCode\Core\Http\Requests\ProfileRequest;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;
use NukaCode\Core\Requests\Ajax;
use NukaCode\Core\Servicing\LeftTab;
use NukaCode\Core\View\View;

class UserController extends \BaseController {

    private $user;

    /**
     * @var \NukaCode\Core\View\LeftTab
     */
    private $leftTab;

    /**
     * @var \NukaCode\Core\Requests\Ajax
     */
    private $ajax;

    /**
     * @var \NukaCode\Core\View\View
     */
    private $coreView;

    public function __construct(UserRepositoryInterface $user, LeftTab $leftTab, Ajax $ajax, View $coreView)
    {
        parent::__construct();
        $this->user     = $user;
        $this->leftTab  = $leftTab;
        $this->ajax     = $ajax;
        $this->coreView = $coreView;
    }

    public function datatable()
    {
        $dataTable = Datatable::
            collection(\User::all(array('username', 'email')))
                ->showColumns('username', 'email')
                ->searchColumns('username')
                ->orderColumns('username', 'email')
            ->make();

        return $dataTable;
    }

    public function memberlist()
    {
        $users = $this->user->orderByName();

        $this->setViewData('users', $users);
    }

    public function account()
    {
        $this->leftTab
            ->addPanel()
                ->setTitle($this->activeUser->username)
                ->setBasePath('user')
                ->addTab('Profile', 'profile')
                ->addTab('Avatar', 'avatar')
                ->addTab('Preferences', 'preferences')
                ->addTab('Change Password', 'change-password')
                ->addTab('Upload Avatar', 'upload-avatar')
                ->buildPanel()
            ->make();
    }

    public function view($userId = null)
    {
        if ($userId == null) {
            $this->redirect('/');
        }

        $user = $this->user->find($userId);

        $this->setViewData('user', $user);
    }

    public function postProfile(ProfileRequest $request)
    {
        // Update the user
        $this->user->update($request->all());

        // Send the response
        return $this->ajax->sendResponse();
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

    public function postUploadAvatar()
    {
        if($this->input->hasFile('avatar')) {
			// Set avatar
			$image       = $this->user->uploadAvatar($this->input->file('avatar'), $this->activeUser->username);
			$imageErrors = $image->getErrors();

			if (count($imageErrors) > 0) {
				$this->addErrors($imageErrors);
			}

			return $this->redirect('/user/account#upload-avatar', 'Avatar uploaded');
		}
    }
}