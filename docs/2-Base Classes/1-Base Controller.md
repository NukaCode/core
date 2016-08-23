# BaseController

## Introduction
The NukCode BaseController class adds a lot of extra functionality to help with common tasks.  To use it you should have 
your `Controller` class (the one all of your other controllers extend) extend `NukaCode\Core\Http\Controllers\BaseController`.

> Make sure to always call `parent::__construct()` if you overload the `__construct()` method.

### Blade Syntax
The base controller allows you to reset blade syntax back to the Laravel 4 version.  You can do this by called
`$this->resetBladeSyntax()` in any controller method.

If called, `{{ }}` is escaped text and `{{{ }}}` is non-escaped.

### Auto View Resolution
By default, your controller should always call `return $this->view()` at the end.  This tells the controller to find your 
view.  This is done one of three ways.

#### Manually
You can specify your view (and your layout) in the method itself.  `$this->view('view.path', 'layout.path')`.  If you set 
either it will use that and ignore any next steps pertaining to it.  So if you set the view, it will not try to find a view 
in the config or automatically.  If you set the layout, it will not look to the `layoutOptions[]` array.

#### Through configuration
When you called `vendor:publish`, a `config/view-routing.php` file was created.  This file allows you to specify a specific 
view for a controller->method.  For example, if you wanted the AuthController's register method to point to a view at 
`register.index`, you could add the following.

```
return [
    'App\Http\Controllers\AuthController' => [
        'register' => 'register.index',
    ],
];
```

Now, when you call `$this->view()` on that method, it will see this config and load the `register.index` view.

#### Using the auto resolver
If none of the above have been done, this package will find the view for you.  This will look at your route to figure out 
where the view likely is by using any prefixes, the controller name and the method name.

For example, if you were calling the `create()` method on the `PostController`, NukaCode will presume that your view will 
be in `views/post/create.blade.php`.

This feature does take into account prefixes used in your routes.  If you have prefixes set, it will grab all of them that 
lead to this route and check if folders exist for them.

#### setViewData
This method allows you to pass data to the view.  It accepts either a key/value pair of parameters or it will accept PHP's 
`compact()` function.

```
$this->setViewData('user', User::find($userId);
$this->setViewData(compact('user'));
```

> All of these will send a variable named `$user` to the view.

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

> All of these will send a variable named `js_namespace.user` to javascript.

In your javascript:
```javascript
let user = js_namespace.user
````
