Base Classes
========================

Base Controller
------------------------

Blade
~~~~~~~~~~~~~~~~~~~~~~~~
The base controller resets blade syntax to the Laravel 4 version by default.  You can override this by setting
``$resetBladeSyntax`` to false in your controller.

View Helpers
~~~~~~~~~~~~~~~~~~~~~~~~
The view helper methods are there to handle controller to view set up and data transfer.  By default, core auto finds
the view to load and the layout.  These are done to remove the constant ``view()`` or ``View::make()`` code in
controllers.

setViewLayout
^^^^^^^^^^^^^^^^^^^^^^^^
Use this to set the layout your views will extend.  By default, core looks for ``layouts.default`` for standard
requests and ``layouts.ajax`` for ajax requests.

========== ======== =======
Parameters Required Default
========== ======== =======
$view      Yes
========== ======== =======

setViewPath
^^^^^^^^^^^^^^^^^^^^^^^^
This is used to override the view path that core finds on it's own.  If the path it finds is incorrect, or you simply
want to point to something specific, call this method.

========== ======== =======
Parameters Required Default
========== ======== =======
$view      Yes
========== ======== =======

setViewData
^^^^^^^^^^^^^^^^^^^^^^^^
This method allows you to pass data to the view.  It accepts either an array or it will accept PHP's ``compact()``
function.

========== ================ ======== =======
Parameters Type             Required Default
========== ================ ======== =======
$data      string | compact Yes
$value     mixed            No       null
========== ================ ======== =======

::

    Examples
    $this->setViewData('user', User::find($user_id);
    $this->setViewData(compact('user'));
Base Request
------------------------
The base form request is a minor modification of Laravel's ``Illuminate\Foundation\Http\FormRequest``.  It adds
integration with the Ajax service included with core so that validation failures get passed to the Ajax service.

Base Model
------------------------
Core's base model adds quite a bit and sets a few defaults for all models.

Presenters
^^^^^^^^^^^^^^^^^^^^^^^^
Core uses ``laracasts\presenter`` to handle the Presenter set up for a model.  To use it, simply set your model's
``$presenter`` property to the full class name (Including namespace) of the presenter.::

    protected $presenter = 'App\Presenters\ModelPresenter';
Observers
^^^^^^^^^^^^^^^^^^^^^^^^
To set up Observers, simply set the ``$observer`` property on your model.  Like presenters, this should be the full
class name including namespace.

This observer will be called in the models boot method.  If you need to do anything inside the boot method make sure
to call the parent.::

    protected static $observer = 'App\Models\Observers\ModelObserver';
Unique ID / Unique String
^^^^^^^^^^^^^^^^^^^^^^^^^
If you want to add a unique id to your model, Core will help with this.  It can work one of two ways.

# If it detects that your primaryKey is contains the word unique in the column name, it will automatically set it to a
unique string when a model is created.
# If you set a column name in the ``$uniqueStringColumns`` array on your model, anything in that name will have a unique
string injected into it when a model is created.

You can set the string size by changing the ``$uniqueStringLimit`` property on your model.  It defaults to 10.


Base Presenter
------------------------

Base Repository
------------------------

Base Service Provider
------------------------
