<?php namespace NukaCode\Core\Filesystem\Config;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\Factory;

class Package {

    private $file;

    private $validator;

    private $config;

    private $rules = [
        'packageName' => 'required',
        'version'     => 'required',
        'color'       => 'required',
        'icon'        => 'required'
    ];

    public function __construct(Filesystem $file, Factory $validator)
    {
        $this->file      = $file;
        $this->validator = $validator;
        $this->config    = app_path('config/packages.php');
    }

    public function updateEntry($package)
    {
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

    protected function verifyCommand($package)
    {
        $validator = $this->validator->make((array)$package, $this->rules);

        if ($validator->fails()) {
            $messages = $validator->messages();

            foreach ($messages->all() as $message) {
                throw new \InvalidArgumentException($message);
            }
        }
    }
}