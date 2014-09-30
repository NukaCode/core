<?php namespace NukaCode\Core\Controllers\Admin\Edit;

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
		$roles = $roleRepo->orderByName()->toSelectArray(false);

		$this->setViewData(compact('user', 'roles'));
	}

	// @todo Add request form
	public function postIndex($id)
	{
		// Update the user
		$this->userRepo->findFirst($this->input->only('id'));
		$this->userRepo->update($this->input->except('roles'));
		$this->userRepo->setRoles($this->input->get('roles'));

		// Send the response
		return $this->ajax->sendResponse();
	}

} 