<?php

namespace Vuongdq\VLAdminTool\Commands;

class MigrateCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vlat:migrate
                            {--seed : Seed after migrate}
                            {--force : Force migrate}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate for VL Admin Tool';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Migrating...');
        $this->runToolMigration();
        $this->info('Migrate successfully!');
        return 0;
    }

    private function runToolMigration() {
        $migrationFolder = $this->getToolMigrationFolder();
        $force = $this->option('force');
        $pathOption = ['--path' => $migrationFolder];
        if ($force)
            $this->call('migrate:reset', $pathOption);

        $this->call('migrate', $pathOption);
    }
}
