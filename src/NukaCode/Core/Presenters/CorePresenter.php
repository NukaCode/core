<?php namespace NukaCode\Core\Presenters;

use Laracasts\Presenter\Presenter;

class CorePresenter extends Presenter {

	/**
	 * Make the last active date easier to read
	 *
	 * @return string
	 */
	public function createdAtReadable()
	{
		return $this->created_at->format('F jS, Y \a\t h:ia');
	}

	/**
	 * Strip slashes from any name
	 *
	 * @return string
	 */
	public function name()
	{
		return stripslashes($this->name);
	}

	public function hidden()
	{
		return $this->hiddenFlag == 1 ? 'Hidden' : null;
	}

	public function active()
	{
		return $this->hiddenFlag == 1 ? 'Hidden' : null;
	}

    /**
     * Allow for property-style retrieval
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if (method_exists($this, $property))
        {
            return $this->{$property}();
        }

        return $this->entity->{$property};
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
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