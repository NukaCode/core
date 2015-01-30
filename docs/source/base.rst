Base Classes
========================

Base Controller
------------------------
.. todo:: Add resetBlade property (bool) to base.
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

    Examples
    $this->setViewData('user', User::find($user_id);
    $this->setViewData(compact('user'));

========== ======== =======
Parameters Required Default
========== ======== =======
$key | $compact       Yes
$value     No       null
========== ======== =======

Base Request
------------------------
The base form request is a minor modification of Laravel's ``Illuminate\Foundation\Http\FormRequest``.  It adds
integration with the Ajax service included with core so that validation failures get passed to the Ajax service.

Base Model
------------------------
Core's base model adds quite a bit and sets a few defaults for all models.

Traits
^^^^^^^^^^^^^^^^^^^^^^^^
* PresentableTrait - This is pulled in from ``laracasts/presenter`` to allow easy presenter integration.

Properties
^^^^^^^^^^^^^^^^^^^^^^^^
==== ===== =====
Name Value Notes
==== ===== =====
injectIdentifier True
throwValidationExceptions False
==== ===== =====


Base Presenter
------------------------

Base Repository
------------------------

Base Service Provider
------------------------
