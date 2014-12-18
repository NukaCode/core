<?php namespace NukaCode\Core\Console;

use Illuminate\Console\Command;
use NukaCode\Core\Filesystem\Config\Package;

class VersionCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nuka:version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update your app\'s version information for Nuka Code packages.';

    private $package;

    public function __construct(Package $package)
    {
        parent::__construct();

        $this->package = $package;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->package->updateEntries();
		$this->package->runAdminConfigs();
    }
} 