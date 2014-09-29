<?php namespace NukaCode\Core\Models\User\Permission;

use NukaCode\Core\Models\Relationships\User\Permission\Role as RoleRelationshipsTrait;

class Role extends \BaseModel {
    /********************************************************************
     * Traits
     *******************************************************************/
    use RoleRelationshipsTrait;

    /********************************************************************
     * Declarations
     *******************************************************************/
    protected $table     = 'roles';

    protected $presenter = 'NukaCode\Core\Presenters\User\Permission\RolePresenter';

    /********************************************************************
     * Validation rules
     *******************************************************************/

    /********************************************************************
     * Scopes
     *******************************************************************/
    public function scopeOrderByPriority($query)
    {
        return $query->orderBy('group', 'asc')->orderBy('priority', 'asc');
    }

    /********************************************************************
     * Model Events
     *******************************************************************/

    /********************************************************************
     * Getter and Setter methods
     *******************************************************************/
	public function getFullNameAttribute()
	{
		return $this->group .' '. $this->name;
	}

    /********************************************************************
     * Extra Methods
     *******************************************************************/

}