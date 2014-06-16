<?php namespace NukaCode\Core\Repositories;


abstract class CoreRepository {

    protected $model;

    protected $entity;

    public function find($id)
    {
        $this->entity = $this->model->find($id);
        return $this->entity;
    }

    public function orderByName()
    {
        return $this->model->orderByNameAsc()->get();
    }

    public function paginate($count)
    {
        return $this->model->orderByNameAsc()->paginate($count);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function save()
    {
        if ($this->entity == null) {
            throw new \InvalidArgumentException('No model to save.');
        }

        if (! $this->entity->save()) {
            // Messages from validation need to be easily readable.
            foreach ($this->entity->getErrors()->all() as $key => $message) {
                $this->ajax->addError($key, $message);
            }
        } else {
            $this->ajax->setStatus('success');
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name))
        {
            return call_user_func_array(array($this, $name), $arguments);
        }
        if (method_exists($this->entity, $name))
        {
            return call_user_func_array(array($this->entity, $name), $arguments);
        }

        throw new \Exception('Method '. $name .' not found.');
    }
} 