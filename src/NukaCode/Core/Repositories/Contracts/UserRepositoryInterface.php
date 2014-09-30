<?php namespace NukaCode\Core\Repositories\Contracts;


interface UserRepositoryInterface {

    public function orderByName();

    public function paginate($count);

    public function find($id);

    public function set($user);

    public function create($data);

    public function update($data);

    public function setRoles($roleIds);

    public function updatePassword($data);
} 