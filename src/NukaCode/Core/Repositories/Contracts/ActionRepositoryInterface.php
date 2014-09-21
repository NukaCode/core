<?php namespace NukaCode\Core\Repositories\Contracts; 

interface ActionRepositoryInterface {

    public function orderByName();

    public function paginate($count);

    public function find($id);

    public function set($role);

    public function create($input);

    public function update($input);

    public function setRoles($actionIds);

    public function delete();

} 