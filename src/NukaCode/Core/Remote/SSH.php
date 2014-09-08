<?php namespace NukaCode\Core\Remote;

use Illuminate\Remote\RemoteManager;
use Illuminate\Support\Facades\App;
use NukaCode\Core\Exceptions\SSH\NoCommandsProvided;

class SSH {

    private $ssh;

    public function __construct()
    {
        $this->ssh = App::make('Illuminate\Remote\RemoteManager');
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