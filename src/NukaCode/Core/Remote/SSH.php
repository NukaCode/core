<?php

namespace NukaCode\Core\Remote;

use NukaCode\Core\Exceptions\SSH\NoCommandsProvided;

class SSH
{

    public function runCommands(array $commands)
    {
        if (count($commands) > 0) {
            chdir(base_path());

            $commands = implode('; ', $commands);

            passthru($commands, $err);

            if ($err != 0) {
                throw new \Exception('Ssh failed with code ' . $err . '.  Command: ' . $commands);
            }
        } else {
            throw new NoCommandsProvided();
        }
    }
}
