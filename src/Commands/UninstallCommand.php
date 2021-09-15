<?php

namespace Vuongdq\VLAdminTool\Commands;

class UninstallCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vlat:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall VL Admin Tool from project';

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
        $this->info('Uninstalling VL Admin Tool...');
        $this->removeTables();
        $composer = app()['composer'];
        $composer->dumpOptimized();
        $this->info('Uninstall VL Admin Tool successfully!');
        return 0;
    }

    private function removeTables() {
        $migrationFolder = $this->getToolMigrationFolder();

        $pathOption = ['--path' => $migrationFolder];
        $this->info('Dropping tables...');
        $this->call('migrate:reset', $pathOption);
        $this->info('Drop tables successfully!');
    }
}
