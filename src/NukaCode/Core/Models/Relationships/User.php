<?php namespace NukaCode\Core\Models\Relationships;

trait User {

    public function roles()
    {
        return $this->belongsToMany('User_Permission_Role', 'role_users', 'user_id', 'role_id');
    }

    public function preferences()
    {
        return $this->belongsToMany('User_Preference', 'preferences_users', 'user_id', 'preference_id')
            ->withPivot('value')
            ->orderBy('id', 'asc');
    }
}