<?php namespace NukaCode\Core\Filesystem\Config;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Validation\Factory;
use NukaCode\Core\Filesystem\Core;

class Theme extends Core {

    protected $file;

    protected $validator;

    protected $config;

    protected $rules = [
        'style'   => 'required',
        'src'     => 'required',
        'gray'    => 'required',
        'primary' => 'required',
        'success' => 'required',
        'info'    => 'required',
        'warning' => 'required',
        'danger'  => 'required',
        'menu'    => 'required',
    ];

	/**
	 * @param Filesystem $file
	 * @param Factory    $validator
	 */
	public function __construct(Filesystem $file, Factory $validator)
    {
        $this->file      = $file;
        $this->validator = $validator;
        $this->config    = base_path('config/packages/nukacode/core/theme.php');
    }

	/**
	 * Update the config with the color values for easy retrieval
	 *
	 * @param $package
	 */
	public function updateEntry($package)
    {
        $this->verifyCommand($package);

        $lines = file($this->config);

        // Set the new colors
        $lines[17] = "        'style' => '". $package['style'] ."',\n";
        $lines[18] = "        'src'   => '". $package['src'] ."',\n";
        $lines[30] = "        'gray'    => '". $package['gray'] ."',\n";
        $lines[31] = "        'primary' => '". $package['primary'] ."',\n";
        $lines[32] = "        'info'    => '". $package['info'] ."',\n";
        $lines[33] = "        'success' => '". $package['success'] ."',\n";
        $lines[34] = "        'warning' => '". $package['warning'] ."',\n";
        $lines[35] = "        'danger'  => '". $package['danger'] ."',\n";
        $lines[36] = "        'menu'    => '". $package['menu'] ."',\n";

        $this->file->delete($this->config);
        $this->file->put($this->config, implode($lines));
    }
}