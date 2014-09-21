<?php namespace NukaCode\Core\Remote;

use Illuminate\Support\Facades\App;
use NukaCode\Core\Exceptions\SSH\NoCommandsProvided;

class SSH {

    private $ssh;

    public function runCommands(array $commands)
    {
        if (count($commands) > 0) {
            $commands = implode(';', $commands);

            passthru($commands);
        } else {
            throw new NoCommandsProvided();
        }
    }
} 