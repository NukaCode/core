View Auto Resolution
=======
Core comes with a helper to auto resolve views for you.  It does this automatically, but each part can be overridden (:ref:`See BaseController for info on how <base-controller>`).

.. _how-views-resolve:
How it works
-------
When the controller loads, it calls `ViewBuilder` and begins the process of figuring out what layout and view to use.

Anything in here is able to be overloaded.  You can also completly stop this in it's tracks by overloading BaseController's
__construct in your controllers.

.. _how-views-resolve-layouts:
Layouts
-------
The layout is determined very simply by whether or not the call is ajax.  If it is, it grabs layouts.ajax otherwise it looks for layouts.default.

.. tip::
    See
    :ref:`setViewLayout() <setViewLayout>`
    for information on how you can overload the auto resolved layout.

.. _how-views-resolve-views:
Views
-------
The view is determined by a number of factors.  The controller, the action and the prefix.  Assuming that no prefixes are
used, the view will be controller.action.  (ex: `HomeController@index` would become home.index).

The methods strip `Controller` from the controller name and any form verb from the beginning of the action name (get, post, put, etc.).

If you are using prefixes, the methods will concat all the prefixes into a single dot notation string.  It will then remove
the controller name if it finds it.  (ie: If you have a prefix for admin.user and the controller is UserController, it will
remove user from the prefix).  If no view is found using the prefix, it is dropped from the string and it reverts to looking for controller.action.::

    Route::group(['prefix' => 'admin'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [
                'as'   => 'admin.user.index',
                'uses' => 'UserController@index'
            ]);
        });
    });
In the above example, core would look for a view at views/admin/user/index.blade.php.  Since the second prefix is the same as
the converted controller name, it is dropped.

If no view is found there, it looks for one at views/user/index.blade.php.  If none is found there, it will return an exception.

.. tip::
    See
    :ref:`setViewPath() <setViewPath>`
    for information on how you can overload the auto resolved view.