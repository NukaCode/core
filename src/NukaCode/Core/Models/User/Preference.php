<?php namespace NukaCode\Core\Models\User;

use NukaCode\Core\Models\Relationships\User\Preference as PreferenceRelationshipsTrait;

class Preference extends \BaseModel {
    /********************************************************************
     * Traits
     *******************************************************************/
    use PreferenceRelationshipsTrait;

    /********************************************************************
     * Declarations
     *******************************************************************/

    /**
     * Table declaration
     *
     * @var string $table The table this model uses
     */
    protected $table = 'preferences';

    /********************************************************************
     * Validation rules
     *******************************************************************/

    protected $rules = array(
        'name'    => 'required',
        'value'   => 'required',
        'default' => 'required',
        'display' => 'required',
    );

    /********************************************************************
     * Scopes
     *******************************************************************/

    /********************************************************************
     * Model events
     *******************************************************************/

    /********************************************************************
     * Getter and Setter methods
     *******************************************************************/

    /********************************************************************
     * Extra Methods
     *******************************************************************/

    public function getPreferenceOptionsArray()
    {
        $preferenceOptions = explode('|', $this->value);
        $preferenceArray   = array();

        foreach ($preferenceOptions as $preferenceOption) {
            $preferenceArray[$preferenceOption] = ucwords($preferenceOption);
        }

        return $preferenceArray;
    }
}