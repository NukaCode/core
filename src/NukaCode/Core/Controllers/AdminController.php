<?php namespace NukaCode\Core\Controllers;

use Illuminate\Filesystem\Filesystem;

class AdminController extends BaseController {

	public function index(Filesystem $file)
	{
		$this->setViewLayout('layouts.admin');

		$config = json_decode($file->get(base_path() . '/admin.json'));

		$this->setViewData(compact('config'));
	}

	public function dashboard(Filesystem $file)
	{
		$config = json_decode($file->get(base_path() . '/admin.json'));

		$this->setViewData(compact('config'));
	}
}