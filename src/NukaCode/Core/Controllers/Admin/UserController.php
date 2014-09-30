<?php namespace NukaCode\Core\Controllers\Admin;

use NukaCode\Core\Repositories\Contracts\ActionRepositoryInterface;
use NukaCode\Core\Repositories\Contracts\PreferenceRepositoryInterface;
use NukaCode\Core\Repositories\Contracts\RoleRepositoryInterface;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;
use Session;


class UserController extends \BaseController {

	/**
	 * @var UserRepositoryInterface
	 */
	private $userRepo;

	/**
	 * @var RoleRepositoryInterface
	 */
	private $roleRepo;

	/**
	 * @var ActionRepositoryInterface
	 */
	private $actionRepo;

	/**
	 * @var PreferenceRepositoryInterface
	 */
	private $preferenceRepo;

	/**
	 * @param UserRepositoryInterface       $userRepo
	 * @param RoleRepositoryInterface       $roleRepo
	 * @param ActionRepositoryInterface     $actionRepo
	 * @param PreferenceRepositoryInterface $preferenceRepo
	 */
	public function __construct(UserRepositoryInterface $userRepo, RoleRepositoryInterface $roleRepo,
								ActionRepositoryInterface $actionRepo, PreferenceRepositoryInterface $preferenceRepo)
	{
		parent::__construct();

		$this->userRepo       = $userRepo;
		$this->roleRepo       = $roleRepo;
		$this->actionRepo     = $actionRepo;
		$this->preferenceRepo = $preferenceRepo;
	}

	public function index()
	{
		$userCount       = $this->userRepo->model->count();
		$roleCount       = $this->roleRepo->model->count();
		$actionCount     = $this->actionRepo->model->count();
		$preferenceCount = $this->preferenceRepo->model->count();

		$users       = $this->userRepo->paginate(10);
		$roles       = $this->roleRepo->paginate(10);
		$actions     = $this->actionRepo->paginate(10);
		$preferences = $this->preferenceRepo->paginate(10);

		$this->setViewData(compact('userCount', 'roleCount', 'actionCount', 'preferenceCount', 'users', 'roles', 'actions', 'preferences'));
	}

	public function userCustomize()
	{
		$users = $this->userRepo->paginate(10);

		$this->setViewPath('admin.user.customize.user.table');
		$this->setViewData(compact('users'));
	}

	public function roleCustomize()
	{
		$roles = $this->roleRepo->paginate(10);

		$this->setViewPath('admin.user.customize.role.table');
		$this->setViewData(compact('roles'));
	}

	public function actionCustomize()
	{
		$actions = $this->actionRepo->paginate(10);

		$this->setViewPath('admin.user.customize.action.table');
		$this->setViewData(compact('actions'));
	}

	public function preferenceCustomize()
	{
		$preferences = $this->preferenceRepo->paginate(10);

		$this->setViewPath('admin.user.customize.preference.table');
		$this->setViewData(compact('preferences'));
	}
}
