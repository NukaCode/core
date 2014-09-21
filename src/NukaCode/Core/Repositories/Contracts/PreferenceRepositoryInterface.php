<?php namespace NukaCode\Core\Repositories\Contracts;

interface PreferenceRepositoryInterface {

    public function find($id);

    public function orderByName();

    public function paginate($count);

    public function delete();

    public function set($preference);

    public function create($input);

    public function update($input);
}