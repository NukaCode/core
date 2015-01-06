<?php namespace NukaCode\Core\Console;

use Illuminate\Console\Command;
use NukaCode\Core\Database\Migrating;
use Symfony\Component\Console\Input\InputOption;

class ReseedTableCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nuka:reseed-table';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Reseed the required table.';

	protected $migrating;

	/**
	 * Create a new command instance.
	 *
	 * @param Migrating $migrating
	 */
	public function __construct(Migrating $migrating)
	{
		$this->migrating = $migrating;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$databaseSeeder = $this->option('databaseSeeder');
		$this->migrating->setApplication($this->getApplication())->reseedTable($databaseSeeder);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['file', null, InputOption::VALUE_REQUIRED, 'The name of the seeder file.', null],
		];
	}

} 