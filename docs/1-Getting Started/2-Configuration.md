# Configuration

## Service Providers
Add the following service providers to ``configs/app.php``.

```
    'NukaCode\Core\CoreServiceProvider',
    'NukaCode\Core\View\ViewServiceProvider',
```
     
## Configs/Migrations/Seeds
Once that is done, you can publish the configs and migrations.

`php artisan vendor:publish`

This will create a nukacode-core.php in your config folder and add all the migrations and seeds inside your `database/`
 folders.
