<?php namespace NukaCode\Core\Exceptions\Theme;


class NoCommandsProvided extends \Exception {

    public function __construct()
    {
        parent::__construct('No commands provided for SSH.', null, null);
    }
}