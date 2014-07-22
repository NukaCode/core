<?php namespace NukaCode\Core\Repositories\Contracts;

interface RoleRepositoryInterface {

    public function orderByName();

    public function paginate($count);

    public function find($id);

    public function set($role);

    public function create($input);

    public function update($input);

    public function setActions($actionIds);

    public function delete();
}