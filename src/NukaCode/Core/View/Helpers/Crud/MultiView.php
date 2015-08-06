<?php

namespace NukaCode\Core\View\Helpers\Crud;

class MultiView
{

    public $crud;

    public $rootColumn;

    public $multiColumn;

    public function __construct($crud)
    {
        $this->crud        = $crud;
        $this->rootColumn  = new \stdClass();
        $this->multiColumn = new \stdClass();
    }

    public function addRootColumn($title, $collection, $name, $field, $selectArray)
    {
        $this->setColumnProperties($this->rootColumn, $title, $name, $field);
        $this->rootColumn->collection = $collection;

        $this->crud->addFormField($field, 'select', $selectArray);

        return $this;
    }

    public function addMultiColumn($title, $property, $name, $field, $selectArray)
    {
        $this->setColumnProperties($this->multiColumn, $title, $name, $field);
        $this->multiColumn->property = $property;

        $this->crud->addFormField($field, 'multiselect', $selectArray);

        return $this;
    }

    public function finish()
    {
        $crud = $this->crud;
        unset($this->crud);

        $crud->multiView = $this;

        return $crud;
    }

    /**
     * @param $column
     * @param $title
     * @param $name
     * @param $field
     */
    private function setColumnProperties($column, $title, $name, $field)
    {
        $this->$column->title = $title;
        $this->$column->name  = $name;
        $this->$column->field = $field;
    }
}
