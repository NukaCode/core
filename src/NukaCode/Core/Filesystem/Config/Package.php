<?php namespace NukaCode\Core\Filesystem\Config;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\Factory;
use NukaCode\Core\Filesystem\Core;

class Package extends Core {

    protected $file;

    protected $validator;

    protected $config;

    protected $rules = [
        'packageName' => 'required',
        'version'     => 'required',
        'color'       => 'required',
        'icon'        => 'required'
    ];

    public function __construct(Filesystem $file, Factory $validator)
    {
        $this->file      = $file;
        $this->validator = $validator;
        $this->config    = base_path('config/packages.php');
    }

	public function updateEntries()
	{
		$nukaDirectories = $this->file->directories(base_path('vendor/nukacode'));

		foreach ($nukaDirectories as $nukaDirectory) {
			// Get the package name for display purposes
			$package = explode('/', $nukaDirectory);
			$package = ucfirst(end($package));

			$serviceProvider = new \ReflectionClass('NukaCode\\'. $package .'\\'. $package .'ServiceProvider');
			$package = $serviceProvider->getConstants();

			$this->updateEntry($package);
		}
	}

    public function updateEntry($package)
    {
		$package = (object) $package;
        $this->verifyCommand($package);

        $lines         = file($this->config);
        $finishFile    = false;

        foreach ($lines as $lineNumber => $line) {
            if (strpos($line, $package->packageName) !== false) {
                $startingLineNumber = $lineNumber;
            }
        }

        if (!isset($startingLineNumber)) {
            $finishFile     = true;
            $startingLineNumber = count($lines) - 2;
        }

        $previousLineNumber = $startingLineNumber - 1;
        $versionLineNumber  = $startingLineNumber + 1;
        $colorLineNumber    = $startingLineNumber + 2;
        $iconLineNumber     = $startingLineNumber + 3;
        $endingLineNumber   = $startingLineNumber + 4;

        $lines[$previousLineNumber] = "        ],\n";
        $lines[$startingLineNumber] = "        '{$package->packageName}' => [\n";
        $lines[$versionLineNumber]  = "            'version' => '{$package->version}',\n";
        $lines[$colorLineNumber]    = "            'color'   => '{$package->color}',\n";
        $lines[$iconLineNumber]     = "            'icon'    => '{$package->icon}',\n";
        $lines[$endingLineNumber]   = "        ],\n";

        if ($finishFile === true) {
            $lines[] = "    ]\n";
            $lines[] = "];\n";
        }

        $this->file->delete($this->config);
        $this->file->put($this->config, implode($lines));
    }
}