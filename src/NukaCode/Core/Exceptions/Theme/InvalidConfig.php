<?php namespace NukaCode\Core\Exceptions\Theme;

class InvalidConfig extends \Exception {

    public function __construct($location)
    {
        parent::__construct('Unrecognized src [' . $location . '] provided in app config.', null, null);
    }
}