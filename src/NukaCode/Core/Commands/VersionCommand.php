<?php namespace NukaCode\Core\Commands;

use Illuminate\Console\Command;
use NukaCode\Core\Filesystem\Config\Package;

class VersionCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nuka:core-version';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update your app\'s version information for core';

    public $packageName = 'core';

    public $version     = '1.0.1';

    public $color       = 'inverse';

    public $icon        = 'fa-cogs';

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
        $this->package->updateEntry($this);
    }
} 