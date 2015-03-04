Installation
====================================

Using the installer
-------------------
``composer global require "nukacode/installer=~1.0"``

``nukacode new <directory>``

.. note: You can use the ``--slim`` option at the end to get a minimal version.

The full version comes with nukacode core, menu, bootstrap, users and admin.  The slim variant comes with only core and menu.

From NukaCode/Laravel-Base
--------------------------
``composer create-project nukacode/laravel-base <path>``

Using Laravel-Base it will pull in Core and Menu automatically.

Manually
---------

Composer
~~~~~~~~~~~~~~~~~~~~~~~~
``composer require nukacode/core:~2.0``

Service Providers
~~~~~~~~~~~~~~~~~~~~~~~~
Add the following service providers to ``configs/app.php``.
::

     'NukaCode\Core\CoreServiceProvider',
     'NukaCode\Core\View\ViewServiceProvider',
     'NukaCode\Core\Requests\AjaxServiceProvider',
Configs/Migrations/Seeds
~~~~~~~~~~~~~~~~~~~~~~~~
Once that is done, you can publish the configs and migrations.

``php artisan vendor:publish``

This will create a nukacode-core.php in your config folder and add all the migrations and seeds inside your database/
 folders.

Routes
~~~~~~~~~~~~~~~~~~~~~~~~
If you would like to use the included routes, add the following to your ``app/Http/routes.php`` file.

``include_once(base_path() .'/vendor/nukacode/core/src/routes.php');``
