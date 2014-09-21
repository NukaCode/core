<?php namespace NukaCode\Core\Database;

use Illuminate\Console\Application;
use Illuminate\Filesystem\Filesystem;
use NukaCode\Core\Models\Seed;
use Symfony\Component\Console\Output\StreamOutput;

class Migrating {

    protected $file;

    protected $artisan;

    public function __construct(Filesystem $file, Application $artisan)
    {
        $this->file    = $file;
        $this->artisan = $artisan;
    }

    public function packageMigrations ()
    {
        // Set up the variables
        $stream             = fopen('php://output', 'w');
        $nukaDirectories    = $this->file->directories(base_path('vendor/nukacode'));
        $migrationDirectory = '/src/database/migrations';
        $seedDirectory      = '/src/database/seeds';

        foreach ($nukaDirectories as $nukaDirectory) {
            $package = explode('/', $nukaDirectory);
            $package = end($package);

            // Handle the migrations
            if ($this->file->exists($nukaDirectory . $migrationDirectory)) {
                // Set up a migration location artisan can use
                $migrationLocation = str_replace(base_path() .'/', '', $nukaDirectory . $migrationDirectory);

                echo('Running '. $package .' migrations...'."\n");

                // Run the migrations
                $this->artisan->call('migrate', array('--path' => $migrationLocation), new StreamOutput($stream));

                echo(ucwords($package) .' migrations complete!'."\n");
            }

            // Handle the seeds
            if ($this->file->exists($nukaDirectory . $seedDirectory)) {
                $seeds = $this->file->files($nukaDirectory . $seedDirectory);

                if (count($seeds) > 0) {
                    echo('Running '. $package .' seeds...'."\n");

                    foreach ($seeds as $seed) {
                        $seeder = explode('/', $seed);
                        $seeder = str_replace('.php', '', end($seeder));

                        // Do not run for any DatabaseSeeder files
                        if (strpos($seeder, 'DatabaseSeeder') === false) {
                            // Only run if the seed is not already in the database
                            if (Seed::whereName($seeder)->first() != null) continue;

                            // Run the seed
                            $this->artisan->call('db:seed', array('--class' => $seeder), new StreamOutput($stream));

                            // Add the seed to the table
                            $newSeed       = new Seed;
                            $newSeed->name = $seeder;
                            $newSeed->save();

                            echo(ucwords($package) .' '. $seeder .' seeded!'."\n");
                        }
                    }

                    echo(ucwords($package) .' seeds complete!'."\n");
                }
            }
        }
    }
} 