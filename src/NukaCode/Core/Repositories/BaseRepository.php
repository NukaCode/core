<?php namespace NukaCode\Core\Repositories;

abstract class BaseRepository {

    public $model;

    public $entity;

    public $ajax = null;

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findFirst($id)
    {
        return $this->model->findOrFail($id)->first();
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
		$entity = $this->getEntity();

        if ($entity == null) {
            throw new \InvalidArgumentException('No model to save.');
        }

		if ($this->ajax != null && $this->ajax->errorCount() > 0) {
			return false;
		}

		$entity->save();

        if (! $entity) {
            if ($this->ajax != null) {
                // Messages from validation need to be easily readable.
                foreach ($entity->getErrors()->all() as $key => $message) {
                    $this->ajax->addError($key, $message);
                }
            }

            return $entity->getErrors()->all();
        } else {
            if ($this->ajax != null) {
                $this->ajax->setStatus('success');
            }
        }

		$this->entity = $entity;

        return true;
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
        if (method_exists($this->model, $name))
        {
            return call_user_func_array(array($this->model, $name), $arguments);
        }

        throw new \Exception('Method '. $name .' not found.');
    }
} 
