<?php

namespace NukaCode\Core\Console;

use Illuminate\Foundation\Console\AppNameCommand as LaravelAppNameCommand;

class AppNameCommand extends LaravelAppNameCommand
{

    /**
     * Set the application provider namespaces.
     *
     * @return void
     */
    protected function setAppConfigNamespaces()
    {
        parent::setAppConfigNamespaces();

        $this->replaceIn(
            $this->getConfigPath('app'),
            $this->currentRoot . '\\Models\\',
            $this->argument('name') . '\\Models\\'
        );
    }
}
