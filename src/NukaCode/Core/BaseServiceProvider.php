<?php namespace NukaCode\Core;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

abstract class BaseServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    protected function loadAliases($aliases, $exclude)
    {
        $loader = AliasLoader::getInstance();

        foreach ($aliases as $alias => $class) {
            if (! in_array($alias, (array)$exclude)) {
                $loader->alias($alias, $class);
            }
        }
    }

    protected function getDatabaseFiles($path)
    {
        $dir = base_path($path);

        $migrations = \File::files($dir . '/migrations');
        $seeds      = \File::files($dir . '/seeds/');

        $databaseFiles = [$dir . '/seeds/' => base_path('database/seeds/')];
        $databaseFiles = $this->getMigrationDetails($migrations, $databaseFiles);

        $this->getSeedDetails($seeds);

        return $databaseFiles;
    }

    /**
     * @param $migrations
     * @param $databaseFiles
     *
     * @return mixed
     */
    private function getMigrationDetails($migrations, $databaseFiles)
    {
        if (count($migrations) > 0) {
            $time     = date('Y_m_d_Hi');
            $interval = 0;

            foreach ($migrations as $migration) {
                $fileName = explode('/', $migration);
                $fileName = end($fileName);

                // Since the times will be different each time this is run,
                // we have to check for any instance of the file name in the migrations directory
                // and ignore it if it exists.
                if (count(\File::glob(base_path('/database/migrations/*_' . $fileName))) > 0) {
                    continue;
                }

                $local  = $migration;
                $target = base_path('database/migrations/' . $time . $interval . '_' . $fileName);

                $databaseFiles[$local] = $target;

                $interval++;
            }

            return $databaseFiles;
        }

        return $databaseFiles;
    }

    /**
     * @param $seeds
     *
     * @return mixed
     */
    private function getSeedDetails($seeds)
    {
        $databaseSeeder = base_path('database/seeds/DatabaseSeeder.php');

        // Add seeders to DatabaseSeeder
        if (count($seeds) > 0) {
            foreach ($seeds as $seed) {
                $fileName = explode('/', $seed);
                $fileName = substr(end($fileName), 0, -4);

                $databaseSeederLines = file($databaseSeeder);

                // Make sure we haven't already added this seed to the seeder
                if ($this->checkSeederForSeed($fileName, $databaseSeederLines) == true) {
                    continue;
                }

                $call         = false;
                $inserted     = false;
                $previousLine = null;

                foreach ($databaseSeederLines as $key => $line) {
                    if (strpos($line, '$this->call') !== false) {
                        $call = true;
                    }

                    if ($call == true && strpos($line, '}') !== false && $inserted == false) {
                        $databaseSeederLines[$key - 1] = $previousLine . "\t\t" . '$this->call(\'' . $fileName . '\');' . "\n";
                        $inserted                      = true;
                    }

                    $previousLine = $line;
                }

                \File::delete($databaseSeeder);
                \File::put($databaseSeeder, implode($databaseSeederLines));
            }
        }
    }

    private function checkSeederForSeed($seed, $databaseSeederLines)
    {
        foreach ($databaseSeederLines as $line) {
            if (strpos($line, "'" . $seed . "'") !== false) {
                return true;
            }
        }

        return false;
    }

}