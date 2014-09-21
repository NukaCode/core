<?php namespace NukaCode\Core\Repositories\User\Permission;

use NukaCode\Core\Models\User\Permission\Role as RoleModel;
use NukaCode\Core\Repositories\CoreRepository;

class Role extends CoreRepository {

    /**
     * @var \NukaCode\Core\Models\User\Permission\Role
     */
    private $role;

    public function __construct(RoleModel $role)
    {
        $this->model = $role;
    }
} 