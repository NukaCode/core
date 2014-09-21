<?php namespace NukaCode\Core\Database;

use Illuminate\Database\Eloquent\Collection as BaseCollection;

class Collection extends BaseCollection {

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * 
     * @return mixed
     */
    public function __get($key)
    {
        $newCollection = new self();
        foreach ($this->items as $item) {
            if ($item instanceof self) {
                foreach ($item as $subItem) {
                    $newCollection->put($newCollection->count(), $subItem->$key);
                }
            }
            elseif (is_object($item) && !$item instanceof self && $item->$key instanceof self) {
                foreach ($item->$key as $subItem) {
                    $newCollection->put($newCollection->count(), $subItem);
                }
            }
            else {
                $newCollection->put($newCollection->count(), $item->$key);
            }
        }
        return $newCollection;
    }

    /**
     * Allow a method to be run on the enitre collection.
     *
     * @param string $method
     * @param array $args
     * 
     * @return Utility_Collection
     */
    public function __call($method, $args)
    {
        // Look for magic where calls.
        if (strstr($method, 'getWhere')) {
            return $this->magicWhere(snake_case($method), $args);
        }

        if ($this->count() <= 0) {
            return $this;
        }

        foreach ($this->items as $item) {
            if (!is_object($item)) {
                continue;
            }
            call_user_func_array(array($item, $method), $args);
        }

        return $this;
    }

    /**
     * Insert into an object
     *
     * @param int   $key
     * @param mixed $value
     * @param int   $afterKey
     *
     * @return Utility_Collection
     */
    public function insertAfter($key, $value, $afterKey)
    {
        $new_object = new self();
        // unset($new_object->items);
        $afterFlag  = false;
        $afterValue = $key;

        foreach ((array) $this->items as $k => $v) {
            if ($afterKey == $k) {
                $new_object->add($value);
                $afterFlag        = true;
            }

            $new_object->add($v);
        }

        $this->items = $new_object->items;

        return $this;
    }

    private function magicWhere($method, $args)
    {       
        $whereStatment = explode('_', $method);

        // Get where
        if (count($whereStatment) == 2) {
            return $this->getWhere($args[0], '=', $args[1]);
        }

        $operators = array(
            'in',
            'between',
            'like',
            'null',

            'not',
            
            'first',
            'last',

            'many',
        );

        // If an operator is found then add operators.
        if (array_intersect($whereStatment, $operators)) {

            $finialOperator = '=';
            $postion = null;
            $not = false;

            foreach ($whereStatment as $operator) {
                // Skip get and where.
                if ($operator == 'get' || $operator == 'where') {
                    continue;
                }

                // Set where return postion.
                if ($operator == 'first' || $operator == 'last') {
                    $postion = $operator;
                }

                if ($operator == 'not') {
                    $not = true;
                }

                if (in_array($operator, ['in', 'between', 'like', 'null', '='])) {
                    $finialOperator = $operator;
                }
            }

            if ($finialOperator == 'many') {
                foreach ($args[0] as $column => $value) {
                    $where = $this->where(
                        $column,            // Column
                        $finialOperator,    // Operator
                        $value,             // Value
                        $not,               // Inverse
                        $postion            // First or last
                    );
                }

                return $where;
            }

            return $this->getWhere(
                $args[0],                               // Column
                $finialOperator,                        // Operator
                (isset($args[1]) ? $args[1] : null),    // value
                $not,                                   // Inverse
                $postion                                // First or last
            );


        }
    }

    /**
     * Search a collection for the value specified.
     * 
     * @param  string   $column     The column to search.
     * @param  string   $operator   The operation to use during search.
     * @param  mixed    $value      The value to search for.
     * @param  boolean  $inverse    Invert the resultes.
     * @param  string   $postion    Return the first or last object in the collection.
     * 
     * @return self                 Return the filtered collection.
     */
    protected function getWhere($column, $operator, $value = null, $inverse = false, $postion = null)
    {
        $output = clone $this;
        foreach ($output->items as $key => $item) {

            $forget = false;

            if (strstr($column, '->')) {
                $taps = explode('->', $column);

                $objectToSearch = $item;
                $columnToSearch = array_pop($taps);

                foreach ($taps as $tap) {
                    // Keep tapping till we hit the last object.
                    $objectToSearch = $objectToSearch->$tap;
                }

                if ($objectToSearch instanceof self) {
                    foreach ($objectToSearch as $subObject) {
                        // The column has a tap that ends in a collection.
                        $forget = $this->whereObject($subObject, $columnToSearch, $operator, $value, $inverse);
                    }
                }
                else {
                    // The column has a tap that ends in direct access
                    $forget = $this->whereObject($objectToSearch, $columnToSearch, $operator, $value, $inverse);
                }
            } else {
                // No tap direct object access
                $forget = $this->whereObject($item, $column, $operator, $value, $inverse);
            }

            if ($forget == true) {
                $output->forget($key);
                continue;
            }
        }

        // Handel first and last.
        if (!is_null($postion)) {
            return $output->$postion();
        }

        return $output;
    }

    /**
     * Compair the object and colum passed with the value using the operator
     * 
     * @param  object   $object     The object we are searching.
     * @param  string   $column     The column to compaire.
     * @param  string   $operator   What type of compairason opersion to perform.
     * @param  mixed    $value      The value to search for.
     * @param  boolean  $inverse    Invert the results.
     * 
     * @return boolean              Return true if the object should be removed from the collection.
     */
    private function whereObject($object, $column, $operator, $value = null, $inverse = false)
    {
        // Remove the object is the column does not exits.
        if (!$object->$column) {
            return true;
        }

        switch ($operator) {
            case 'in':
                if (!in_array($object->$column, $value) && $inverse == false) {
                    return true;
                }
                if (in_array($object->$column, $value) && $inverse == true) {
                    return true;
                }
                break;
            case 'between':
                if ($inverse == false) {
                    if ($object->$column < $value[0] || $object->$column > $value[1]) {
                        return true;
                    }
                } else {
                    if ($object->$column >= $value[0] && $object->$column <= $value[1]) {
                        return true;
                    }
                }
                break;
            case 'like':
                if (!strstr($object->$column, $value) && $inverse == false) {
                    return true;
                }
                if (strstr($object->$column, $value) && $inverse == true) {
                    return true;
                }
                break;
            case 'null':
                if ($object->$column != "" && $inverse == false) {
                    return true;
                }
                if (is_null($object->$column) && $inverse == true) {
                    return true;
                }
                break;

            // Equles fall through to default.
            case '=':
            default:
                if ($object->$column != $value && $inverse == false) {
                    return true;
                }
                if ($object->$column == $value && $inverse == true) {
                    return true;
                }
                break;
        }

        return false;
    }

    /**
     * Turn a collection into a dropdown for an html select element.
     * 
     * @param  string $firstOptionText  Text for the first object in the select array.
     * @param  string $id               The column to use for the id column in the option element.
     * @param  string $name             The column to use for the name column in the option element.
     * 
     * @return array                    The new select element array.
     */
    public function toSelectArray($firstOptionText = 'Select one', $id = 'id', $name = 'name')
    {
        $selectArray = array();

        if ($firstOptionText != false) {
            $selectArray[0] = $firstOptionText;
        }

        foreach ($this->items as $item) {
            $selectArray[$item->{$id}] = $item->{$name};
        }
        return $selectArray;
    }
}