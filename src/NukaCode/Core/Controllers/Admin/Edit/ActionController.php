<?php namespace NukaCode\Core\Controllers\Admin\Edit;

use NukaCode\Core\Models\User\Permission\Role;
use NukaCode\Core\Repositories\Contracts\ActionRepositoryInterface;
use NukaCode\Core\Repositories\Contracts\RoleRepositoryInterface;
use NukaCode\Core\Requests\Ajax;

class ActionController extends \BaseController {

    /**
     * @var Ajax
     */
    private $ajax;

    /**
     * @var ActionRepositoryInterface
     */
    private $action;

    public function __construct(ActionRepositoryInterface $action, Ajax $ajax)
    {
        parent::__construct();
        $this->ajax   = $ajax;
        $this->action = $action;
    }

    public function getIndex(RoleRepositoryInterface $roleRepo, $id)
    {
        $action = $this->action->find($id);
        $roles  = $roleRepo->orderByName()->toSelectArray(false, 'id', 'fullName');

        $this->setViewData(compact('action', 'roles'));
    }

	// @todo Add request form
    public function postIndex($id)
    {
        // Update the user
        $this->action->findFirst($this->input->only('id'));
        $this->action->update($this->input->except('roles'));
        $this->action->setRoles($this->input->get('roles'));

        // Send the response
        return $this->ajax->sendResponse();
    }

} 