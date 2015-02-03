Base Classes
=======

.. _base-controller:
Base Controller
-------

Blade
~~~~~~~
The base controller resets blade syntax to the Laravel 4 version by default.  You can override this by setting
``$resetBladeSyntax`` to false in your controller.

View Helpers
~~~~~~~
The view helper methods are there to handle controller to view set up and data transfer.
By default, :ref:`core auto finds the view and the layout to load <how-views-resolve>`.  These are done to remove the
constant ``view()`` or ``View::make()`` code in controllers when generally view paths follow the controller.action standard.

.. _setViewLayout:
setViewLayout
^^^^^^^
Use this to set the layout your views will extend.  By default, core looks for ``layouts.default`` for standard
requests and `layouts.ajax` for ajax requests.  These are set in the BaseController under ``layoutProperties``.  You can overload
these in your controller if you need to.

========== ======== =======
Parameters Required Default
========== ======== =======
$view      Yes
========== ======== =======

.. _setViewPath:
setViewPath
^^^^^^^
This is used to override the view path that core finds on it's own.  If the path it finds is incorrect, or you simply
want to point to something specific, call this method.  The string should follow the same syntax as ``view::make()``.

========== ======== =======
Parameters Required Default
========== ======== =======
$view      Yes
========== ======== =======

::

    $this->setViewPath('user.profile.avatar');

setViewData
^^^^^^^
This method allows you to pass data to the view.  It accepts either an array or it will accept PHP's ``compact()``
function.

========== ================ ======== =======
Parameters Type             Required Default
========== ================ ======== =======
$data      string | compact Yes
$value     mixed            No       null
========== ================ ======== =======

::

    $this->setViewData('user', User::find($user_id);
    $this->setViewData(compact('user'));

.. hint:: Both of these will send a variable named $user to the view.

.. _base-request:
Base Request
-------
The base form request is a minor modification of Laravel's ``Illuminate\Foundation\Http\FormRequest``.  It adds
integration with the :ref:`Ajax Service <ajax>` included with core so that validation failures get passed to the Ajax service.

.. _base-model:
Base Model
-------

Presenters
~~~~~~~
Core uses ``laracasts\presenter`` to handle the Presenter set up for a model.  To use it, simply set your model's
``$presenter`` property to the full class name (Including namespace) of the presenter.::

    protected $presenter = 'App\Presenters\ModelPresenter';
Observers
~~~~~~~
To set up Observers, simply set the ``$observer`` property on your model.  Like presenters, this should be the full
class name including namespace.

.. warning:: This observer will be called in the models boot method.  If you need to do anything inside the boot method make sure to call the parent.
::

    protected static $observer = 'App\Models\Observers\ModelObserver';
Unique ID / Unique String
~~~~~~~
If you want to add a unique id to your model, Core will help with this.  It can work one of two ways.

1. If it detects that your primaryKey is contains the word unique in the column name, it will automatically set it to a unique string when a model is created.
2. If you set a column name in the ``$uniqueStringColumns`` array on your model, anything in that name will have a unique string injected into it when a model is created.

You can set the string size by changing the ``$uniqueStringLimit`` property on your model.  It defaults to 10.

Scopes
~~~~~~~
Base model adds a few common scopes to make things easier.

orderByCreatedAt
^^^^^^^
This will order the models by created_at in ascending order.

orderByNameAsc
^^^^^^^
This will order the models by name in ascending order.

Base Presenter
-------
The base presenter that comes with Core aims at making only the most basic assumptions.  One thing it does it expand
upon the ``laracasts\presenter`` by adding a ``__call()`` magic method.  This is used to look for methods on the
presenter first and fall back to the model.

createdAtReadable
~~~~~~~
This method simply returns a model's created_at field in a human readbale format.  For example, if the
created_at was 2014-12-01 it would return December 1st, 2014 at 12:00a.

name
~~~~~~~
This simply runs ``stripslashes`` on the models name field.

hidden / active
~~~~~~~
These two methods look for a hidden or active boolean on the model and return a string if true.  By default hidden
looks for hiddenFlag and active looks for activeFlag on the model.  You can change this by passing the field name
to the method.::

    $user->hidden('is_hidden'); // Will return "hidden" if $user->is_hidden is true.

.. _base-respository:
Base Repository
-------
Base repository adds a few very simple helpers.

find
~~~~~~~
This runs find on the model for the id passed to it.

========== ================ ======== =======
Parameters Type             Required Default
========== ================ ======== =======
$id        string|int       Yes
========== ================ ======== =======

findFirst
~~~~~~~
Similar to find but this method runs firstOrFail.  This means it will throw an exception if the model is not found.

========== ================ ======== =======
Parameters Type             Required Default
========== ================ ======== =======
$id        string|int       Yes
========== ================ ======== =======

orderByName
~~~~~~~
This uses the ``orderByNameAsc()`` scope found on BaseModel.  It finishes the query off with ``get()`` so only use it if all you need to do is order all models.

paginate
~~~~~~~
This method runs ``orderByNameAsc()`` but end with ``paginate()`` with the count you pass in.

========== ================ ======== =======
Parameters Type             Required Default
========== ================ ======== =======
$count     int              Yes
========== ================ ======== =======