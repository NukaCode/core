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

setViewData
^^^^^^^^^^^^^^^^^^^^^^^^
This method allows you to pass data to the view.  It accepts either an array or it will accept PHP's ``compact()``
function.

========== ======== =======
Parameters Required Default
========== ======== =======
$key       Yes
$value     No       null
========== ======== =======

Base Request
------------------------

Base Model
------------------------

Base Presenter
------------------------

Base Repository
------------------------

Base Service Provider
------------------------
