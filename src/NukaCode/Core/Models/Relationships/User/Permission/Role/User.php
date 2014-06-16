<?php namespace NukaCode\Core\Models\Relationships\User\Permission\Role;


trait User {

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    public function role()
    {
        return $this->belongsTo('User_Permission_Role', 'role_id');
    }
}