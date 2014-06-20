<?php namespace NukaCode\Core\Servicing\Crud;

use HTML;

class MultiView {

    public $crud;

    public $rootColumn;

    public $multiColumn;

    public function __construct($crud)
    {
        $this->crud = $crud;
        $this->rootColumn = new \stdClass();
        $this->multiColumn = new \stdClass();
    }

    public function addRootColumn($title, $collection, $name, $field, $selectArray)
    {
        $this->rootColumn->title = $title;
        $this->rootColumn->collection = $collection;
        $this->rootColumn->name = $name;
        $this->rootColumn->field = $field;

        $this->crud->addFormField($field, 'select', $selectArray);

        return $this;
    }

    public function addMultiColumn($title, $property, $name, $field, $selectArray)
    {
        $this->multiColumn->title = $title;
        $this->multiColumn->property = $property;
        $this->multiColumn->name = $name;
        $this->multiColumn->field = $field;

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
}