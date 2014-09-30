<?php namespace NukaCode\Core\Controllers;

use NukaCode\Core\Http\Requests\User\Avatar;
use NukaCode\Core\Http\Requests\User\Password;
use NukaCode\Core\Http\Requests\User\Preference;
use NukaCode\Core\Http\Requests\User\Profile;
use NukaCode\Core\Http\Requests\User\UploadAvatar;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;
use NukaCode\Core\Requests\Ajax;
use NukaCode\Core\Services\LeftTab;
use NukaCode\Core\View\View;

class UserController extends \BaseController {

	private $userRepo;

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

	/**
	 * @param UserRepositoryInterface $userRepo
	 * @param LeftTab                 $leftTab
	 * @param Ajax                    $ajax
	 * @param View                    $coreView
	 */
	public function __construct(UserRepositoryInterface $userRepo, LeftTab $leftTab, Ajax $ajax, View $coreView)
	{
		parent::__construct();

		$this->userRepo = $userRepo;
		$this->leftTab  = $leftTab;
		$this->ajax     = $ajax;
		$this->coreView = $coreView;
	}

	/**
	 * Get a list of all members on the site
	 */
	public function memberlist()
	{
		// Get all users
		$users = $this->userRepo->orderByName();

		$this->setViewData(compact('users'));
	}

	/**
	 * View the active user's account details
	 */
	public function account()
	{
		// Use left tab service to display navigation options
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

	/**
	 * View details on a specific user
	 *
	 * @param null $userId
	 */
	public function view($userId = null)
	{
		// A user id is required to view
		if ($userId == null) {
			return $this->redirect(route('home'));
		}

		// Get the requested user
		$user = $this->userRepo->find($userId);

		$this->setViewData(compact('user'));
	}

	/**
	 * Update a user's profile details
	 *
	 * @param Profile $request
	 *
	 * @return \Response
	 */
	public function postProfile(Profile $request)
	{
		// Update the user
		$this->userRepo->update($request);

		return $this->ajax->sendResponse();
	}

	/**
	 * Update a user's password
	 *
	 * @param Password $request
	 *
	 * @return \Response
	 */
	public function postChangePassword(Password $request)
	{
		// Update the user
		$this->userRepo->updatePassword($request->only('password', 'new_password', 'new_password_confirmation'));

		return $this->ajax->sendResponse();
	}

	/**
	 * Get all visible preferences
	 */
	public function getPreferences()
	{
		// Get all preferences
		$preferences = $this->userRepo->getVisiblePreferences();

		$this->setViewData(compact('preferences'));
	}

	/**
	 * Update a user's preferences
	 *
	 * @param Preference $request
	 *
	 * @return mixed
	 */
	public function postPreferences(Preference $request)
	{
		// Loop through the provided preferences and update them
		foreach ($request->get('preference') as $keyName => $value) {
			$this->userRepo->updatePreferenceByKeyName($keyName, $value);
		}

		return $this->ajax->setStatus('success')->sendResponse();
	}

	/**
	 * Allow a user to change their avatar preference
	 */
	public function getAvatar()
	{
		// Get the avatar preference for the user and the available options
		list($avatarPreference, $preferenceArray) = $this->userRepo->getPreferenceWithArray('AVATAR');

		$this->setViewData(compact('avatarPreference', 'preferenceArray'));
	}

	/**
	 * Update a user's avatar preference
	 *
	 * @param Avatar $request
	 *
	 * @return mixed
	 */
	public function postAvatar(Avatar $request)
	{
		// Update the avatar preference
		$this->userRepo->setPreferenceValue($request->get('avatar_preference_id'), $request->get('avatar_preference'));

		return $this->ajax->setStatus('success')->sendResponse();
	}

	/**
	 * Upload a new avatar for a user
	 *
	 * @param UploadAvatar $request
	 *
	 * @return mixed
	 */
	public function postUploadAvatar(UploadAvatar $request)
	{
		// Set avatar
		$image       = $this->user->uploadAvatar($request->file('avatar'), $this->activeUser->username);
		$imageErrors = $image->getErrors();

		// Redirect with errors if there were any
		if (count($imageErrors) > 0) {
			return $this->redirect('/user/account#upload-avatar', $imageErrors, 'errors');
		}

		return $this->redirect('/user/account#upload-avatar', 'Avatar uploaded');
	}
}