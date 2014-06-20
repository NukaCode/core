<?php namespace NukaCode\Core\Console;

use NukaCode\Core\Exceptions\Theme\InvalidConfig;
use NukaCode\Core\Exceptions\Theme\InvalidSrc;

class Theme {

    protected $cssDirectory;

    protected $localLessDirectory;

    protected $vendorLessDirectory;

    public function __construct()
    {
        $this->cssDirectory        = public_path('css/');
        $this->localLessDirectory  = base_path('app/assets/less');
        $this->vendorLessDirectory = base_path('vendor/nukacode/core/assets/less');
    }

    public function generateTheme($theme, $location)
    {
        switch ($location) {
            case 'local':
                $directory = $this->localLessDirectory;
                break;
            case 'vendor':
                $directory = $this->vendorLessDirectory;
                break;
            default:
                throw new InvalidConfig($location);
                break;
        }

        if ($theme == 'default') {
            $commands = [
                'cd ' . base_path(),
                'lessc ' . $directory . '/master.less ' . $this->cssDirectory . 'master.css',
                'gulp css-mini'
            ];
        } else {
            if (!\File::exists($directory . '/themes/' . $theme)) {
                throw new InvalidSrc($theme);
            }

            $commands = [
                'cd ' . base_path(),
                'lessc ' . $directory . '/themes/' . $theme . '/master.less ' . $this->cssDirectory . 'master.css',
                'gulp css-mini'
            ];
        }

        return $commands;
    }
}