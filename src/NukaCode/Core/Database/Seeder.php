<?php namespace NukaCode\Core\Database;

use Illuminate\Database\Seeder as BaseSeeder;
use NukaCode\Core\Models\Seed;

class Seeder extends BaseSeeder {

    /**
     * Seed the given connection from the given path.
     *
     * @param  string  $class
     * @return void
     */
    public function call($class)
    {
        if (Seed::whereName($class)->count() == 0) {
            Seed::create(['name' => $class]);
        }

        parent::call($class);
    }

}