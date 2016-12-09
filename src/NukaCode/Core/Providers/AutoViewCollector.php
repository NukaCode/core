<?php

namespace NukaCode\Core\Providers;

use DebugBar\Bridge\Twig\TwigCollector;
use DebugBar\DataCollector\Renderable;
use NukaCode\Core\View\Models\ViewModel;

class AutoViewCollector extends TwigCollector implements Renderable
{
    /**
     * @var null|\NukaCode\Core\View\Models\ViewModel
     */
    public $viewModel = null;

    /**
     * Create a ViewCollector
     */
    public function __construct()
    {
        $this->name = 'auto_views';
    }

    public function getName()
    {
        return 'auto_views';
    }

    public function getWidgets()
    {
        return [
            'auto_resolved_view' => [
                'icon'    => 'archive',
                'widget'  => 'PhpDebugBar.Widgets.VariableListWidget',
                'map'     => 'auto_views',
                'default' => '{}',
            ],
        ];
    }

    public function addDetails(ViewModel $viewModel)
    {
        $this->viewModel = $viewModel;
    }

    public function collect()
    {
        $attemptedViews = $this->viewModel->attemptedViews;
        $prefixes       = $this->viewModel->prefixes;

        $data = [
            'resolved view'     => $this->viewModel->view,
            'resolution type'   => $this->viewModel->type,
            'attempted views'   => $this->getDataFormatter()
                                        ->formatVar($attemptedViews ? $attemptedViews->toArray() : $attemptedViews),
            'controller'        => $this->viewModel->controller,
            'action'            => is_null($this->viewModel->action) ? 'null (__invoke)' : $this->viewModel->action,
            'final prefix'      => $this->viewModel->prefix,
            'possible prefixes' => $this->getDataFormatter()
                                        ->formatVar($prefixes ? $prefixes->toArray() : $prefixes),
            'config index'      => $this->viewModel->configIndex,
        ];

        return $data;
    }
}
