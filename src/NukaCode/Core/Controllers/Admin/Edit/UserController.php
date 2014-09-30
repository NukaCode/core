<?php namespace NukaCode\Core\Controllers\Admin\Edit;

use NukaCode\Core\Http\Requests\Admin\Edit\User;
use NukaCode\Core\Models\User\Permission\Role;
use NukaCode\Core\Repositories\Contracts\RoleRepositoryInterface;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;
use NukaCode\Core\Requests\Ajax;

class UserController extends \BaseController {

	/**
	 * @var UserRepositoryInterface
	 */
	private $userRepo;

	/**
	 * @var Ajax
	 */
	private $ajax;

	public function __construct(UserRepositoryInterface $userRepo, Ajax $ajax)
	{
		parent::__construct();

		$this->userRepo = $userRepo;
		$this->ajax     = $ajax;
	}

	public function getIndex(RoleRepositoryInterface $roleRepo, $id)
	{
		$user  = $this->userRepo->find($id);
		$roles = $roleRepo->orderByName()->toSelectArray(false, 'id', 'fullName');

		$this->setViewData(compact('user', 'roles'));
	}

	public function postIndex(User $request, $id)
	{
		// Update the user
		$this->userRepo->findFirst($request->only('id'));
		$this->userRepo->update($request->except('roles'));
		$this->userRepo->setRoles($request->get('roles'));

		// Send the response
		return $this->ajax->sendResponse();
	}

} 