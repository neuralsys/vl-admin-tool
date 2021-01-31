<?php

namespace Vuongdq\VLAdminTool\Commands;

use Symfony\Component\Console\Input\InputOption;

class SeedingCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vlat:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeding data for VL Admin Tool';

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
        $this->info('Seeding...');
        $class = $this->option('class');
        $this->call('db:seed', ['--class' => $class]);
        $this->info('Seed Database successfully!');
        return 0;
    }

    public function getArguments() {
        return [];
    }

    public function getOptions() {
        return [
            ['class', null, InputOption::VALUE_OPTIONAL, 'Class run seeding', 'Vuongdq\\VLAdminTool\\Database\\Seeder\\VLATSeeder']
        ];
    }
}
