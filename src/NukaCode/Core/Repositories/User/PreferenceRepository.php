<?php namespace NukaCode\Core\Repositories\User;

use NukaCode\Core\Models\User\Preference;
use NukaCode\Core\Repositories\Contracts\PreferenceRepositoryInterface;
use NukaCode\Core\Repositories\CoreRepository;
use NukaCode\Core\Requests\Ajax;

class PreferenceRepository extends CoreRepository implements PreferenceRepositoryInterface {

    /**
     * @var \NukaCode\Core\Models\User\Preference
     */
    protected $preference;

    /**
     * @var Ajax
     */
    protected $ajax;

    public function __construct(Preference $preference, Ajax $ajax)
    {
        $this->model = $preference;
        $this->ajax  = $ajax;
    }

    public function set($preference)
    {
        if ($preference instanceof Preference) {
            $this->entity = $preference;
        } else {
            throw new \InvalidArgumentException('Invalid preference passed.');
        }
    }

    public function create($input)
    {
        $preference              = new Preference();
        $preference->name        = $input['name'];
        $preference->keyName     = $input['keyName'];
        $preference->description = $input['description'];
        $preference->value       = $input['value'];
        $preference->default     = $input['default'];
        $preference->display     = $input['display'];
        $preference->hiddenFlag  = $input['hiddenFlag'];

        $this->entity = $preference;

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
            $this->entity->value       = $this->arrayOrEntity('value', $input);
            $this->entity->default     = $this->arrayOrEntity('default', $input);
            $this->entity->display     = $this->arrayOrEntity('display', $input);
            $this->entity->hiddenFlag  = $this->arrayOrEntity('hiddenFlag', $input);

            $this->save();
        }
    }
} 