<?php namespace NukaCode\Core\Facades\View;

use Illuminate\Support\Facades\Facade;

class View extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'viewcore'; }

}