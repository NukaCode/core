<?php namespace NukaCode\Core\Models\Relationships\User;

trait Preference {

    public function users()
    {
        return $this->belongsToMany('User', 'preference_users', 'user_id', 'preference_id');
    }
} 