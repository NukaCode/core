# BaseController

## Introduction
The NukCode BaseController class adds a lot of extra functionality to help with common tasks.  To use it you should have 
your `Controller` class (the one all of your other controllers extend) extend `NukaCode\Core\Http\Controllers\BaseController`.

> Make sure to always call `parent::__construct()` if you overload the `__construct()` method.

## View Helpers
The view helper methods are there to handle controller to view set up and data transfer.

### Blade Syntax
The base controller allows you to reset blade syntax back to the Laravel 4 version.  You can do this by setting
`$resetBladeSyntax` to true in your controller.

If set to true, `{{ }}` is normal, escaped text and `{{{ }}}` is non-escaped.

### Auto View Resolution
By default, [core will automatically find the view and the layout to load]()`.  These are done to remove the
constant `view()` or `View::make()` code in controllers when generally view paths follow the controller.action standard.

For example, if you were calling the `create()` method on the `PostController`, NukaCode will presume that your view will 
be in `views/post/create.blade.php`.

This feature does take into account prefixes used in your routes.  If you have prefixes set, it will grab all of them that 
lead to this route and check if folders exist for them.

#### setViewLayout
Use this to set the layout your views will extend.  By default, core looks for `layouts.default` for standard
requests and `layouts.ajax` for ajax requests.  These are set in the BaseController under `layoutProperties`.  You can overload
these in your controller if you need to.

`$this->setViewLayout('layouts.admin');`

To override the defaults, you would change the `layoutOptions` property in your controller.
```
    protected $layoutOptions = [
        'default' => 'layouts.default',
        'ajax'    => 'layouts.ajax'
    ];
```

#### setViewPath
This is used to override the view path that core finds on it's own.  If the path it finds is incorrect, or you simply
want to point to something specific, call this method.  The string should follow the same dot notation syntax as 
`view::make()`.

`$this->setViewPath('user.profile.avatar');`

#### setViewData
This method allows you to pass data to the view.  It accepts either a key/value pair of parameters or it will accept PHP's 
`compact()` function.

```
$this->setViewData('user', User::find($userId);
$this->setViewData(compact('user'));
```

> Both of these will send a variable named `$user` to the view.

#### setJavascriptData
This method allows you to pass data directly to javascript.  It accepts either a key/value pair of parameters or it will accept PHP's 
`compact()` function.  You can access this in your javascript by using your set namespace followed by the variable name.

> You can set your namespace in `app/config/javascript.php` or in you `.env` file using the key `JS_NAMESPACE`.

In your controller:
```php
<?php

$this->setJavascriptData('user', User::find($userId);
$this->setJavascriptData(compact('user'));
```

> Both of these will send a variable named `js_namespace.user` to javascript.

In your javascript:
```javascript
let user = js_namespace.user
````
