Installation
====================================

Composer
------------------------------------
You will need primarily only Laravel to run core.

``composer require laravel/framework:~5.0``

Configs/Migrations/Seeds
------------------------------------
Once that is done, you can publish the configs and migrations.

``php artisan vendor:publish``

This will create a nukacode-core.php in your config folder and add all the migrations and seeds inside your database/
 folders.

Routes
------------------------------------
If you would like to use the included routes, add the following to your ``app/Http/routes.php`` file.

``include_once(base_path() .'/vendor/nukacode/core/src/routes.php');``