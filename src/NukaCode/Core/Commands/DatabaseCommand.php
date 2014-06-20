<?php namespace NukaCode\Core\Commands;

use Illuminate\Console\Command;
use NukaCode\Core\Database\Migrating;

class DatabaseCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nuka:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the nuka code core migration and seeds.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Migrating $migrating)
    {
        $this->migrating = $migrating;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->migrating->packageMigrations();
    }

}
