<?php

namespace Vuongdq\VLAdminTool\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
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
use Vuongdq\VLAdminTool\Generators\SeederGenerator;
use Vuongdq\VLAdminTool\Repositories\ModelRepository;
use Vuongdq\VLAdminTool\Utils\FileUtil;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BaseCommand extends Command
{
    /**
     * The command Data.
     *
     * @var CommandData
     */
    public $commandData;

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

    public function handle()
    {
        $this->commandData->modelName = $this->argument('model');
        $this->commandData->modelObject = app(ModelRepository::class)
            ->where('class_name', $this->commandData->modelName)
            ->first();

        if (is_null($this->commandData->modelObject)) {
            $this->commandData->commandError("Model " . $this->commandData->modelName . " not found!");
            return 1;
        }

        $options = $this->getOptions();
        $res = [];
        foreach ($options as $option)
            $res[] = $option[0];

        $this->commandData->initCommandData($res);
        $this->commandData->getFields();
        return 0;
    }

    public function generateCommonItems()
    {
        if (!$this->isSkip('migration')) {
            $migrationGenerator = new MigrationGenerator($this->commandData);
            $migrationGenerator->generate();
        }

        if (!$this->isSkip('model')) {
            $modelGenerator = new ModelGenerator($this->commandData);
            $modelGenerator->generate();
        }

        if (!$this->isSkip('repository')) {
            $repositoryGenerator = new RepositoryGenerator($this->commandData);
            $repositoryGenerator->generate();
        }

        if (!$this->isSkip('factory')) {
            $factoryGenerator = new FactoryGenerator($this->commandData);
            $factoryGenerator->generate();
        }

        if (!$this->isSkip('seeder')) {
            $seederGenerator = new SeederGenerator($this->commandData);
            $seederGenerator->generate();
            $seederGenerator->updateMainSeeder();
        }
    }

    public function generateAPIItems()
    {
        if (!$this->isSkip('requests') and !$this->isSkip('api_requests')) {
            $requestGenerator = new APIRequestGenerator($this->commandData);
            $requestGenerator->generate();
        }

        if (!$this->isSkip('controllers') and !$this->isSkip('api_controller')) {
            $controllerGenerator = new APIControllerGenerator($this->commandData);
            $controllerGenerator->generate();
        }

        if (!$this->isSkip('routes') and !$this->isSkip('api_routes')) {
            $routesGenerator = new APIRoutesGenerator($this->commandData);
            $routesGenerator->generate();
        }

        if (!$this->isSkip('tests') and $this->commandData->getAddOn('tests')) {
            if ($this->commandData->getOption('repositoryPattern')) {
                $repositoryTestGenerator = new RepositoryTestGenerator($this->commandData);
                $repositoryTestGenerator->generate();
            }

            $apiTestGenerator = new APITestGenerator($this->commandData);
            $apiTestGenerator->generate();
        }
    }

    public function generateScaffoldItems()
    {
        if (!$this->isSkip('requests')) {
            $requestGenerator = new RequestGenerator($this->commandData);
            $requestGenerator->generate();
        }

        if (!$this->isSkip('controller')) {
            $controllerGenerator = new ControllerGenerator($this->commandData);
            $controllerGenerator->generate();
        }

        if (!$this->isSkip('views')) {
            $viewGenerator = new ViewGenerator($this->commandData);
            $viewGenerator->generate();
        }

        if (!$this->isSkip('routes')) {
            $routeGenerator = new RoutesGenerator($this->commandData);
            $routeGenerator->generate();
        }

        if (!$this->isSkip('menu')) {
            $menuGenerator = new MenuGenerator($this->commandData);
            $menuGenerator->generate();
        }
    }

    public function findOldMigration() {
        $tableName = $this->commandData->dynamicVars['$TABLE_NAME$'];
        $mainText = 'create_'.strtolower($tableName).'_table.php';
        $rootPath = base_path();
        $migrationFolder = $rootPath.'/database/migrations';
        $files = scandir($migrationFolder);
        foreach ($files as $file) {
            if (strpos( $file, $mainText ) !== false)
                return str_replace($rootPath."/", '', $migrationFolder.'/'.$file);
        }
        return null;
    }

    public function performPreActions()
    {
        if (!$this->isSkip('migration')) {
            $migrationFile = $this->findOldMigration();
            if ($migrationFile !== null) {
                $this->call("migrate:refresh --seed", ['--force' => true]);
            }
        }
    }

    public function performPostActions($runMigration = false)
    {
        $this->saveLocaleFile();

        if (!$this->isSkip('dump-autoload')) {
            $this->info('Generating autoload files');
            $this->composer->dumpOptimized();
        }
    }

    public function runMigration()
    {
        $migrationPath = config('vl_admin_tool.path.migration', database_path('migrations/'));
        $path = Str::after($migrationPath, base_path()); // get path after base_path
        $this->call('migrate', ['--path' => $path, '--force' => true]);

        return true;
    }

    public function isSkip($skip)
    {
        if ($this->commandData->getOption('skip')) {
            return in_array($skip, $this->commandData->getOption('skip'));
        }

        return false;
    }

    public function performPreActionsWithMigration()
    {
        $this->performPreActions();
    }

    public function performPostActionsWithMigration()
    {
        $this->performPostActions(true);
    }

    private function saveSchemaFile()
    {
        $fileFields = [];

        foreach ($this->commandData->fields as $field) {
            $fileFields[] = [
                'name'        => $field->name,
                'dbType'      => $field->dbInput,
                'htmlType'    => $field->htmlInput,
                'validations' => $field->validations,
                'searchable'  => $field->isSearchable,
                'fillable'    => $field->isFillable,
                'primary'     => $field->isPrimary,
                'inForm'      => $field->inForm,
                'inIndex'     => $field->inIndex,
                'inView'      => $field->inView,
            ];
        }

        foreach ($this->commandData->relations as $relation) {
            $fileFields[] = [
                'type'     => 'relation',
                'relation' => $relation->type.','.implode(',', $relation->inputs),
            ];
        }

        $path = config('admin_generator.path.schema_files', resource_path('model_schemas/'));

        $fileName = $this->commandData->modelName.'.json';

        if (file_exists($path.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }
        FileUtil::createFile($path, $fileName, json_encode($fileFields, JSON_PRETTY_PRINT));
        $this->commandData->commandComment("\nSchema File saved: ");
        $this->commandData->commandInfo($fileName);

        return $fileName;
    }

    private function saveLocaleFile()
    {
        $locales = [
            'singular' => Str::title(str_replace('_', ' ', $this->commandData->config->mSingular)),
            'plural'   => Str::title(str_replace('_', ' ', $this->commandData->config->mPlural)),
            'fields'   => [],
        ];

        foreach ($this->commandData->fields as $field) {
            $locales['fields'][$field->name] = Str::title(str_replace('_', ' ', $field->name));
        }

        $path = config('vl_admin_tool.path.models_locale_files', base_path('resources/lang/en/models/'));

        $fileName = $this->commandData->config->mCamel.'.php';

        if (file_exists($path.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }
        $content = "<?php\n\nreturn ".var_export($locales, true).';'.\PHP_EOL;
        FileUtil::createFile($path, $fileName, $content);
        $this->commandData->commandComment("\nModels Locale File saved: ");
        $this->commandData->commandInfo($fileName);
    }

    /**
     * @param $fileName
     * @param string $prompt
     *
     * @return bool
     */
    protected function confirmOverwrite($fileName, $prompt = '')
    {
        $force = $this->hasOption('force') && $this->option('force');
        $prompt = (empty($prompt))
            ? $fileName.' already exists. Do you want to overwrite it? [y|N]'
            : $prompt;

        if ($force) return true;
        return $this->confirm($prompt, false);
    }

    public function getPrefixKeysFromConfig() {
        return array_keys(config('vl-admin-tool.prefixes', []));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        $finalOptions = [
            # common options
            ['skip', null, InputOption::VALUE_OPTIONAL, 'Skip Specific Items to Generate (migration,model,controllers,api_controller,scaffold_controller,repository,requests,api_requests,scaffold_requests,routes,api_routes,scaffold_routes,views,tests,menu,dump-autoload)'],
            ['force', null, InputOption::VALUE_NONE, 'Force update'],
        ];

        $prefixKeys = $this->getPrefixKeysFromConfig();
        foreach ($prefixKeys as $prefixKey) {
            $optionString = 'prefix_' . $prefixKey;
            $option = [$optionString, null, InputOption::VALUE_OPTIONAL, "Set Prefix For $prefixKey"];
            $finalOptions[] = $option;
        }

        return $finalOptions;
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

    /**
     * get migration folder of tool
     * @return string
     */
    public function getToolMigrationFolder() {
        $rootPath = $this->getPackagePath();
        return $rootPath.'/database/migrations';
    }

    public function getPackagePath() {
        $basePath = str_replace("\\", "/", base_path('') . '/');
        $fullPath = str_replace("\\", "/", dirname(realpath(__DIR__.'/../')));
        $relativePath = str_replace($basePath, '', $fullPath);
        return $relativePath;
    }

    public function getAdminTableNames() {
        return [
            'models',
            'crud_configs',
            'db_configs',
            'dt_configs',
            'fields',
            'lang',
            'menus',
            'relations',
            'translations',
            'translation_files',
        ];
    }
}
