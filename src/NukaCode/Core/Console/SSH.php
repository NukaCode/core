<?php namespace NukaCode\Core\Console;

use Illuminate\Remote\RemoteManager;
use NukaCode\Core\Exceptions\SSH\NoCommandsProvided;

class SSH {

    private $ssh;

    public function __construct(RemoteManager $ssh)
    {
        $this->ssh = $ssh;
    }

    public function runCommands(array $commands)
    {
        if (count($commands) > 0) {
            $commands = implode(';', $commands);

            passthru($commands);
        } else {
            throw new NoCommandsProvided();
        }
    }

    public function runCommandsSshFacade(array $commands)
    {
        if (count($commands) > 0) {
            $this->ssh->run($commands);
        } else {
            throw new NoCommandsProvided();
        }
    }
} 