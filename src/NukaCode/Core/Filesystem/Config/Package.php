<?php namespace NukaCode\Core\Filesystem\Config;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\Factory;
use NukaCode\Core\Filesystem\Core;

class Package extends Core {

    protected $file;

    protected $validator;

    protected $config;

    protected $rules    = [
        'NAME'    => 'required',
        'VERSION' => 'required',
        'DOCS'    => 'required',
    ];

    private   $packages = [
        'nukacode' => []
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

        $this->file->put($this->config, "<?PHP \n\n return " . var_export($this->packages, true) . ';');
    }

    public function updateEntry($package)
    {
        $package = (object)$package;
        $this->verifyCommand($package);

        $data['version'] = $package->VERSION;
        $data['docs']    = $package->DOCS;

        $this->packages['nukacode'][$package->NAME] = $data;
    }
}
