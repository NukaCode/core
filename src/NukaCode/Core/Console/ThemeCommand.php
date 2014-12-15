<?php namespace NukaCode\Core\Console;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use NukaCode\Core\Remote\SSH;
use NukaCode\Core\Remote\Theme;

class ThemeCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nuka:theme';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile your theme based on your configuration.';

    protected $stream;

    protected $ssh;

    protected $theme;

    protected $config;

    /**
     * Create a new command instance.
     */
    public function __construct(SSH $ssh, Repository $config, Theme $theme)
    {
        parent::__construct();

        $this->ssh    = $ssh;
        $this->config = $config;
        $this->theme  = $theme;
        $this->stream = fopen('php://output', 'w');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->comment('Creating your theme...');

        $theme    = $this->config->get('core::theme.theme.style');
        $location = $this->config->get('core::theme.theme.src');

        $commands = $this->theme->generateTheme($theme, $location);
        $this->ssh->runCommands($commands);

        $this->comment('Finished creating theme.');
    }

}
