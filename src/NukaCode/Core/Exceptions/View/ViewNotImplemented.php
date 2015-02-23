<?php namespace NukaCode\Core\Exceptions\View;

class ViewNotImplemented extends \Exception {

    public function __construct($location)
    {
        parent::__construct('The view [' . $location . '] has not been implemented.  Create it or use a package to provide it.', null, null);
    }
}