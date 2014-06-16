<?php namespace NukaCode\Core\Models\Relationships\User\Permission\Action;

trait Role {

    public function action()
    {
        return $this->belongsTo('User_Permission_Action', 'action_id');
    }

    public function role()
    {
        return $this->belongsTo('User_Permission_Role', 'role_id');
    }
} 