<?php namespace NukaCode\Core\Commanding;


interface CommandHandler {

    /**
     * Handle the command
     *
     * @param $command
     *
     * @return mixed
     */
    public function handle($command);
} 