<?php namespace NukaCode\Core\Controllers\Admin;

use Ajax;
use Artisan;
use File;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use NukaCode\Core\Console\SSH;

class SiteController extends \BaseController {

    /**
     * @var \NukaCode\Core\Console\SSH
     */
    private $ssh;

    /**
     * @var \Illuminate\Config\Repository
     */
    private $config;

    public function __construct(SSH $ssh, Repository $config)
    {
        parent::__construct();
        $this->ssh    = $ssh;
        $this->config = $config;
    }

    public function getIndex()
    {
        $laravelVersion = Application::VERSION;
        $packages = $this->config->get('packages.nukacode');

        $this->setViewData('laravelVersion', $laravelVersion);
        $this->setViewData('packages', $packages);
    }

    public function getTheme()
    {
        $masterLess   = app_path() .'/assets/less/colors.less';

        $lines = file($masterLess);

        $colors = array();

        $colors['gray']    = array('title' => 'Background Color',          'hex' => trim(substr(explode('@gray: ',             $lines[0])[1], 0, -2)));
        $colors['primary'] = array('title' => 'Primary Color',             'hex' => trim(substr(explode('@brand-primary: ',    $lines[1])[1], 0, -2)));
        $colors['info']    = array('title' => 'Information Color',         'hex' => trim(substr(explode('@brand-info: ',       $lines[2])[1], 0, -2)));
        $colors['success'] = array('title' => 'Success Color',             'hex' => trim(substr(explode('@brand-success: ',    $lines[3])[1], 0, -2)));
        $colors['warning'] = array('title' => 'Warning Color',             'hex' => trim(substr(explode('@brand-warning: ',    $lines[4])[1], 0, -2)));
        $colors['danger']  = array('title' => 'Error Color',               'hex' => trim(substr(explode('@brand-danger: ',     $lines[5])[1], 0, -2)));
        $colors['menu']    = array('title' => 'Active Menu Link Color',    'hex' => trim(substr(explode('@menuColor: ',        $lines[6])[1], 0, -2)));

        $availableThemes = $this->config->get('core::theme.themes');

        $this->setViewData('colors', $colors);
    }

    public function postTheme()
    {
        $input = e_array(\Input::all());

        if ($input != null) {
            // @todo: Move this to a service
            $masterLess   = app_path() .'/assets/less/colors.less';

            $lines = file($masterLess);

            // Set the new colors
            $lines[0] = '@gray:              '. $input['gray'] .";\n";
            $lines[1] = '@brand-primary:     '. $input['primary'] .";\n";
            $lines[2] = '@brand-info:        '. $input['info'] .";\n";
            $lines[3] = '@brand-success:     '. $input['success'] .";\n";
            $lines[4] = '@brand-warning:     '. $input['warning'] .";\n";
            $lines[5] = '@brand-danger:      '. $input['danger'] .";\n";
            $lines[6] = '@menuColor:         '. $input['menu'] .";\n";

            File::delete($masterLess);

            File::put($masterLess, implode($lines));

            // @todo: Move this to a service
            if (! File::exists(app_path() .'/config/packages/nukacode/core/theme.php')) {
                Artisan::call('config:publish', ['package' => 'nukacode/core']);
            }
            $themeConfig   = app_path() .'/config/packages/nukacode/core/theme.php';

            $lines = file($themeConfig);

            // Set the new colors
            $lines[17] = "        'style' => '". $input['style'] ."',\n";
            $lines[18] = "        'src'   => '". $input['src'] ."',\n";
            $lines[30] = "        'gray'    => '". $input['gray'] ."',\n";
            $lines[31] = "        'primary' => '". $input['primary'] ."',\n";
            $lines[32] = "        'info'    => '". $input['info'] ."',\n";
            $lines[33] = "        'success' => '". $input['success'] ."',\n";
            $lines[34] = "        'warning' => '". $input['warning'] ."',\n";
            $lines[35] = "        'danger'  => '". $input['danger'] ."',\n";
            $lines[36] = "        'menu'    => '". $input['menu'] ."',\n";

            File::delete($themeConfig);

            File::put($themeConfig, implode($lines));

            $commands = $this->ssh->generateTheme($input['style'], $input['src']);
            $this->ssh->runCommandsSshFacade($commands);

            Ajax::setStatus('success');
            return Ajax::sendResponse();
        }
    }
} 