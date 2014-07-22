<?php namespace NukaCode\Core\Repositories\User\Permission;

use NukaCode\Core\Models\User\Permission\Role;
use NukaCode\Core\Repositories\Contracts\RoleRepositoryInterface;
use NukaCode\Core\Repositories\CoreRepository;
use NukaCode\Core\Requests\Ajax;

class RoleRepository extends CoreRepository implements RoleRepositoryInterface {

    /**
     * @var \NukaCode\Core\Models\User\Permission\Role
     */
    protected $role;

    /**
     * @var Ajax
     */
    protected $ajax;

    public function __construct(Role $role, Ajax $ajax)
    {
        $this->model = $role;
        $this->ajax  = $ajax;
    }

    public function set($role)
    {
        if ($role instanceof Role) {
            $this->entity = $role;
        } else {
            throw new \InvalidArgumentException('Invalid role passed.');
        }
    }

    public function create($input)
    {
        $role           = new Role;
        $role->group    = $input['group'];
        $role->name     = $input['name'];
        $role->keyName  = $input['keyName'];
        $role->priority = $input['priority'];

        $this->entity = $role;

        $result = $this->save();

        return $result;
    }

    /**
     * @param array $input
     */
    public function update($input)
    {
        $this->checkEntity();
        $this->requireSingle();

        $input = e_array($input);

        if ($input != null) {
            $this->entity->group    = $this->arrayOrEntity('group', $input);
            $this->entity->name     = $this->arrayOrEntity('name', $input);
            $this->entity->keyName  = $this->arrayOrEntity('keyName', $input);
            $this->entity->priority = $this->arrayOrEntity('priority', $input);

            $this->save();
        }
    }

    public function setActions($actionIds = array())
    {
        $this->checkEntity();
        $this->requireSingle();

        try {
            $this->entity->actions()->detach();

            if (count($actionIds) > 0) {
                $this->entity->actions()->attach($actionIds);
            }

            $this->save();
        } catch (\Exception $e) {
            $this->ajax->setStatus('error');
            $this->ajax->addError('actions', $e->getMessage());

            return false;
        }
    }
} 