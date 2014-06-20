<?php namespace NukaCode\Core\Models;

class Seed extends \BaseModel {
    /********************************************************************
     * Traits
     *******************************************************************/

    /********************************************************************
     * Declarations
     *******************************************************************/

    /********************************************************************
     * Validation rules
     *******************************************************************/
    protected $rules = array(
        'name' => 'unique:seeds,name',
    );

    /********************************************************************
     * Scopes
     *******************************************************************/

    /********************************************************************
     * Model Events
     *******************************************************************/

    /********************************************************************
     * Getter and Setter methods
     *******************************************************************/

    /********************************************************************
     * Extra Methods
     *******************************************************************/
}