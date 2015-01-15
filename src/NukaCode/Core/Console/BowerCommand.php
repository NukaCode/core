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

	/**
	 * All directories for the nuka code packages.
	 *
	 * @var array
	 */
	protected $nukaDirectories;

	/**
	 * Laravel filesystem
	 *
	 * @var Filesystem
	 */
	protected $file;

	/**
	 * Create a new command instance.
	 *
	 * @param Filesystem $file
	 */
	public function __construct(Filesystem $file)
	{
		parent::__construct();

		// Set up the variables
		$this->file            = $file;
		$this->nukaDirectories = $this->file->directories(base_path('vendor/nukacode'));
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// Loop through each nuka code package directory
		foreach ($this->nukaDirectories as $nukaDirectory) {
			// Get the package name for display purposes
			$package = explode('/', $nukaDirectory);
			$package = end($package);

			$this->comment('Checking ' . $package . '...');

			// Check for a bower file
			if ($this->file->exists($nukaDirectory . '/bower.json')) {
				$this->info('bower.json found.  Running bower install -f ...');

				// Move to that directory and run bower install
				$commands = 'cd ' . $nukaDirectory . '; bower install -f 2> /dev/null';

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
