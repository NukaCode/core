<?php namespace NukaCode\Core\Console;

use Illuminate\Console\Command;
use NukaCode\Core\Database\Migrating;
use Symfony\Component\Console\Input\InputOption;

class DatabaseCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nuka:database';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run the nuka code core migration and seeds.';

	protected $migrating;

	/**
	 * Create a new command instance.
	 *
	 * @param Migrating $migrating
	 *
	 * @return mixed
	 */
	public function __construct(Migrating $migrating)
	{
		parent::__construct();

		$this->migrating = $migrating;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$refreshFlag = $this->option('refresh');
		$seedFlag    = $this->option('seed');

		if ($refreshFlag) {
			$this->migrating->reset();
		}

		$this->migrating->migrate($seedFlag);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('refresh', 'r', InputOption::VALUE_NONE, 'This will rerun the migrations for your NukeCode packages.', null),
			array('seed', 's', InputOption::VALUE_NONE, 'Run the associated seeds for each package.', null),
		);
	}

}
