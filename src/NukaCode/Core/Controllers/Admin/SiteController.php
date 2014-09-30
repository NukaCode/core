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
     * @var \NukaCode\Core\Console\SSH
     */
    private $ssh;

    /**
     * @var \NukaCode\Core\Console\Theme
     */
    private $theme;

    /**
     * @var \NukaCode\Core\Filesystem\Config\Theme
     */
    private $configTheme;

    /**
     * @var \NukaCode\Core\Filesystem\Less\Colors
     */
    private $colors;

    /**
     * @var \NukaCode\Core\Requests\Ajax
     */
    private $ajax;

    /**
     * @var \Illuminate\Config\Repository
     */
    private $config;

    public function __construct(SSH $ssh, ConsoleTheme $theme, ConfigTheme $configTheme, Colors $colors, Ajax $ajax, Repository $config)
    {
        parent::__construct();

        $this->ssh         = $ssh;
        $this->theme       = $theme;
        $this->configTheme = $configTheme;
        $this->colors      = $colors;
        $this->ajax        = $ajax;
        $this->config      = $config;
    }

    public function index()
    {
        $laravelVersion = Application::VERSION;
        $packages = $this->config->get('packages.nukacode');

        $this->setViewData(compact('laravelVersion', 'packages'));
    }

    public function getTheme()
    {
        $colors = $this->colors->getEntry();

        $availableThemes = $this->config->get('core::theme.themes');

        $this->setViewData(compact('colors', 'availableThemes'));
    }

    public function postTheme(Theme $request)
    {
		// Update the colors less file
		$this->colors->updateEntry($request->all());

		// Update the config file
		$this->configTheme->updateEntry($request->all());

		// Generate the new theme css file
		$commands = $this->theme->generateTheme($request->get('style'), $request->get('src'));
		$this->ssh->runCommands($commands);

		return $this->ajax->setStatus('success')->sendResponse();
    }
} 