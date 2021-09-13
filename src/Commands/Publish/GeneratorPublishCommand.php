<?php

namespace Vuongdq\VLAdminTool\Commands\Publish;

use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Utils\FileUtil;
use Symfony\Component\Console\Input\InputOption;

class GeneratorPublishCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'vlat:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes & init api routes, base controller, base test cases traits.';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Publishing...');
        $this->updateConfigAuth();
        $this->copyView();
        $this->publishPublicFiles();
        $this->updateRoutes();
        $this->publishHomeController();
        $this->publishExceptionHandler();
        $this->publishTestCases();

        # publish base common objects
        $this->publishTraits();
        $this->publishMiddleware();
        $this->publishBaseController();
        $this->publishBaseRepository();
        $this->publishBaseLocaleFiles();

        # publish role permission objects
        $this->publishRolePermission();

        $this->info('Publish successfully!');
    }

    private function updateConfigAuth() {
        $authFile = config_path('auth.php');

        $content = file_get_contents($authFile);

        $newContent = str_replace("'model' => App\User::class", "'model' => App\Models\User::class", $content);

        file_put_contents($authFile, $newContent);

        $userPath = app_path('User.php');
        if (file_exists($userPath)) {
            $userContent = file_get_contents();
            $userContent = str_replace("namespace App;", "namespace App\Models;", $userContent);
            FileUtil::createDirectoryIfNotExist(app_path('Models'));
            file_put_contents(app_path('Models/User.php'), $userContent);
            FileUtil::deleteFile(app_path('/'), 'User.php');
        }
    }

    private function publishRolePermission()
    {
        $this->publishRolePermissionMigrationFiles();
        $this->publishRolePermissionSeedFiles();
        $this->publishRolePermissionModelFiles();
        $this->publishRolePermissionDataTableFiles();
        $this->publishRolePermissionControllerFiles();
        $this->publishRolePermissionCommandFiles();
        $this->publishRolePermissionRepositoryFiles();
        $this->publishRolePermissionRequestFiles();
        $this->publishRolePermissionViewFiles();
    }

    private function publishRolePermissionViewFiles() {
        $destinationPath = resource_path('views');
        $sourcePath = $this->getPackagePath() . '/publish/views';

        FileUtil::copyDirectory($sourcePath, $destinationPath, true);

        $this->comment('View files published');
    }

    private function publishRolePermissionRequestFiles() {
        $destinationPath = app_path('Requests');
        $sourcePath = $this->getPackagePath() . '/publish/requests';

        FileUtil::copyDirectory($sourcePath, $destinationPath, true);

        $this->comment('Request files published');
    }

    private function publishRolePermissionRepositoryFiles() {
        $destinationPath = app_path('Repositories');
        $sourcePath = $this->getPackagePath() . '/publish/repositories';

        FileUtil::copyDirectory($sourcePath, $destinationPath, true);

        $this->comment('Repository files published');
    }

    private function publishRolePermissionCommandFiles() {
        $destinationPath = app_path('Console/Commands');
        $sourcePath = $this->getPackagePath() . '/publish/commands';

        FileUtil::copyDirectory($sourcePath, $destinationPath, true);

        $this->comment('Command files published');
    }

    private function publishRolePermissionControllerFiles() {
        $destinationPath = app_path('Http/Controllers');
        $sourcePath = $this->getPackagePath() . '/publish/controllers';

        FileUtil::copyDirectory($sourcePath, $destinationPath, true);

        $this->comment('Controller files published');
    }

    private function publishRolePermissionDataTableFiles() {
        $destinationPath = app_path('DataTables');
        $sourcePath = $this->getPackagePath() . '/publish/datatables';

        FileUtil::copyDirectory($sourcePath, $destinationPath, true);

        $this->comment('DataTable files published');
    }

    private function publishRolePermissionModelFiles() {
        $modelPath = app_path('Models');
        $templateModelDir = $this->getPackagePath() . '/publish/models';

        FileUtil::copyDirectory($templateModelDir, $modelPath, true);

        $this->comment('Model files published');
    }

    private function publishRolePermissionMigrationFiles() {
        $migrationPath = database_path('migrations');
        $templateMigrationDir = $this->getPackagePath() . '/publish/migrations';
        FileUtil::copyDirectory($templateMigrationDir, $migrationPath, true);
        $this->comment('Migration files published');
    }

    private function publishRolePermissionSeedFiles() {
        $seedPath = database_path('seeds');
        $tempalteSeedDir = $this->getPackagePath() . '/publish/seeds';

        $files = array_diff(scandir($tempalteSeedDir), array('.', '..'));
        foreach ($files as $fileOrFolder) {
            $sourcePath = $tempalteSeedDir."/".$fileOrFolder;
            if (is_file($sourcePath)) {
                FileUtil::copyFile($tempalteSeedDir, $fileOrFolder, $seedPath, true);
                $this->updateMainSeeder($fileOrFolder);
                $this->info($fileOrFolder . " File created");
            }
        }

        $this->comment('Seed files published');
    }

    private function updateMainSeeder($fileName) {
        $fileName = str_replace(".php", "", $fileName);

        $mainSeederFile = database_path('seeds/DatabaseSeeder.php');

        $mainSeederContent = file_get_contents($mainSeederFile);

        $newSeederStatement = '$this->call('.$fileName.'::class);';

        if (strpos($mainSeederContent, $newSeederStatement) !== false) {
            $this->comment($fileName.' entry found in DatabaseSeeder. Skipping Adjustment.');
            return;
        }

        $newSeederStatement = infy_tabs(2).$newSeederStatement.infy_nl();

        preg_match_all('/\\$this->call\\((.*);/', $mainSeederContent, $matches);

        $totalMatches = count($matches[0]);
        $lastSeederStatement = $matches[0][$totalMatches - 1];

        $replacePosition = strpos($mainSeederContent, $lastSeederStatement);

        $mainSeederContent = substr_replace($mainSeederContent, $newSeederStatement, $replacePosition + strlen($lastSeederStatement) + 1, 0);

        file_put_contents($mainSeederFile, $mainSeederContent);
        $this->comment('Main Seeder file updated.');

    }

    /**
     * Replaces dynamic variables of template.
     *
     * @param string $templateData
     *
     * @return string
     */
    private function fillTemplate($templateData)
    {
        $apiVersion = config('vl_admin_tool.api_version', 'v1');
        $apiPrefix = config('vl_admin_tool.api_prefix', 'api');
        $traitNameSpace = config('vl_admin_tool.namespace.traits', 'App\Traits');

        $templateData = str_replace('$API_VERSION$', $apiVersion, $templateData);
        $templateData = str_replace('$API_PREFIX$', $apiPrefix, $templateData);
        $templateData = str_replace('$JSON_RESPONSE_TRAIT_NAMESPACE$', $traitNameSpace, $templateData);

        $appNamespace = $this->getLaravel()->getNamespace();
        $appNamespace = substr($appNamespace, 0, strlen($appNamespace) - 1);
        $templateData = str_replace('$NAMESPACE_APP$', $appNamespace, $templateData);

        return $templateData;
    }

    private function publishTestCases()
    {
        $testsPath = config('vl_admin_tool.path.tests', base_path('tests/'));
        $testsNameSpace = config('vl_admin_tool.namespace.tests', 'Tests');
        $createdAtField = config('vl_admin_tool.timestamps.created_at', 'created_at');
        $updatedAtField = config('vl_admin_tool.timestamps.updated_at', 'updated_at');

        $templateData = get_template('test.api_test_trait', 'vl-admin-tool');

        $templateData = str_replace('$NAMESPACE_TESTS$', $testsNameSpace, $templateData);
        $templateData = str_replace('$TIMESTAMPS$', "['$createdAtField', '$updatedAtField']", $templateData);

        $fileName = 'ApiTestTrait.php';

        if (file_exists($testsPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($testsPath, $fileName, $templateData);
        $this->info('ApiTestTrait created');

        $testAPIsPath = config('vl_admin_tool.path.api_test', base_path('tests/APIs/'));
        if (!file_exists($testAPIsPath)) {
            FileUtil::createDirectoryIfNotExist($testAPIsPath);
            $this->info('APIs Tests directory created');
        }

        $testRepositoriesPath = config('vl_admin_tool.path.repository_test', base_path('tests/Repositories/'));
        if (!file_exists($testRepositoriesPath)) {
            FileUtil::createDirectoryIfNotExist($testRepositoriesPath);
            $this->info('Repositories Tests directory created');
        }
    }

    public function publishExceptionHandler() {
        $exceptionFilePath = app_path('Exceptions/Handler.php');
        $stub = "scaffold.handler";
        $sourceFile = get_template_file_path($stub, "vl-admin-tool");
        $this->publishFile($sourceFile, $exceptionFilePath, "Handler.php");
    }

    private function publishBaseController()
    {
        $templateData = get_template('api_base_controller', 'vl-admin-tool');

        $templateData = $this->fillTemplate($templateData);

        $controllerPath = app_path('Http/Controllers/');

        $fileName = 'ApiBaseController.php';

        if (file_exists($controllerPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('ApiBaseController created');

        $templateData = get_template('base_controller', 'vl-admin-tool');

        $templateData = $this->fillTemplate($templateData);

        $controllerPath = app_path('Http/Controllers/');

        $fileName = 'Controller.php';

        if (file_exists($controllerPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('Controller created');
    }

    private function publishBaseRepository()
    {
        $templateData = get_template('base_repository', 'vl-admin-tool');

        $templateData = $this->fillTemplate($templateData);

        $repositoryPath = app_path('Repositories/');

        FileUtil::createDirectoryIfNotExist($repositoryPath);

        $fileName = 'BaseRepository.php';

        if (file_exists($repositoryPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($repositoryPath, $fileName, $templateData);

        $this->info('BaseRepository created');
    }

    private function publishPublicFiles()
    {
        $publicPath = public_path();
        $templateType = config('vl_admin_tool.templates', 'adminlte-templates');

        $tempaltePublicDir = get_templates_package_path($templateType) . "/public";

        $files = array_diff(scandir($tempaltePublicDir), array('.', '..'));
        foreach ($files as $fileOrFolder) {
            $sourcePath = $tempaltePublicDir."/".$fileOrFolder;
            if (is_file($sourcePath)) {
                FileUtil::copyFile($tempaltePublicDir, $fileOrFolder, $publicPath, true);
                $this->info($fileOrFolder . " File created");
            } elseif (is_dir($sourcePath)) {
                FileUtil::copyDirectory($sourcePath, $publicPath."/".$fileOrFolder, true);
                $this->info($fileOrFolder . " Folder created");
            }
        }

        $this->comment('Public files published');
    }

    private function publishBaseLocaleFiles()
    {
        $packageDir = $this->getPackagePath();
        $localesDir = $packageDir . '/publish/locale';
        FileUtil::copyDirectory($localesDir, resource_path('lang'), true);

        $this->comment('Locale files published');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            ['localized', null, InputOption::VALUE_NONE, 'Localize files.'],
            ['force', null, InputOption::VALUE_NONE, 'Force update'],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    private function publishMiddleware() {
        $middlewarePath = app_path('Http/Middleware');
        $tempalteMiddlewareDir = get_templates_package_path('vl-admin-tool') . "/publish/middleware";

        $files = array_diff(scandir($tempalteMiddlewareDir), array('.', '..'));
        foreach ($files as $fileOrFolder) {
            $sourcePath = $tempalteMiddlewareDir."/".$fileOrFolder;
            if (is_file($sourcePath)) {
                FileUtil::copyFile($tempalteMiddlewareDir, $fileOrFolder, $middlewarePath, true);
                $this->updateKernel($fileOrFolder);
                $this->info($fileOrFolder . " File created");
            }
        }

        $this->comment('Middleware files published');
    }

    private function updateKernel($fileName) {
        $fileName = str_replace(".php", "", $fileName);
        $kernelFilePath = app_path('Http/Kernel.php');
        $content = file_get_contents($kernelFilePath);
        $endLinePos = strpos($content, "];\n}\n");

        $middlewareName = Str::camel($fileName);
        $middlewareLine = "'$middlewareName' => $fileName::class,\n";
        if (strpos($content, $middlewareLine) !== false) {
            return;
        }
        $newContent = substr($content, 0, $endLinePos) . infy_tabs(1) . $middlewareLine . infy_tabs(1) . substr($content, $endLinePos);
        file_put_contents($kernelFilePath, $newContent);
    }

    private function publishTraits() {
        $templateData = get_template('traits.json_response_trait', 'vl-admin-tool');
        $traitNameSpace = config('vl_admin_tool.namespace.traits', 'App\Traits');

        $templateData = str_replace('$NAMESPACE$', $traitNameSpace, $templateData);

        $fileName = 'JsonResponse.php';
        $traitPath = config('vl_admin_tool.path.trait', app_path('Traits/'));
        if (file_exists($traitPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($traitPath, $fileName, $templateData);
        $this->info('JsonResponseTrait created');
    }

    private function copyView()
    {
        $viewsPath = config('vl_admin_tool.path.views', resource_path('views/'));
        $templateType = config('vl_admin_tool.templates', 'adminlte-templates');

        $this->createDirectories($viewsPath);

        $files = $this->getLocaleViews();

        foreach ($files as $stub => $blade) {
            $sourceFile = get_template_file_path($stub, $templateType);
            $destinationFile = $viewsPath.$blade;
            $this->publishFile($sourceFile, $destinationFile, $blade);
        }
    }

    private function createDirectories($viewsPath)
    {
        FileUtil::createDirectoryIfNotExist($viewsPath.'layouts');
        FileUtil::createDirectoryIfNotExist($viewsPath.'auth');

        FileUtil::createDirectoryIfNotExist($viewsPath.'auth/passwords');
        FileUtil::createDirectoryIfNotExist($viewsPath.'auth/emails');
    }

    private function getLocaleViews()
    {
        return [
            'layouts/app'        => 'layouts/app.blade.php',
            'layouts/auth'        => 'layouts/auth.blade.php',
            'layouts/sidebar'    => 'layouts/sidebar.blade.php',
            'layouts/navbar'    => 'layouts/navbar.blade.php',
            'layouts/datatables_css'    => 'layouts/datatables_css.blade.php',
            'layouts/datatables_js'     => 'layouts/datatables_js.blade.php',
            'layouts/menu'              => 'layouts/menu.blade.php',
            'layouts/home'              => 'home.blade.php',
            'auth/login'         => 'auth/login.blade.php',
            'auth/register'      => 'auth/register.blade.php',
            'auth/email'         => 'auth/passwords/email.blade.php',
            'auth/reset'         => 'auth/passwords/reset.blade.php',
            'emails/password'    => 'auth/emails/password.blade.php',
        ];
    }

    private function updateRoutes()
    {
        $path = config('vl_admin_tool.path.routes', base_path('routes/web.php'));

        $prompt = 'Existing routes web.php file detected. Should we add standard auth routes? (y|N) :';
        if (file_exists($path) && !$this->confirmOverwrite($path, $prompt)) {
            return;
        }

        $routeContents = $this->generateRoutes();

        file_put_contents($path, $routeContents);
        $this->comment("\nRoutes added");
    }

    public function generateRoutes() {
        $templateRoute = get_template('scaffold/routes/template_structure', 'vl-admin-tool');

        $rolePermissionRoutes = get_template('scaffold/routes/role_permission_routes', 'vl-admin-tool');
        $rolePermissionRoutes = prefix_tabs_each_line($rolePermissionRoutes);
        $authRoutes = get_template('scaffold/routes/auth', 'vl-admin-tool');

        return fill_template([
            '$AUTH_ROUTES$' => $authRoutes,
            '$DOMAIN_ROUTES$' => $rolePermissionRoutes,
        ], $templateRoute);
    }

    private function publishHomeController()
    {
        $templateData = get_template('home_controller', 'vl-admin-tool');

        $templateData = $this->fillHomeControllerTemplate($templateData);

        $controllerPath = config('vl_admin_tool.path.controller', app_path('Http/Controllers/'));

        $fileName = 'HomeController.php';

        if (file_exists($controllerPath.$fileName) && !$this->confirmOverwrite($fileName)) {
            return;
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('HomeController created');
    }

    /**
     * Replaces dynamic variables of template.
     *
     * @param string $templateData
     *
     * @return string
     */
    private function fillHomeControllerTemplate($templateData)
    {
        $templateData = str_replace(
            '$NAMESPACE_CONTROLLER$',
            config('vl_admin_tool.namespace.controller'),
            $templateData
        );

        $templateData = str_replace(
            '$NAMESPACE_REQUEST$',
            config('vl_admin_tool.namespace.request'),
            $templateData
        );

        return $templateData;
    }
}
