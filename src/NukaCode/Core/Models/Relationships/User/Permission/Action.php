<?php namespace NukaCode\Core\Models\Relationships\User\Permission;

trait Action {

    public function roles()
    {
        return $this->belongsToMany('User_Permission_Role', 'action_roles', 'action_id', 'role_id');
    }
} 