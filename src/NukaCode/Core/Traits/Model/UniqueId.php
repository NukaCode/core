<?php

namespace NukaCode\Core\Traits\Model;

class UniqueId
{

    protected $primaryKey = 'uniqueId';

    public $incrementing = false;

    /**
     * Allow id to be called regardless of the primary key.
     *
     * @return int|string
     */
    public function getIdAttribute()
    {
        return $this->{$this->primaryKey};
    }
}
