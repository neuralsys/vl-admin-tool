<?php

namespace Vuongdq\VLAdminTool\Commands\Menu;

use Symfony\Component\Console\Input\InputOption;
use Vuongdq\VLAdminTool\Commands\BaseCommand;
use Vuongdq\VLAdminTool\Repositories\MenuRepository;

class InsertAdminMenuCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vlat.menu:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert VL Admin Tool To DB';

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
        $this->info('Inserting VL Admin Tool Menu...');
        $menuRepo = app(MenuRepository::class);
        try {
            $force = $this->option('force');
            $menuRepo->insertAdminMenu($force);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
        $this->info('Insert VL Admin Tool successfully!');
        return 0;
    }

    public function getOptions() {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force install'],
        ];
    }

    public function getArguments() {
        return [];
    }
}
