<?php namespace NukaCode\Core\Controllers;

use stdClass;

class AdminController extends \BaseController {

    public function getIndex()
    {
        // Set up the list of admin areas
        $areas = new stdClass();
        $areas->default    = 'site';

        $areas->panels = new stdClass();
        $areas->panels->site = new stdClass();
        $areas->panels->site->name = 'Site';
        $areas->panels->site->id   = 'site';
        $areas->panels->site->link = 'admin/site';

        $areas->panels->user = new stdClass();
        $areas->panels->user->name = 'Users';
        $areas->panels->user->id   = 'users';
        $areas->panels->user->link = 'admin/user';

        $this->setViewData('areas', $areas);
    }
}