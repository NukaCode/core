<?php namespace NukaCode\Core\Controllers\Admin\Edit;

use NukaCode\Core\Models\User\Permission\Role;
use NukaCode\Core\Models\User\Permission\Action;
use NukaCode\Core\Repositories\Contracts\RoleRepositoryInterface;
use NukaCode\Core\Requests\Ajax;

class RoleController extends \BaseController {

    /**
     * @var Ajax
     */
    private $ajax;

    /**
     * @var RoleRepositoryInterface
     */
    private $role;

    public function __construct(RoleRepositoryInterface $role, Ajax $ajax)
    {
        parent::__construct();
        $this->ajax = $ajax;
        $this->role = $role;
    }

    public function getIndex($id)
    {
        $role  = $this->role->find($id);
        $actions = Action::orderByNameAsc()->get()->toSelectArray(false);

        $this->setViewData('role', $role);
        $this->setViewData('actions', $actions);
    }

    public function postIndex($id)
    {
        // Update the user
        $this->role->findFirst($this->input->only('id'));
        $this->role->update($this->input->except('actions'));
        $this->role->setActions($this->input->get('actions'));

        // Send the response
        return $this->ajax->sendResponse();
    }

} 