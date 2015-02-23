<?php namespace NukaCode\Core\Support\Facades\View;

use Illuminate\Support\Facades\Facade;

class ViewBuilder extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'viewcore'; }

}