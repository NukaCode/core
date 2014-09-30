<?php namespace NukaCode\Core\Controllers\Admin;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use NukaCode\Core\Http\Requests\Admin\Theme;
use NukaCode\Core\Remote\SSH;
use NukaCode\Core\Remote\Theme as ConsoleTheme;
use NukaCode\Core\Filesystem\Config\Theme as ConfigTheme;
use NukaCode\Core\Filesystem\Less\Colors;
use NukaCode\Core\Requests\Ajax;

class SiteController extends \BaseController {

	/**
	 * @var \NukaCode\Core\Requests\Ajax
	 */
	private $ajax;

	/**
	 * @var \Illuminate\Config\Repository
	 */
	private $config;

	public function __construct(Ajax $ajax,
								Repository $config)
	{
		parent::__construct();

		$this->ajax        = $ajax;
		$this->config      = $config;
	}

	public function index()
	{
		$laravelVersion = Application::VERSION;
		$packages       = $this->config->get('packages.nukacode');

		$this->setViewData(compact('laravelVersion', 'packages'));
	}

	public function getTheme(Colors $colors)
	{
		$colors = $colors->getEntry();

		$availableThemes = $this->config->get('core::theme.themes');

		$this->setViewData(compact('colors', 'availableThemes'));
	}

	public function postTheme(Theme $request, ConsoleTheme $theme, ConfigTheme $configTheme, Colors $colors, SSH $ssh)
	{
		// Update the colors less file
		$colors->updateEntry($request->all());

		// Update the config file
		$configTheme->updateEntry($request->all());

		// Generate the new theme css file
		$commands = $theme->generateTheme($request->get('style'), $request->get('src'));
		$this->ssh->runCommands($commands);

		return $this->ajax->setStatus('success')->sendResponse();
	}
} 