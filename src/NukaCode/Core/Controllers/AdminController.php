<?php namespace NukaCode\Core\Controllers;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

class AdminController extends BaseController {

	public function __construct()
	{
		parent::__construct();

		$this->setViewLayout('layouts.admin');
	}

	public function dashboard(Filesystem $file, Repository $configRepository)
	{
		$config = json_decode($file->get(base_path() . '/admin.json'));

		$laravelVersion = Application::VERSION;
		$packages       = $configRepository->get('packages.nukacode');

		$this->setViewData(compact('laravelVersion', 'packages', 'config'));
	}
}