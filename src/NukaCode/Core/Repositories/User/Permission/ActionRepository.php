<?php namespace NukaCode\Core\Repositories\User\Permission;

use NukaCode\Core\Models\User\Permission\Action;
use NukaCode\Core\Repositories\Contracts\ActionRepositoryInterface;
use NukaCode\Core\Repositories\CoreRepository;
use NukaCode\Core\Requests\Ajax;

class ActionRepository extends CoreRepository implements ActionRepositoryInterface {

    /**
     * @var \NukaCode\Core\Models\User\Permission\Action
     */
    protected $action;

    /**
     * @var Ajax
     */
    protected $ajax;

    public function __construct(Action $action, Ajax $ajax)
    {
        $this->model = $action;
        $this->ajax  = $ajax;
    }

    public function set($action)
    {
        if ($action instanceof Action) {
            $this->entity = $action;
        } else {
            throw new \InvalidArgumentException('Invalid action passed.');
        }
    }

    public function create($input)
    {
        $action              = new Action();
        $action->name        = $input['name'];
        $action->keyName     = $input['keyName'];
        $action->description = $input['description'];

        $this->entity = $action;

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
            $this->entity->name        = $this->arrayOrEntity('name', $input);
            $this->entity->keyName     = $this->arrayOrEntity('keyName', $input);
            $this->entity->description = $this->arrayOrEntity('description', $input);

            $this->save();
        }
    }

    public function setRoles($roleIds = array())
    {
        $this->checkEntity();
        $this->requireSingle();

        try {
            $this->entity->roles()->detach();

            if (count($roleIds) > 0) {
                $this->entity->roles()->attach($roleIds);
            }

            $this->save();
        } catch (\Exception $e) {
            $this->ajax->setStatus('error');
            $this->ajax->addError('roles', $e->getMessage());

            return false;
        }
    }
} 