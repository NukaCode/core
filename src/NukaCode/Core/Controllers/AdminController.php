<?php namespace NukaCode\Core\Controllers;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

class AdminController extends BaseController {

    /**
     * @var Filesystem
     */
    private $file;

    /**
     * @var Repository
     */
    private $configRepository;

    public function __construct(Filesystem $file, Repository $configRepository)
    {
        parent::__construct();

        $this->setViewLayout('layouts.admin');

        $this->file             = $file;
        $this->configRepository = $configRepository;
    }

    public function dashboard()
    {
        $config = json_decode($this->file->get(base_path() . '/admin.json'));

        $laravelVersion = Application::VERSION;
        $packages       = $this->configRepository->get('packages.nukacode');

        $this->setViewData(compact('laravelVersion', 'packages', 'config'));
    }
}