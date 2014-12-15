<?php namespace NukaCode\Core\Console;

use Illuminate\Foundation\Console\AppNameCommand as LaravelAppNameCommand;

class AppNameCommand extends LaravelAppNameCommand {

	/**
	 * Set the application provider namespaces.
	 *
	 * @return void
	 */
	protected function setAppConfigNamespaces()
	{
		parent::setAppConfigNamespaces();

		$this->replaceIn(
			$this->getConfigPath('app'), $this->currentRoot.'\\Models\\', $this->argument('name').'\\Models\\'
		);

		$this->setRouteNamespace();
	}

	/**
	 * Update the namespace in the primary routes file.
	 */
	protected function setRouteNamespace()
	{
		$path = $this->laravel['path'].'/Http/routes.php';

		$this->replaceIn(
			$path, '\'namespace\' => \''.$this->currentRoot.'\\Http\\Controllers', '\'namespace\' => \''.$this->argument('name').'\\Http\\Controllers'
		);
	}

}
