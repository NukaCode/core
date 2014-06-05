<?php namespace NukaCode\Core\Services;

class SSHCommands {

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
                $directory = 'vendor/nukacode/coreOld/assets/less';
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

    public function publicPermissions()
    {
        $commands = [
            'cd ' . base_path(),
            'chmod 755 public',
            'chmod 755 public/index.php'
        ];

        $this->runCommands($commands);
    }

    public function installGulpDependencies()
    {
        $commands = [
            'cd ' . base_path(),
            'npm install --save-dev gulp gulp-autoprefixer gulp-util gulp-notify gulp-minify-css gulp-uglify gulp-less gulp-rename gulp-concat'
        ];

        $this->runCommands($commands);
    }

    public function runGulpInstallTask()
    {
        $commands = [
            'cd ' . base_path(),
            'gulp install'
        ];

        $this->runCommands($commands);
    }
} 