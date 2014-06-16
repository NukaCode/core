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

    private $user;

    private $leftTab;

    /**
     * @var \Illuminate\Http\Request
     */
    private $input;

    /**
     * @var \NukaCode\Core\Requests\Ajax
     */
    private $ajax;

    /**
     * @var \Illuminate\Routing\Redirector
     */
    private $redirect;

    /**
     * @var \NukaCode\Core\Repositories\User\Permission\Role
     */
    private $role;

    /**
     * @var \NukaCode\Core\Servicing\Crud
     */
    private $crud;

    public function __construct(UserRepositoryInterface $user, Role $role, LeftTab $leftTab, Ajax $ajax, Request $input, Redirector $redirect, Crud $crud)
    {
        parent::__construct();
        $this->user     = $user;
        $this->leftTab  = $leftTab;
        $this->input    = $input;
        $this->ajax     = $ajax;
        $this->redirect = $redirect;
        $this->role     = $role;
        $this->crud     = $crud;
    }

    public function getIndex()
    {
        // Get the collapse values
        if (!Session::has('COLLAPSE_ADMIN_PERMISSIONS')) {
            Session::put('COLLAPSE_ADMIN_PERMISSIONS', $this->activeUser->getPreferenceValueByKeyName('COLLAPSE_ADMIN_PERMISSIONS'));
        }
        if (!Session::has('COLLAPSE_ADMIN_GENERAL')) {
            Session::put('COLLAPSE_ADMIN_GENERAL', $this->activeUser->getPreferenceValueByKeyName('COLLAPSE_ADMIN_GENERAL'));
        }

        $userManagementConfig = \Config::get('core::usermanagement.leftTab');
        $this->leftTab->parseConfig($userManagementConfig);
    }

    public function getList()
    {
        $this->user->crud();
    }

    public function postList()
    {
        $this->skipView();
        // Set the input data
        $input = e_array($this->input->all());

        if (isset($input['id']) && strlen($input['id']) == 10) {
            $this->user->find($input['id']);
            $this->user->update($input);
        } else {
            $this->user->create($input);
        }

        // Handle errors
        $this->ajax->addData('resource', $this->user->entity->toArray());

        // Send the response
        return $this->ajax->sendResponse();
    }

    public function getUserDelete($userId)
    {
        $this->skipView();

        $this->user->find($userId);
        $this->user->delete();

        return $this->redirect->to('admin/users')->with('message', 'User deleted');
    }

    public function getResetpassword($userId)
    {
        $newPassword    = Str::random(15, 'all');
        $user           = User::find($userId);
        $user->password = $newPassword;
        $user->save();

        // Email them the new password
        $mailer = IoC::resolve('phpmailer');
        $mailer->AddAddress($user->email, $user->username);
        $mailer->Subject = 'Password reset';
        $mailer->Body    = 'Your password has been reset for StygianVault.  Your new password is  ' . $newPassword . '.  Once you log in, go to your profile to change this.';
        $mailer->Send();

        return Redirect::back();
    }

    public function getActions()
    {
        $actions = User_Permission_Action::orderBy('name', 'asc')->get();

        // Set up the one page crud
        $this->crud->setTitle('Actions')
                   ->setSortProperty('name')
                   ->setDeleteLink('/admin/actiondelete/')
                   ->setDeleteProperty('id')
                   ->setResources($actions);

        // Add the display columns
        $this->crud->addDisplayField('name')
                   ->addDisplayField('keyName');

        // Add the form fields
        $this->crud->addFormField('name', 'text')
                   ->addFormField('keyName', 'text')
                   ->addFormField('description', 'textarea');

        // Handle the view data
        $this->crud->make();
    }

    public function postActions()
    {
        $this->skipView();
        // Set the input data
        $input = e_array(Input::all());

        if ($input != null) {
            // Get the object
            $action              = (isset($input['id']) && $input['id'] != null ? User_Permission_Action::find($input['id']) : new User_Permission_Action);
            $action->name        = $input['name'];
            $action->keyName     = $input['keyName'];
            $action->description = $input['description'];

            // Attempt to save the object
            $this->save($action);

            // Handle errors
            if ($this->errorCount() > 0) {
                Ajax::addErrors($this->getErrors());
            } else {
                Ajax::setStatus('success')->addData('resource', $action->toArray());
            }

            // Send the response
            return Ajax::sendResponse();
        }
    }

    public function getActiondelete($actionId)
    {
        $this->skipView();

        $action = User_Permission_Action::find($actionId);
        $action->roles()->detach();
        $action->delete();

        return Redirect::to('/admin#actions');
    }

    public function getRoles()
    {
        $roles = User_Permission_Role::orderBy('group', 'asc')->orderBy('priority', 'asc')->get();

        // Set up the one page crud
        $this->crud->setTitle('Roles')
                   ->setSortProperty('name')
                   ->setDeleteLink('/admin/roledelete/')
                   ->setDeleteProperty('id')
                   ->setResources($roles);

        // Add the display columns
        $this->crud->addDisplayField('group')
                   ->addDisplayField('name')
                   ->addDisplayField('keyName')
                   ->addDisplayField('priority');

        // Add the form fields
        $this->crud->addFormField('group', 'text', null, true)
                   ->addFormField('name', 'text', null, true)
                   ->addFormField('keyName', 'text', null, true)
                   ->addFormField('description', 'textarea')
                   ->addFormField('priority', 'text');

        // Handle the view data
        $this->crud->make();
    }

    public function postRoles()
    {
        $this->skipView();
        // Set the input data
        $input = e_array(Input::all());

        if ($input != null) {
            // Get the object
            $role              = (isset($input['id']) && $input['id'] != null ? User_Permission_Role::find($input['id']) : new User_Permission_Role);
            $role->group       = $input['group'];
            $role->name        = $input['name'];
            $role->keyName     = $input['keyName'];
            $role->description = $input['description'];
            $role->priority    = $input['priority'];

            // Attempt to save the object
            $this->save($role);

            // Handle errors
            if ($this->errorCount() > 0) {
                Ajax::addErrors($this->getErrors());
            } else {
                Ajax::setStatus('success')->addData('resource', $role->toArray());
            }

            // Send the response
            return Ajax::sendResponse();
        }
    }

    public function getRoledelete($roleId)
    {
        $this->skipView();

        $role = User_Permission_Role::find($roleId);
        $role->actions()->detach();
        $role->users()->detach();
        $role->delete();

        return Redirect::to('/admin#roles');
    }

    public function getRoleUsers()
    {
        $users = $this->user->orderByName();
        $roles = $this->role->orderByName();

        $usersArray = $users->toSelectArray('Select a user', 'id', 'username');
        $rolesArray = $roles->toSelectArray('None');

        $this->crud
            ->setTitle('Role Users')
            ->setSortProperty('username')
            // ->setPaginationFlag(true)
            ->setUpMultiColumn()
                ->addRootColumn('Users', $users, 'username', 'user_id', $usersArray)
                ->addMultiColumn('Roles', 'roles', 'name', 'role_id', $rolesArray)
                ->finish()
            ->make();
    }

    public function postRoleUsers()
    {
        $this->skipView();

        // Set the input data
        $input = e_array($this->input->all());

        if ($input != null) {
            // Remove all existing roles
            $roleUsers = User_Permission_Role_User::where('user_id', $input['user_id'])->get();

            if ($roleUsers->count() > 0) {
                foreach ($roleUsers as $roleUser) {
                    $roleUser->delete();
                }
            }

            // Add any new roles
            if (count($input['role_id']) > 0) {
                foreach ($input['role_id'] as $roleId) {
                    if ($roleId == '0') {
                        continue;
                    }

                    $roleUser          = new User_Permission_Role_User;
                    $roleUser->user_id = $input['user_id'];
                    $roleUser->role_id = $roleId;

                    $this->save($roleUser);
                }
            }

            // Handle errors
            if ($this->errorCount() > 0) {
                Ajax::addErrors($this->getErrors());
            } else {
                $user = User::find($input['user_id']);

                $main          = $user->toArray();
                $main['multi'] = $user->roles->id->toJson();

                Ajax::setStatus('success')
                    ->addData('resource', $user->roles->toArray())
                    ->addData('main', $main);
            }

            // Send the response
            return $this->ajax->sendResponse();
        }
    }

    public function getActionRoles()
    {
        $roles   = User_Permission_Role::orderByNameAsc()->get();
        $actions = User_Permission_Action::orderByNameAsc()->get();

        $rolesArray   = $roles->toSelectArray('Select a role');
        $actionsArray = $actions->toSelectArray('None');

        // Set up the one page crud
        $this->crud->setTitle('Action Roles')
                   ->setSortProperty('name')
                   ->setUpMultiColumn()
                   ->addRootColumn('Roles', $roles, 'name', 'role_id', $rolesArray)
                   ->addMultiColumn('Actions', 'actions', 'name', 'action_id', $actionsArray)
                   ->finish()
                   ->make();
    }

    public function postActionRoles()
    {
        $this->skipView();

        // Set the input data
        $input = e_array(Input::all());

        if ($input != null) {
            // Remove all existing roles
            $actionRoles = User_Permission_Action_Role::where('role_id', $input['role_id'])->get();

            if ($actionRoles->count() > 0) {
                foreach ($actionRoles as $actionRole) {
                    $actionRole->delete();
                }
            }

            // Add any new roles
            if (count($input['action_id']) > 0) {
                foreach ($input['action_id'] as $actionId) {
                    if ($actionId == '0') {
                        continue;
                    }

                    $actionRole            = new User_Permission_Action_Role;
                    $actionRole->role_id   = $input['role_id'];
                    $actionRole->action_id = $actionId;

                    $this->save($actionRole);
                }
            }

            // Handle errors
            if ($this->errorCount() > 0) {
                Ajax::addErrors($this->getErrors());
            } else {
                $role = User_Permission_Role::find($input['role_id']);

                $main          = $role->toArray();
                $main['multi'] = $role->actions->id->toJson();

                Ajax::setStatus('success')
                    ->addData('resource', $role->actions->toArray())
                    ->addData('main', $main);
            }

            // Send the response
            return Ajax::sendResponse();
        }
    }

    public function getUserPreferences()
    {
        $preferences = User_Preference::orderBy('hiddenFlag', 'asc')->orderByNameAsc()->get();

        // Set up the one page crud main details

        $this->crud->setTitle('User Preferences')
                   ->setSortProperty('name')
                   ->setDeleteLink('/admin/preferencedelete/')
                   ->setDeleteProperty('id')
                   ->setResources($preferences);

        // Add the display columns
        $this->crud->addDisplayField('name')
                   ->addDisplayField('value')
                   ->addDisplayField('default')
                   ->addDisplayField('hidden');

        // Add the form fields
        $this->crud->addFormField('name', 'text')
                   ->addFormField('keyName', 'text')
                   ->addFormField('value', 'text')
                   ->addFormField('default', 'text')
                   ->addFormField('display', 'select', array(null => 'Select a type', 'text' => 'Text', 'textarea' => 'Textarea', 'select' => 'Select', 'radio' => 'Radio'))
                   ->addFormField('description', 'textarea')
                   ->addFormField('hiddenFlag', 'select', array('Not Hidden', 'Hidden'));

        // Handle the view data
        $this->crud->make();
    }

    public function postUserPreferences()
    {
        $this->skipView();

        // Set the input data
        $input = e_array(Input::all());

        if ($input != null) {
            // Get the object
            $preference              = (isset($input['id']) && $input['id'] != null ? User_Preference::find($input['id']) : new User_Preference);
            $preference->name        = $input['name'];
            $preference->keyName     = $input['keyName'];
            $preference->description = $input['description'];
            $preference->value       = $input['value'];
            $preference->default     = $input['default'];
            $preference->display     = $input['display'];
            $preference->hiddenFlag  = $input['hiddenFlag'];

            // Attempt to save the object
            $this->save($preference);

            // Handle errors
            if ($this->errorCount() > 0) {
                Ajax::addErrors($this->getErrors());
            } else {
                Ajax::setStatus('success')->addData('resource', $preference->toArray());
            }

            // Send the response
            return Ajax::sendResponse();
        }
    }

    public function getPreferencedelete($preferenceId)
    {
        $this->skipView();

        $preference = User_Preference::find($preferenceId);
        $preference->delete();

        return Redirect::to('/admin#preferences');
    }
}
