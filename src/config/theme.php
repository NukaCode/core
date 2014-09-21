<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Theme
    |--------------------------------------------------------------------------
    |
    | The site theme is used to overload the coreOld changes to bootstrap.
    | The available themes are located in nukacode/coreOld/assets/less/themes.
    | You can also make your own in app/assets/less/themes.  Dark is provided
    | as an example.  Use 'default' if you want to use the base style.  Set
    | src to local to use files in app or vendor to use the files from core.
    |
    */
    'theme' => [
        'style' => 'dark',
        'src'   => 'vendor'
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme colors
    |--------------------------------------------------------------------------
    |
    | These are the colors that will be used throughout your theme.
    |
    */
    'colors' => [
        'gray'    => '#343838',
        'primary' => '#5097b5',
        'info'    => '#3b81ba',
        'success' => '#62c462',
        'warning' => '#e38928',
        'danger'  => '#ba403b',
        'menu'    => '#76c6e8',
    ],

    /*
    |--------------------------------------------------------------------------
    | Available Themes
    |--------------------------------------------------------------------------
    |
    | By default, core comes with two themes (default and dark).  If you create
    | a custom theme, make sure to add it to this list so it is selectable
    | in the admin panel.
    |
    */
    'themes' => [
        'default' => 'Default',
        'dark' => 'Dark'
    ]
];