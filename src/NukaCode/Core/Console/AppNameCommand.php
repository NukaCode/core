<?php namespace NukaCode\Core\Console;

use Illuminate\Foundation\Console\AppNameCommand as LaravelAppNameCommand;

class AppNameCommand extends LaravelAppNameCommand {
	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->setAppDirectoryNamespace();

		$this->replaceRouteNamespace();

		$this->setConfigNamespaces();

		$this->setComposerNamespace();

		$this->info('Application namespace set!');

		$this->composer->dumpAutoloads();
	}

	/**
	 * Set the application provider namespaces.
	 *
	 * @return void
	 */
	protected function setAppConfigNamespaces()
	{
		$this->replaceIn(
			$this->getConfigPath('app'), $this->root().'\\Providers', $this->argument('name').'\\Providers'
		);

		$this->replaceIn(
			$this->getConfigPath('app'), $this->root().'\\Http\\Controllers\\', $this->argument('name').'\\Http\\Controllers\\'
		);

		$this->replaceIn(
			$this->getConfigPath('app'), $this->root().'\\Models\\', $this->argument('name').'\\Models\\'
		);
	}

	/**
	 * Replace the App namespace at the given path.
	 *
	 * @param  string  $path;
	 */
	protected function replaceRouteNamespace()
	{
		$path = $this->laravel['path'].'/Http/routes.php';
		$this->replaceIn(
			$path, '\'namespace\' => \''.$this->root().'\\Http\\Controllers', '\'namespace\' => \''.$this->argument('name').'\\Http\\Controllers'
		);
	}

}
