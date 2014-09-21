<?php namespace NukaCode\Core\Models\Relationships\User\Permission;

trait Role {

    public function actions()
    {
        return $this->belongsToMany('User_Permission_Action', 'action_roles', 'role_id', 'action_id');
    }

    public function users()
    {
        return $this->belongsToMany('User', 'role_users', 'role_id', 'user_id');
    }
} 