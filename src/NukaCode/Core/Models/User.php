<?php namespace NukaCode\Core\Models;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Auth;
use Illuminate\Support\Facades\Hash;
use NukaCode\Core\Models\Relationships\User as UserRelationshipsTrait;
use Str;
use Session;

abstract class User extends BaseModel {
    /********************************************************************
     * Traits
     *******************************************************************/
    use UserRelationshipsTrait;

    /********************************************************************
     * Declarations
     *******************************************************************/
    protected        $presenter = 'NukaCode\Core\Presenters\UserPresenter';

    protected static $observer  = 'NukaCode\Core\Models\Observers\UserObserver';

    /**
     * Tell eloquent to set deleted_at as carbon
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Define the SQL table for this model
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Set the primary key since this table does not use id
     *
     * @var string
     */
    protected $primaryKey = 'uniqueId';

    /**
     * Tell eloquent to not attempt auto incrementing the ID column
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /********************************************************************
     * Scopes
     *******************************************************************/

    /**
     * Order by name ascending scope
     *
     * @param array $query The current query to append to
     */
    public function scopeOrderByNameAsc($query)
    {
        return $query->orderBy('username', 'asc');
    }

    /**
     * Visible user scope
     *
     * @param array $query The current query to append to
     */
    public function scopeVisible($query)
    {
        return $query->where('hiddenFlag', 0);
    }

    /********************************************************************
     * Model Events
     *******************************************************************/

    /********************************************************************
     * Setter methods
     *******************************************************************/

    /**
     * Make sure to hash the user's password on save
     *
     * @param string $value The value of the attribute (Auto Set)
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Actions of the user through the Role Relationship
     *
     * @return Action[]
     */
    public function getActionsAttribute()
    {
        return $this->roles->actions;
    }

    /********************************************************************
     * Extra Methods
     *******************************************************************/
    public function verifyPassword($input)
    {
        // Verify all the needed data exists and is correct
        if (! Hash::check($input['password'], $this->password)) {
            throw new \Exception('Please enter your current password');
        }

        return true;
    }

    public function getPreferenceValueByKeyName($preferenceKeyName)
    {
        $preference = \User_Preference::where('keyName', $preferenceKeyName)->first();

        if ($preference != null) {
            $userPreference = \User_Preference_User::where('preference_id', $preference->id)->where('user_id', $this->id)->first();

            if ($userPreference == null) {
                return $preference->default;
            }

            return $userPreference->value;
        }
    }

    public function getPreferenceByKeyName($preferenceKeyName)
    {
        $preference = \User_Preference::where('keyName', $preferenceKeyName)->first();

        if ($preference != null) {
            $userPreference = \User_Preference_User::where('preference_id', $preference->id)->where('user_id', $this->id)->first();

            if ($userPreference == null) {
                $userPreference                = new \User_Preference_User;
                $userPreference->user_id       = $this->id;
                $userPreference->preference_id = $preference->id;
                $userPreference->value         = $preference->default;
                $userPreference->save();
            }

            return $userPreference;
        }

        return null;
    }

    public function getPreferenceById($preferenceId)
    {
        return \User_Preference_User::find($preferenceId);
    }

    public function getPreferenceValue($keyName)
    {
        $preference = $this->getPreferenceByKeyName($keyName);

        return $preference->value;
    }

    public function getPreferenceOptionsArray($id)
    {
        $preference = $this->getPreferenceById($id);

        $preferenceOptions = explode('|', $preference->preference->value);
        $preferenceArray   = array();

        foreach ($preferenceOptions as $preferenceOption) {
            $preferenceArray[$preferenceOption] = ucwords($preferenceOption);
        }

        return $preferenceArray;
    }

    public function setPreferenceValue($id, $value)
    {
        $preference = $this->getPreferenceById($id);

        if ($value != $preference->value) {
            $preference->value = $value;

            if (! $preference->save() ) {
                throw new \Exception($preference->getErrors());
            }
        }
    }

    public function resetPreferenceToDefault($id)
    {
        $preference = $this->getPreferenceById($id);

        $preference->value = $preference->preference->default;
        $preference->save();

        return $this;
    }

    /**
     * Check if a user has a permission
     *
     * @param mixed   $actions  The key name(s) of the action you are checking.
     * @param boolean $matchAll Whether to match just one action or all actions.
     *
     * @return bool
     */
    public function checkPermission($actions, $matchAll = false)
    {
        if (Auth::user()->roles->contains(getRoleId('developer'))) {
            return true;
        }

        if (!is_array($actions)) {
            $actions = array($actions);
        }

        $matchedActions = 0;

        if ($this->actions && $this->actions->count() > 0) {
            $userActions = $this->actions->keyName->toArray();

            foreach ($actions as $action) {
                if (in_array($action, $userActions)) {
                    if (!$matchAll) {
                        return true;
                    }

                    $matchedActions++;
                }
            }

            if ($matchedActions) {
                if (count($actions) == $matchedActions) {
                    return true;
                }
            }
        }

        return false;
    }

    // old permission system

    /**
     * Get the first role for this user in a particular role group
     *
     * @param  string $group The group name of the role
     *
     * @return string
     */
    public function getFirstRole($group)
    {
        $roles   = Role::where('group', '=', $group)->get('id');
        $roleIds = array_pluck($roles, 'id');

        return Role_User::where('user_id', '=', $this->id)->whereIn('role_id', $roleIds)->first();
    }

    /**
     * Get the full object for the user's highest role in a particular role group
     *
     * @param  string $group The group name of the role
     *
     * @return Role
     */
    public function getHighestRoleObject($group)
    {
        // Get all user/role xrefs for this user
        $roles = $this->roles;

        // If the user does not have the developer role
        if (!$roles->contains(getRoleId('developer'))) {

            $roleIds = User_Permission_Role::where('group', '=', $group)->get()->id->toArray();
            // Make sure they have at least one role
            if (count($roleIds) > 0) {

                // Look for any role that matches the group that this user has and get the highest value
                $role = User_Permission_Role_User::whereIn('role_id', $roleIds)->where('user_id', $this->id)->first();

                // If it exists, return it
                if ($role != null) {
                    return $role->role;
                }
            }
        } else {
            // For a developer, return the highest role in the requested group
            return User_Permission_Role::where('group', $group)->orderBy('priority', 'desc')->first();
        }

        // Otherwise, they are a guest
        return User_Permission_Role::find(getRoleId('guest'));
    }

    /**
     * Get the user's highest role in a particular role group
     *
     * @param  string $group The group name of the role
     *
     * @return string
     */
    public function getHighestRole($group)
    {
        return $this->getHighestRoleObject($group)->name;
    }

    /**
     * Get roles that are higher than the user's in the specified group
     *
     * @param  string $group The group name of the role
     *
     * @return User_Permission_Role[]
     */
    public function getHigherRoles($group)
    {
        $currentRole = $this->getHighestRoleObject($group);

        if ($currentRole != null) {
            $higherRoles = User_Permission_Role::where('group', $group)->where('priority', '>', $currentRole->priority)->orderBy('priority', 'asc')->get();

            return $higherRoles;
        } else {
            return User_Permission_Role::where('group', $group)->orderBy('priority', 'asc')->get();
        }
    }

    /**
     * Update the user's role within a group
     *
     * @param  string $group  The group name of the role
     * @param  int    $roleId The id of the new role
     *
     * @return void
     */
    public function updateGroupRole($group, $roleId)
    {
        // Delete any roles the user has for this group
        $roleIdsForGroup = User_Permission_Role::where('group', $group)->get()->id->toArray();
        $existingRoles   = User_Permission_Role_User::where('user_id', $this->id)->whereIn('role_id', $roleIdsForGroup)->get();

        $existingRoles->delete();

        // Add the new role
        $this->addRole($roleId);
    }

    /**
     * Add a new role for the user
     *
     * @param  int $roleId The id of the new role
     *
     * @return void
     */
    public function addRole($roleId)
    {
        // Add the new role
        $this->roles()->attach($roleId);
    }

    /**
     * Update this user's last active time.  Used for determining if they are online
     */
    public function updateLastActive()
    {
        $this->lastActive = date('Y-m-d H:i:s');
        $this->save();
    }

    /**
     * Can the User do something
     *
     * @param  array|string $permissions Single permission or an array or permissions
     *
     * @return boolean
     */
    public function can($permissions)
    {
        // If the user is a developer, the answer is always true
        if ($this->is('DEVELOPER')) {
            return true;
        }

        if ($this->roles->count() > 0) {
            // If any permission is not in the user's permissions, fail
            return in_array($permissions, $this->roles->actions->keyName->toArray());
        }

        return false;
    }

    /**
     * Is the User a Role
     *
     * @param  array|string $roles A single role or an array of roles
     *
     * @return boolean
     */
    public function is($roles)
    {
        if ($this->roles->count() > 0) {
            // If any role is not in the user's roles, fail
            return in_array($roles, $this->roles->keyName->toArray());
        }

        return false;
    }

    /**
     * Is the User a Role (any true)
     *
     * @param  array|string $roles A single role or an array of roles
     *
     * @return boolean
     */
    public function isOr($roles)
    {
        if (Auth::check()) {
            // If any role is in the user's roles, pass
            return (bool)array_intersect((array)$roles, (array)Session::get('roles'));
        }

        return false;
    }
}
