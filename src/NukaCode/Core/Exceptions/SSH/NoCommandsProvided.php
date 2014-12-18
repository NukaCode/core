<?php namespace NukaCode\Core\Exceptions\SSH;


class NoCommandsProvided extends \Exception {

    public function __construct()
    {
        parent::__construct('No commands provided for SSH.', null, null);
    }
}