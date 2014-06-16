<?php namespace NukaCode\Core\Console;

class SSH {

    public function runCommands(array $commands)
    {
        if (count($commands) > 0) {
            $commands = implode(';', $commands);

            passthru($commands);
        } else {
            throw new \NukaCode\Core\Exceptions\Theme\NoCommandsProvided();
        }
    }

    public function generateTheme($theme, $location)
    {
        switch ($location) {
            case 'local':
                $directory = 'app/assets/less';
                break;
            case 'vendor':
                $directory = 'vendor/nukacode/core/assets/less';
                break;
            default:
                throw new \NukaCode\Core\Exceptions\Theme\InvalidConfig($location);
                break;
        }

        if ($theme == 'default') {
            $commands = [
                'cd ' . base_path(),
                'lessc ' . $directory . '/master.less public/css/master.css',
                'gulp css-mini'
            ];
        } else {
            if (!\File::exists($directory . '/themes/' . $theme)) {
                throw new \NukaCode\Core\Exceptions\Theme\InvalidSrc($theme);
            }

            $commands = [
                'cd ' . base_path(),
                'lessc ' . $directory . '/themes/' . $theme . '/master.less public/css/master.css',
                'gulp css-mini'
            ];
        }

        $this->runCommands($commands);
    }

    public function installComposerPackage($package)
    {
        $commands = [
            'cd ' . base_path(),
            'composer require nukacode/' . $package . ':dev-master',
            'php artisan config:publish nukacode/' . $package
        ];

        $this->runCommands($commands);
    }
} 