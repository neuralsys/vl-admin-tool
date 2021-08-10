<?php

namespace Vuongdq\VLAdminTool\Commands;

use Illuminate\Console\Command;
use Vuongdq\VLAdminTool\Common\CommandData;
use Vuongdq\VLAdminTool\Generators\API\APIControllerGenerator;
use Vuongdq\VLAdminTool\Generators\API\APIRequestGenerator;
use Vuongdq\VLAdminTool\Generators\API\APIRoutesGenerator;
use Vuongdq\VLAdminTool\Generators\API\APITestGenerator;
use Vuongdq\VLAdminTool\Generators\FactoryGenerator;
use Vuongdq\VLAdminTool\Generators\MigrationGenerator;
use Vuongdq\VLAdminTool\Generators\ModelGenerator;
use Vuongdq\VLAdminTool\Generators\RepositoryGenerator;
use Vuongdq\VLAdminTool\Generators\RepositoryTestGenerator;
use Vuongdq\VLAdminTool\Generators\Scaffold\ControllerGenerator;
use Vuongdq\VLAdminTool\Generators\Scaffold\MenuGenerator;
use Vuongdq\VLAdminTool\Generators\Scaffold\RequestGenerator;
use Vuongdq\VLAdminTool\Generators\Scaffold\RoutesGenerator;
use Vuongdq\VLAdminTool\Generators\Scaffold\ViewGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Vuongdq\VLAdminTool\Models\Model;

class RollbackGeneratorCommand extends Command
{
    /**
     * The command Data.
     *
     * @var CommandData
     */
    public $commandData;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'vlat:rollback';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback a full CRUD API and Scaffold for given model';

    /**
     * @var Composer
     */
    public $composer;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->composer = app()['composer'];
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_SCAFFOLD);
        $this->commandData->config->mName = $this->commandData->modelName = $this->argument('model');

        $modelObj = Model::where('class_name', $this->commandData->modelName)->first();
        $this->commandData->modelObject = $modelObj;

        $this->commandData->config->init($this->commandData);

        $migrationGenerator = new MigrationGenerator($this->commandData);
        $migrationGenerator->rollback();

        $modelGenerator = new ModelGenerator($this->commandData);
        $modelGenerator->rollback();

        $repositoryGenerator = new RepositoryGenerator($this->commandData);
        $repositoryGenerator->rollback();

        $requestGenerator = new APIRequestGenerator($this->commandData);
        $requestGenerator->rollback();

        $controllerGenerator = new APIControllerGenerator($this->commandData);
        $controllerGenerator->rollback();

        $routesGenerator = new APIRoutesGenerator($this->commandData);
        $routesGenerator->rollback();

        $requestGenerator = new RequestGenerator($this->commandData);
        $requestGenerator->rollback();

        $controllerGenerator = new ControllerGenerator($this->commandData);
        $controllerGenerator->rollback();

        $viewGenerator = new ViewGenerator($this->commandData);
        $viewGenerator->rollback();

        $routeGenerator = new RoutesGenerator($this->commandData);
        $routeGenerator->rollback();

        $repositoryTestGenerator = new RepositoryTestGenerator($this->commandData);
        $repositoryTestGenerator->rollback();

        $apiTestGenerator = new APITestGenerator($this->commandData);
        $apiTestGenerator->rollback();

        $factoryGenerator = new FactoryGenerator($this->commandData);
        $factoryGenerator->rollback();

        $menuGenerator = new MenuGenerator($this->commandData);
        $menuGenerator->rollback();

        $this->info('Generating autoload files');
        $this->composer->dumpOptimized();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['model', InputArgument::REQUIRED, 'Singular Models name'],
        ];
    }
}
