<?php namespace NukaCode\Core\Controllers\Admin;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use NukaCode\Core\Console\SSH;
use NukaCode\Core\Console\Theme as ConsoleTheme;
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

        $this->setViewData('laravelVersion', $laravelVersion);
        $this->setViewData('packages', $packages);
    }

    public function getTheme()
    {
        $colors = $this->colors->getEntry();

        $availableThemes = $this->config->get('core::theme.themes');

        $this->setViewData('colors', $colors);
        $this->setViewData('availableThemes', $availableThemes);
    }

    public function postTheme()
    {
        $input = e_array($this->input->all());

        if ($input != null) {
            // Update the colors less file
            $this->colors->updateEntry($input);

            // Update the config file
            $this->configTheme->updateEntry($input);

            // Generate the new theme css file
            $commands = $this->theme->generateTheme($input['style'], $input['src']);
            $this->ssh->runCommandsSshFacade($commands);

            return $this->ajax->setStatus('success')->sendResponse();
        }
    }
} 