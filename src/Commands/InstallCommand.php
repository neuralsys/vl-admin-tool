<?php

namespace Vuongdq\VLAdminTool\Commands;

use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vlat:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install VL Admin Tool to project';

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
    public function handle() {
        $this->info('Installing VL Admin Tool...');
        $force = $this->hasOption('force') ? $this->option('force') : false;

        $this->call('ui', ['type' => 'bootstrap', '--auth' => true, '--no-interaction' => $force]);

        $this->call('vlat:publish', ['--force' => $force]);

        if (!$this->hasOption('skip-migration') || !$this->option('skip-migration'))
            $this->call('vlat:migrate', ['--force' => $force]);

        if (!$this->hasOption('skip-seeding') || !$this->option('skip-seeding'))
            $this->call('vlat:seed');


        $this->info('Install VL Admin Tool successfully!');
        return 0;
    }

    public function getOptions() {
        return [
            ['skip-migration', null, InputOption::VALUE_NONE, 'Skip migrating after install'],
            ['skip-seeding', null, InputOption::VALUE_NONE, 'Skip seeding after install'],
            ['force', null, InputOption::VALUE_NONE, 'Force install'],
        ];
    }

    public function getArguments() {
        return [];
    }
}
