<?php namespace NukaCode\Core\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class BowerCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nuka:bower';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install bower components for packages.';

	protected $stream;

	protected $nukaDirectories;

	protected $file;

	/**
	 * Create a new command instance.
	 *
	 * @param Filesystem $file
	 *
	 * @return mixed
	 */
	public function __construct(Filesystem $file)
	{
		parent::__construct();

		// Set up the variables
		$this->file               = $file;
		$this->stream             = fopen('php://output', 'w');
		$this->nukaDirectories    = $this->file->directories(base_path('vendor/nukacode'));
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		foreach ($this->nukaDirectories as $nukaDirectory) {
			$package = explode('/', $nukaDirectory);
			$package = end($package);

			$this->comment('Checking '. $package .'...');
			if ($this->file->exists($nukaDirectory .'/bower.json')) {
				$this->info('bower.json found.  Running bower install -f ...');

				$commands = 'cd '. $nukaDirectory .'; bower install -f 2> /dev/null';

				if ($this->option('silent')) {
					exec($commands);
				} else {
					passthru($commands);
				}

				$this->info('Bower has finished installing.');
			}
		}
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('silent', 's', InputOption::VALUE_NONE, 'Whether to see output', null),
		);
	}

}
