<?php namespace NukaCode\Core\Console;

use Illuminate\Console\Command;
use NukaCode\Core\Database\Migrating;

class ReseedRolesCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nuka:reseed-roles';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Reseed the roles table.';

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
		$this->migrating->reseedRoles();
	}

} 