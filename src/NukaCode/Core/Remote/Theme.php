<?php namespace NukaCode\Core\Remote;

use NukaCode\Bootstrap\Exceptions\Theme\InvalidConfig;
use NukaCode\Bootstrap\Exceptions\Theme\InvalidSrc;

class Theme {

    protected $cssDirectory;

    protected $localLessDirectory;

    protected $vendorLessDirectory;

    public function __construct()
    {
        $this->cssDirectory        = public_path('css/');
        $this->localLessDirectory  = base_path('resources/assets/less');
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
                'lessc ' . $directory . '/master.less ' . $this->cssDirectory . 'master.css',
                'gulp css-mini'
            ];
        } else {
            if (!\File::exists($directory . '/themes/' . $theme)) {
                throw new InvalidSrc($theme);
            }

            $commands = [
                'lessc ' . $directory . '/themes/' . $theme . '/master.less ' . $this->cssDirectory . 'master.css',
                'gulp css-mini'
            ];
        }

        return $commands;
    }
}