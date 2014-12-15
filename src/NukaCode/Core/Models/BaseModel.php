<?php namespace NukaCode\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use NukaCode\Core\Database\Collection;
use Illuminate\Support\Str;

abstract class BaseModel extends Model {

    use PresentableTrait;

    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation.
     *
     * @var boolean
     */
    protected $injectIdentifier = true;

    /**
     * Whether the model should throw a ValidationException if it
     * fails validation.
     *
     * @var boolean
     */
    protected $throwValidationExceptions = false;

    /**
     * Assign a presenter to use
     *
     * @var string
     */
    protected $presenter = null;

    /**
     * Assign as observer to use
     *
     * @var string
     */
    protected static $observer = null;

    /**
     * Make sure the uniqueId is always unique.
     *
     * @param string $model The model to search for the uniqueId on.
     *
     * @return string
     */
    public static function findExistingReferences($model)
    {
        $invalid = true;

        while ($invalid == true) {
            // Create a new random string.
            $uniqueString = Str::random(10);

            // Look for any instances of that string on the model.
            $existingReferences = $model::where('uniqueId', $uniqueString)->count();

            // If none exist, this is a valid unique string.
            if ($existingReferences == 0) {
                $invalid = false;
            }
        }

        return $uniqueString;
    }

    /**
     * Use the custom collection that allows tapping.
     *
     * @param array $models An array of models to turn into a collection.
     *
     * @return Utility_Collection[]
     */
    public function newCollection(array $models = [])
    {
        return new Collection($models);
    }

    /********************************************************************
     * Scopes
     *******************************************************************/
    /**
     * Order by created_at ascending scope.
     *
     * @param array $query The current query to append to
     */
    public function scopeOrderByCreatedAsc($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    /**
     * Order by name ascending scope.
     *
     * @param array $query The current query to append to
     */
    public function scopeOrderByNameAsc($query)
    {
        return $query->orderBy('name', 'asc');
    }

    /**
     * Get only active rows.
     *
     * @param array $query The current query to append to
     */
    public function scopeActive($query)
    {
        return $query->where('activeFlag', 1);
    }

    /**
     * Get only inactive rows.
     *
     * @param array $query The current query to append to
     */
    public function scopeInactive($query)
    {
        return $query->where('activeFlag', 0);
    }

    /********************************************************************
     * Model events
     *******************************************************************/

    /**
     * Common tasks needed for all models.
     * Registers the observer if it exists.
     * Sets the default creating event to check for uniqueIds when the model uses them.
     */
    public static function boot()
    {
        parent::boot();

        // Get the possible class names.
        $class = get_called_class();

        // If the class uses uniqueIds, make sure it is truly unique.
        if (self::testClassForUniqueId($class) == true) {
            $class::creating(function ($object) use ($class) {
                $object->uniqueId = parent::findExistingReferences($class);
            });
        }

        if (static::$observer != null) {
            $class::observe(new static::$observer);
        }
    }

    /********************************************************************
     * Getters and Setters
     *******************************************************************/
    /**
     * Allow id to be called regardless of the primary key.
     *
     * @param int|null $value The original value of id.
     *
     * @return int|string
     */
    public function getIdAttribute($value)
    {
        if (isset($this->uniqueId)) {
            return $this->uniqueId;
        }

        return $value;
    }

    /********************************************************************
     * Extra Methods
     *******************************************************************/
    /**
     * See if a given class uses uniqueId as the primary key.
     *
     * @param string $class The model to search for the uniqueId on.
     *
     * @return bool
     */
    public static function testClassForUniqueId($class)
    {
        $object = new $class;

        if ($object->primaryKey == 'uniqueId') {
            return true;
        }

        return false;
    }
}