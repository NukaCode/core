<?php namespace NukaCode\Core\Database;

use Illuminate\Console\Application;
use Illuminate\Filesystem\Filesystem;
use NukaCode\Core\Models\Migration;
use NukaCode\Core\Models\Seed;
use Symfony\Component\Console\Output\StreamOutput;

class Migrating {

	protected $file;

	protected $application;

	protected $stream;

	protected $nukaDirectories;

	protected $migrationDirectory;

	protected $seedDirectory;

	public function __construct(Filesystem $file, Application $application)
	{
		$this->file        = $file;
		$this->application = $application;

		// Set up the variables
		$this->stream             = fopen('php://output', 'w');
		$this->nukaDirectories    = $this->file->directories(base_path('vendor/nukacode'));
		$this->migrationDirectory = '/src/database/migrations';
		$this->seedDirectory      = '/src/database/seeds';
	}

	public function reset()
	{
		foreach ($this->nukaDirectories as $nukaDirectory) {
			$package = $this->determinePackageName($nukaDirectory);

			// Handle the migrations
			if ($this->file->exists($nukaDirectory . $this->migrationDirectory)) {
				$this->resetMigrations($nukaDirectory, $package);
			}
		}
	}

	public function migrate($seedFlag)
	{
		foreach ($this->nukaDirectories as $nukaDirectory) {
			$package = $this->determinePackageName($nukaDirectory);

			// Handle the migrations
			$this->runMigrations($nukaDirectory, $package);

			// Handle the seeds
			if ($seedFlag) {
				$this->runSeeds($nukaDirectory, $package);
			}
		}
	}

	public function reseedTable($seederFileName)
	{
		// Run the seed
		$this->application->call('db:seed', ['--class' => $seederFileName], new StreamOutput($this->stream));

		echo($seederFileName . ' re-seeded!' . "\n");
	}

	/**
	 * Reset all migrations for a package
	 *
	 * @param $nukaDirectory
	 */
	private function resetMigrations($nukaDirectory, $package)
	{
		echo('Dropping ' . $package . ' migrations...' . "\n");

		// Set up a migration location
		$migrationLocation = str_replace(base_path() . '/', '', $nukaDirectory . $this->migrationDirectory);

		foreach ($this->file->files($migrationLocation) as $migration) {
			// Require the file so the class can be called
			$this->file->requireOnce($migration);

			$this->runMigrationDown($migration);
		}

		echo(ucwords($package) . ' migrations complete!' . "\n");
	}

	/**
	 * Run a set of migrations by package
	 *
	 * @param $nukaDirectory
	 * @param $package
	 */
	private function runMigrations($nukaDirectory, $package)
	{
		if ($this->file->exists($nukaDirectory . $this->migrationDirectory)) {
			// Set up a migration location application can use
			$migrationLocation = str_replace(base_path() . '/', '', $nukaDirectory . $this->migrationDirectory);

			echo('Running ' . $package . ' migrations...' . "\n");

			// Run the migrations
			$this->application->call('migrate', ['--path' => $migrationLocation], new StreamOutput($this->stream));

			echo(ucwords($package) . ' migrations complete!' . "\n");
		}
	}

	/**
	 * Find all database seeders to run
	 *
	 * @param $nukaDirectory
	 * @param $package
	 */
	private function runSeeds($nukaDirectory, $package)
	{
		if ($this->file->exists($nukaDirectory . $this->seedDirectory)) {
			$seeds = $this->file->files($nukaDirectory . $this->seedDirectory);

			if (count($seeds) > 0) {
				echo('Running ' . $package . ' seeds...' . "\n");

				$this->seedTables($package, $seeds);

				echo(ucwords($package) . ' seeds complete!' . "\n");
			}
		}
	}

	/**
	 * Run the database seeder and add it to the seed table
	 *
	 * @param $package
	 * @param $seeds
	 */
	private function seedTables($package, $seeds)
	{
		foreach ($seeds as $seed) {
			list($seeder, $seederKey) = $this->determineSeedeAndKey($package, $seed);

			// Do not run for any DatabaseSeeder files
			if (strpos($seeder, 'DatabaseSeeder') === false) {
				// Only run if the seed is not already in the database
				if (Seed::whereName($seederKey)->first() != null) {
					continue;
				}

				$this->seedTable($seeder, $seederKey);


				echo(ucwords($package) . ' ' . $seeder . ' seeded!' . "\n");
			}
		}
	}

	/**
	 * @param $nukaDirectory
	 *
	 * @return array|mixed
	 */
	private function determinePackageName($nukaDirectory)
	{
		$package = explode('/', $nukaDirectory);
		$package = end($package);

		return $package;
	}

	/**
	 * Run migration's down method and remove it from the migrations table.
	 *
	 * @param $migration
	 *
	 * @return mixed
	 */
	private function runMigrationDown($migration)
	{
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

	/**
	 * @param $seeder
	 * @param $seederKey
	 */
	private function seedTable($seeder, $seederKey)
	{
		// Run the seed
		$this->application->call('db:seed', ['--class' => $seeder], new StreamOutput($this->stream));

		// Add the seed to the table
		$newSeed       = new Seed;
		$newSeed->name = $seederKey;
		$newSeed->save();
	}

	/**
	 * @param $package
	 * @param $seed
	 *
	 * @return array
	 */
	private function determineSeedeAndKey($package, $seed)
	{
		$seeder    = explode('/', $seed);
		$seeder    = str_replace('.php', '', end($seeder));
		$seederKey = $package . '.' . $seeder;

		return [$seeder, $seederKey];
	}
} 