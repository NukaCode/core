<?php

namespace NukaCode\Core\Repositories;

abstract class BaseRepository
{

    public $model;

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findFirst($id)
    {
        return $this->model->firstOrFail($id);
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
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
        if (method_exists($this->model, $name)) {
            return call_user_func_array([$this->model, $name], $arguments);
        }

        throw new \Exception('Method ' . $name . ' not found.');
    }
}
