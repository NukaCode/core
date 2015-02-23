<?php namespace NukaCode\Core\Filesystem\Config;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\Factory;
use NukaCode\Core\Filesystem\Core;

class Package extends Core {

    protected $file;

    protected $validator;

    protected $config;

    protected $rules = [
        'NAME'    => 'required',
        'VERSION' => 'required',
        'DOCS'    => 'required',
    ];

    /**
     * @param Filesystem $file
     * @param Factory    $validator
     */
    public function __construct(Filesystem $file, Factory $validator)
    {
        $this->file      = $file;
        $this->validator = $validator;
        $this->config    = config_path('packages.php');
    }

    /**
     * Update package details for multiple packages
     */
    public function updateEntries()
    {
        $nukaDirectories = $this->file->directories(base_path('vendor/nukacode'));

        foreach ($nukaDirectories as $nukaDirectory) {
            // Get the package name for display purposes
            $package = explode('/', $nukaDirectory);

            if (strpos(end($package), 'front-end') !== false) {
                $package = explode('-', end($package));
            }

            $package = ucfirst(end($package));

            $serviceProvider = new \ReflectionClass('NukaCode\\' . $package . '\\' . $package . 'ServiceProvider');
            $package         = $serviceProvider->getConstants();

            $this->updateEntry($package);
        }
    }

    /**
     * Compile details about the package and persist it in the config
     *
     * @param $package
     */
    public function updateEntry($package)
    {
        $package = (object)$package;
        $this->verifyCommand($package);

        $lines      = file($this->config);
        $finishFile = false;

        foreach ($lines as $lineNumber => $line) {
            if (strpos($line, '\'' . $package->NAME . '\'') !== false) {
                $startingLineNumber = $lineNumber;
            }
        }

        if (! isset($startingLineNumber)) {
            $finishFile         = true;
            $startingLineNumber = count($lines) - 2;
        }

        $previousLineNumber = $startingLineNumber - 1;
        $versionLineNumber  = $startingLineNumber + 1;
        $docsLineNumber     = $startingLineNumber + 2;
        $endingLineNumber   = $startingLineNumber + 3;

        $lines[$previousLineNumber] = "        ],\n";
        $lines[$startingLineNumber] = "        '{$package->NAME}' => [\n";
        $lines[$versionLineNumber]  = "            'version' => '{$package->VERSION}',\n";
        $lines[$docsLineNumber]     = "            'docs'    => '{$package->DOCS}'\n";
        $lines[$endingLineNumber]   = "        ],\n";

        if ($finishFile === true) {
            $lines[] = "    ]\n";
            $lines[] = "];\n";
        }

        $this->file->delete($this->config);
        $this->file->put($this->config, implode($lines));
    }
}