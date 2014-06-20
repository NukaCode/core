<?php namespace NukaCode\Core\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use NukaCode\Core\Repositories\Contracts\UserRepositoryInterface;

use NukaCode\Core\Repositories\User\Permission\Role;
use NukaCode\Core\Requests\Ajax;
use NukaCode\Core\Servicing\Crud;
use NukaCode\Core\Servicing\LeftTab;
use Session;
use User;
use User_Permission_Role;
use User_Permission_Role_User;
use User_Permission_Action;
use User_Permission_Action_Role;
use User_Preference;


class UserController extends \BaseController {

    public function getIndex()
    {
        $users       = \User::orderByNameAsc()->paginate(10);
        $roles       = \User_Permission_Role::orderByNameAsc()->get();
        $actions     = \User_Permission_Action::orderByNameAsc()->get();
        $preferences = \User_Preference::orderByNameAsc()->get();

        $this->setViewData('users', $users);
        $this->setViewData('roles', $roles);
        $this->setViewData('actions', $actions);
        $this->setViewData('preferences', $preferences);
    }

    public function getUserEdit($id)
    {
        ppd(\User::find($id));
    }
}
