<?php

namespace NukaCode\Core\Traits\Model;

class UniqueId
{

    protected $primaryKey = 'uniqueId';

    public $incrementing = false;

    /**
     * Allow id to be called regardless of the primary key.
     *
     * @param int|null $value The original value of id.
     *
     * @return int|string
     */
    public function getIdAttribute($value)
    {
        return $this->{$this->primaryKey};
    }
}
