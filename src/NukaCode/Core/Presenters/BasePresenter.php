<?php

namespace NukaCode\Core\Presenters;

use Laracasts\Presenter\Presenter;

abstract class BasePresenter extends Presenter
{

    /**
     * Make the last active date easier to read
     *
     * @return string
     */
    public function createdAtReadable()
    {
        return $this->entity->created_at->format('F jS, Y \a\t h:ia');
    }

    /**
     * Strip slashes from any name
     *
     * @return string
     */
    public function name()
    {
        return stripslashes($this->entity->name);
    }

    public function hidden($hiddenField = 'hiddenFlag')
    {
        return $this->entity->{$hiddenField} == 1 ? 'Hidden' : null;
    }

    public function active($activeField = 'activeFlag')
    {
        return $this->entity->{$activeField} == 1 ? 'Active' : null;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @throws \Exception
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
        if (method_exists($this->entity, $name)) {
            return call_user_func_array([$this->entity, $name], $arguments);
        }

        throw new \Exception('Method ' . $name . ' not found.');
    }
}
