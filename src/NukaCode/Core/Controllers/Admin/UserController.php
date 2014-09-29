<?php namespace NukaCode\Core\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

use NukaCode\Core\Repositories\User\Permission\Role;
use NukaCode\Core\Services\Crud;
use NukaCode\Core\Services\LeftTab;
use Session;
use User;
use User_Permission_Role;
use User_Permission_Role_User;
use User_Permission_Action;
use User_Permission_Action_Role;
use User_Preference;


class UserController extends \BaseController {

    public function index()
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

    public function userCustomize()
    {
        $users = \User::orderByNameAsc()->paginate(10);

        $this->setViewPath('admin.user.customize.user.table');
        $this->setViewData('users', $users);
    }

    public function roleCustomize()
    {
        $roles = \User_Permission_Role::orderByPriority()->paginate(10);

        $this->setViewPath('admin.user.customize.role.table');
        $this->setViewData('roles', $roles);
    }

    public function actionCustomize()
    {
        $actions = \User_Permission_Action::orderByNameAsc()->paginate(10);

        $this->setViewPath('admin.user.customize.action.table');
        $this->setViewData('actions', $actions);
    }

    public function preferenceCustomize()
    {
        $preferences = \User_Preference::orderByNameAsc()->paginate(10);

        $this->setViewPath('admin.user.customize.preference.table');
        $this->setViewData('preferences', $preferences);
    }
}
