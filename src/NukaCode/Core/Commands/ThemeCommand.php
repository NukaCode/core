<?php namespace NukaCode\Core\Commands;

use Illuminate\Config\Repository;
use Illuminate\Console\Command;
use NukaCode\Core\Console\SSH;

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

    /**
     * The output stream for any artisan commands
     *
     * @var string
     */
    protected $stream;

    /**
     * The ssh commands instance to run against
     *
     * @var string
     */
    protected $ssh;

    /**
     * The config repo
     *
     * @var Repository
     */
    protected $config;

    /**
     * Create a new command instance.
     */
    public function __construct(SSH $ssh, Repository $config)
    {
        parent::__construct();

        $this->ssh    = $ssh;
        $this->config = $config;
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

        $theme    = $this->config->get('core::theme.style');
        $location = $this->config->get('core::theme.src');

        $this->ssh->generateTheme($theme, $location);

        $this->comment('Finished creating theme.');
    }

}
