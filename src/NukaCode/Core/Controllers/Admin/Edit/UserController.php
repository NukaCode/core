<?php namespace NukaCode\Core\Controllers\Admin\Edit;

use NukaCode\Core\Models\User\Permission\Role;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;
use NukaCode\Core\Requests\Ajax;

class UserController extends \BaseController {

    /**
     * @var UserRepositoryInterface
     */
    private $user;

    /**
     * @var Ajax
     */
    private $ajax;

    public function __construct(UserRepositoryInterface $user, Ajax $ajax)
    {
        parent::__construct();
        $this->user = $user;
        $this->ajax = $ajax;
    }

    public function getIndex($id)
    {
        $user  = $this->user->find($id);
        $roles = Role::orderByNameAsc()->get()->toSelectArray(false);

        $this->setViewData('user', $user);
        $this->setViewData('roles', $roles);
    }

    public function postIndex($id)
    {
        // Update the user
        $this->user->findFirst($this->input->only('id'));
        $this->user->update($this->input->except('roles'));
        $this->user->setRoles($this->input->get('roles'));

        // Send the response
        return $this->ajax->sendResponse();
    }

} 