Collection
========

Tap property of collection
-------
If you have a collection you can tap a relationship of an object in the collection to get a new collection of the relationship data. You can also tap a property of the object in the collection to get a new collection of all instances of that property in that collection.
::
  $users = User::all();
  $actions = $users->roles->actions;
  $roleNames = $users->roles->name;
  
In this example, $actions would return a collection of all actions attached to all roles attached to the users.
`$roleNames` would return a collection of every role name for each role the users are attached to.

Run method on collection
-------
You can run a method on the entire collection such as `save()`, or `delete()`.  If you wanted to delete an entire collection you could do
::
  $users->roles->delete();
  
Searching a collection
-------
If you need to return a specific set of objects from a collection you can call the `getWhere()` method on the collection. This is a magic method used to search the collection.
Get where can take several extra parameters by changing the method name.

Method name convention
~~~~~~~
getWhere[ in | between | like | null | many ] [not] [ first | last ](mixed $column, mixes $value)

Method parameters
~~~~~~~
================ =========================== =====================================================================================================================
Method Name      Parameters                  Result
================ =========================== =====================================================================================================================
getWhere         | STRING $column            | This will return all object in the collection 
                 | STRING $value             | that have the column `$column` that equals 
                                             | `$value`.
getWhereIn       | STRING $column            | This will return all objects in the collection 
                 | STRING $values            | where the column `$column` is in the array of 
                                             | `$values`.
getWhereBetween  | STRING $column            | This will return all objects in the collection 
                 | STRING $values            | where the column `$column` is between `$values[0]`
                                             | and `$values[1]`.
getWhereLike     | STRING $column            | This will return all objects in the collection 
                 | STRING $value             | where column `$column` contains the sub string 
                                             | `$value`.
getWhereNull     | STRING $column            | This will return all objects in the collection 
                                             | where column `$column` is null.
getWhereMany     | ARRAY $columns => $values | This will return all objects in the collection 
                                             | that match all where statements in the passed in array.
================ =========================== =====================================================================================================================

Method Modifiers
~~~~~~~
================ ========================= =====================================================================================================================
Method Name      Parameters                Result
================ ========================= =====================================================================================================================
getWhereNot      | STRING $column          | This will return all objects in the collection 
                 | STRING $value           | that column `$column` is other than $value.  
                                           | (The not operator can be added to all methods 
                                           | to invert the results)
getWhereFirst    | STRING $column          | This will return only the first object in the 
                 | STRING $value           | collection.  (The first operator can be added 
                                           | to all methods to return the first result)
getWhereLast     | STRING $column          | This will return only the last object in the 
                 | STRING $value           | collection.  (The last operator can be added 
                                           | to all methods to return the last result)
================ ========================= =====================================================================================================================

Example
~~~~~~~
You can also look at `the tests <https://github.com/NukaCode/core/blob/master/tests/spec/NukaCode/Core/Database/CollectionSpec.php>`_ for more examples
::
  $aColleciton->getWhere('aField','Some Text');
  $aCollection->getWhere('relationship->aField', 'Some Text');
  $aCollection->getWhereNot('relationship->aField', 'Some Text');
  
toSelectArray()
-------
================ ================ ======== =======
Parameters       Type             Required Default
================ ================ ======== =======
$firstOptionText string           No       'Select One'
$id              string           No       'id'
$name            string           No       'name'
================ ================ ======== =======

This method takes a standard object from an eloquent call and converts it to an array usable by Laravel's form select method. This is used similarly to the Laravel `toJson()` or `toArray()` methods.
::
  $users = User::orderByNameAsc()->get()->toSelectArray( 'Select a user', 'uniqueId', 'username');
