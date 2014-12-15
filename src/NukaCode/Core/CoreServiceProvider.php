<?php namespace NukaCode\Core;

use Config;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use NukaCode\Core\Console\AppNameCommand;
use NukaCode\Core\Database\Collection;

class CoreServiceProvider extends ServiceProvider {

	use AppNamespaceDetectorTrait;

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	const version = '2.0.0';

	const packageName = 'core';

	const color = 'inverse';

	const icon = 'fa-cogs';

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		//$this->package('nukacode/core');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->shareWithApp();
		$this->registerViews();
		$this->registerAliases();
		$this->registerArtisanCommands();
	}

	/**
	 * Share the package with application
	 *
	 * @return void
	 */
	protected function shareWithApp()
	{
		$this->app['core'] = $this->app->share(function ($app) {
			return true;
		});
	}

	/**
	 * Register views
	 *
	 * @return void
	 */
	protected function registerViews()
	{
		$this->app['view']->addLocation(__DIR__ . '/../../views');
	}

	/**
	 * Register aliases
	 *
	 * @return void
	 */
	protected function registerAliases()
	{
		$aliases = [
			// Facades
			'HTML'                        => 'NukaCode\Core\Support\Facades\Html\HTML',
			'bForm'                       => 'NukaCode\Core\Support\Facades\Html\bForm',
			'BBCode'                      => 'NukaCode\Core\Support\Facades\Html\BBCode',
			'ViewBuilder'                 => 'NukaCode\Core\Support\Facades\View\ViewBuilder',
			'Ajax'                        => 'NukaCode\Core\Support\Facades\Requests\Ajax',
			// Utilities
			'Utility_Collection'          => 'NukaCode\Core\Database\Collection',
			'Seed'                        => 'NukaCode\Core\Models\Seed',
			'Migration'                   => 'NukaCode\Core\Models\Migration',
		];

		$appAliases = Config::get('core::nonCoreAliases');
		$loader     = AliasLoader::getInstance();

		foreach ($aliases as $alias => $class) {
			if (! is_null($appAliases)) {
				if (! in_array($alias, $appAliases)) {
					$loader->alias($alias, $class);
				}
			} else {
				$loader->alias($alias, $class);
			}
		}


	}

	public function registerArtisanCommands()
	{
		$this->commands(
			[
				'NukaCode\Core\Console\AppNameCommand' => 'command.app.name',
				'NukaCode\Core\Console\VersionCommand',
				'NukaCode\Core\Console\ThemeCommand',
				//'NukaCode\Core\Console\DatabaseCommand',
			]
		);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}