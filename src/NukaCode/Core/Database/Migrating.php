<?php namespace NukaCode\Core\Database;

use Illuminate\Console\Application;
use Illuminate\Filesystem\Filesystem;
use NukaCode\Core\Models\Migration;
use NukaCode\Core\Models\Seed;
use Symfony\Component\Console\Output\StreamOutput;

class Migrating {

	protected $file;

	protected $artisan;

	protected $stream;

	protected $nukaDirectories;

	protected $migrationDirectory;

	protected $seedDirectory;

	public function __construct(Filesystem $file, Application $artisan)
	{
		$this->file    = $file;
		$this->artisan = $artisan;

		// Set up the variables
		$this->stream             = fopen('php://output', 'w');
		$this->nukaDirectories    = $this->file->directories(base_path('vendor/nukacode'));
		$this->migrationDirectory = '/src/database/migrations';
		$this->seedDirectory      = '/src/database/seeds';
	}

	public function reset()
	{
		foreach ($this->nukaDirectories as $nukaDirectory) {
			$package = explode('/', $nukaDirectory);
			$package = end($package);

			// Handle the migrations
			if ($this->file->exists($nukaDirectory . $this->migrationDirectory)) {
				echo('Dropping ' . $package . ' migrations...' . "\n");

				// Set up a migration location
				$migrationLocation = str_replace(base_path() . '/', '', $nukaDirectory . $this->migrationDirectory);

				foreach ($this->file->files($migrationLocation) as $migration) {
					// Require the file so the class can be called
					$this->file->requireOnce($migration);

					// Remove .php from the file name
					$migrationFile = substr($migration, 0, -4);

					// Get the class name from the file name
					$file  = implode('_', array_slice(explode('_', $migrationFile), 4));
					$class = studly_case($file);

					// New up the class and run the down method
					$migration = new $class;
					$migration->down();

					// Remove the migration from the database table
					Migration::where('migration', last(explode('/', $migrationFile)))->delete();
				}

				echo(ucwords($package) . ' migrations complete!' . "\n");
			}
		}
	}

	public function migrate($seedFlag)
	{
		foreach ($this->nukaDirectories as $nukaDirectory) {
			$package = explode('/', $nukaDirectory);
			$package = end($package);

			// Handle the migrations
			if ($this->file->exists($nukaDirectory . $this->migrationDirectory)) {
				// Set up a migration location artisan can use
				$migrationLocation = str_replace(base_path() . '/', '', $nukaDirectory . $this->migrationDirectory);

				echo('Running ' . $package . ' migrations...' . "\n");

				// Run the migrations
				$this->artisan->call('migrate', array('--path' => $migrationLocation), new StreamOutput($this->stream));

				echo(ucwords($package) . ' migrations complete!' . "\n");
			}

			// Handle the seeds
			if ($seedFlag) {
				if ($this->file->exists($nukaDirectory . $this->seedDirectory)) {
					$seeds = $this->file->files($nukaDirectory . $this->seedDirectory);

					if (count($seeds) > 0) {
						echo('Running ' . $package . ' seeds...' . "\n");

						foreach ($seeds as $seed) {
							$seeder    = explode('/', $seed);
							$seeder    = str_replace('.php', '', end($seeder));
							$seederKey = $package . '.' . $seeder;

							// Do not run for any DatabaseSeeder files
							if (strpos($seeder, 'DatabaseSeeder') === false) {
								// Only run if the seed is not already in the database
								if (Seed::whereName($seederKey)->first() != null) {
									continue;
								}

								// Run the seed
								$this->artisan->call('db:seed', array('--class' => $seeder), new StreamOutput($this->stream));

								// Add the seed to the table
								$newSeed       = new Seed;
								$newSeed->name = $seederKey;
								$newSeed->save();

								echo(ucwords($package) . ' ' . $seeder . ' seeded!' . "\n");
							}
						}

						echo(ucwords($package) . ' seeds complete!' . "\n");
					}
				}
			}
		}
	}

	public function reseedRoles()
	{
		// Run the seed
		$this->artisan->call('db:seed', array('--class' => 'RolesTableSeeder'), new StreamOutput($this->stream));

		echo('Roles re-seeded!' . "\n");
	}
} 