<?php namespace NukaCode\Core\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

use NukaCode\Core\Repositories\User\Permission\Role;
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
        $roles       = \User_Permission_Role::orderByNameAsc()->paginate(10);
        $actions     = \User_Permission_Action::orderByNameAsc()->paginate(10);
        $preferences = \User_Preference::orderByNameAsc()->paginate(10);

        $this->setViewData('users', $users);
        $this->setViewData('roles', $roles);
        $this->setViewData('actions', $actions);
        $this->setViewData('preferences', $preferences);
    }

    public function getUserCustomize()
    {
        $users = \User::orderByNameAsc()->paginate(10);

        $this->setViewPath('admin.user.customize.user.table');
        $this->setViewData('users', $users);
    }

    public function getRoleCustomize()
    {
        $roles = \User_Permission_Role::orderByPriority()->paginate(10);

        $this->setViewPath('admin.user.customize.role.table');
        $this->setViewData('roles', $roles);
    }

    public function getActionCustomize()
    {
        $actions = \User_Permission_Action::orderByNameAsc()->paginate(10);

        $this->setViewPath('admin.user.customize.action.table');
        $this->setViewData('actions', $actions);
    }

    public function getPreferenceCustomize()
    {
        $preferences = \User_Preference::orderByNameAsc()->paginate(10);

        $this->setViewPath('admin.user.customize.preference.table');
        $this->setViewData('preferences', $preferences);
    }
}
