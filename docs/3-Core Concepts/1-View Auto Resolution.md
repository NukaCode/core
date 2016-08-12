# View Auto Resolution
Core comes with a helper to auto resolve views for you.  It does this automatically, but each part can be overridden 
([See BaseController for info on how]()).

## How it works
When the controller loads, it calls `ViewBuilder` and begins the process of figuring out what layout and view to use.

Anything in here is able to be overloaded.  You can also completely stop this in it's tracks by overloading BaseController's
`__construct()` in your controllers and not calling `parent::__construct()`.

## Layouts
The layout is determined very simply by whether or not the call is ajax.  If it is, it grabs the `$layoutOptions['ajax']` 
layout, otherwise it looks for `$layoutOptions['default']`.

> See [setViewLayout()]() for information on how you can overload the auto resolved layout.

## Views
The view is determined by a number of factors.  The controller, the action and the prefix.  Assuming that no prefixes are
used, the view will be controller.action.  (ex: `HomeController@index` would become `home.index`).

The methods strip `Controller` from the controller name and any HTTP verb from the beginning of the action name (get, post, 
put, etc.).

If you are using prefixes, the methods will concat all the prefixes into a single dot notation string.  It will then remove
the controller name from the prefix if it finds it.  (ie: If you have a prefix as `admin.user` and the controller is 
`UserController`, it will remove `user` from the prefix).
  
> The controller name is only removed if it was the last prefix.

If no view is found using the prefix, it will drop off one part of the dot notation at a time trying to find a valid view.  
So if your prefix was `admin.user.dashboard` and your view was in `views/admin/user` it would still find it since it would 
drop `dashboard` after it didn't find an existing view.

```
Route::group(['prefix' => 'admin'], function () {
    Route::group(['prefix' => 'home'], function () {
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', [
                'as'   => 'admin.home.index',
                'uses' => 'HomeController@index'
            ]);
        });
    });
});
```

In the above example, core would look for a view at `views/admin/home/dashboard/index.blade.php`.  When it doesn't find 
one there, it will look at `views/admin/home/index.blade.php`.  Since the controller name matched the last prefix, it skipped 
looking in `views/admin/home/home/index.blade.php`.

If no view was found there, it would have looked for one last view in `views/home/index.blade.php`.  If none is found 
there, it will throw a ViewNotFound exception.

You can call `viewBuilder()->debug()` at any time to get a display of what was checked.  You will get an output similar 
to the following.

```
ViewModel {#231 ▼
  +prefix: null
  +controller: "home"
  +action: "index"
  +view: "home.index"
  +prefixes: Collection {#228 ▼
    #items: array:3 [▼
      0 => "admin"
      1 => "home"
      2 => "dashboard"
    ]
  }
  +attemptedViews: Collection {#227 ▼
    #items: array:3 [▼
      0 => "admin.home.dashboard.home.index"
      1 => "admin.home.index"
      2 => "home.index"
    ]
  }
}
```

If no view was found, `$view` will be null.  Likewise, if the view was found without a prefix, the prefix will be null.

> See [setViewPath()]() for information on how you can overload the auto resolved view.
