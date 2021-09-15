<?php

namespace Vuongdq\VLAdminTool;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Vuongdq\VLAdminTool\Commands\API\APIControllerGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\API\APIRequestsGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\API\TestsGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\APIScaffoldGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\BaseCommand;
use Vuongdq\VLAdminTool\Commands\Common\MigrationGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\Common\RepositoryGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\DBSyncCommand;
use Vuongdq\VLAdminTool\Commands\GenerateModelCommand;
use Vuongdq\VLAdminTool\Commands\InstallCommand;
use Vuongdq\VLAdminTool\Commands\Menu\GenerateMenuCommand;
use Vuongdq\VLAdminTool\Commands\Menu\InsertAdminMenuCommand;
use Vuongdq\VLAdminTool\Commands\MigrateCommand;
use Vuongdq\VLAdminTool\Commands\Publish\GeneratorPublishCommand;
use Vuongdq\VLAdminTool\Commands\Publish\LayoutPublishCommand;
use Vuongdq\VLAdminTool\Commands\Publish\PublishUserCommand;
use Vuongdq\VLAdminTool\Commands\RollbackGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\Scaffold\ControllerGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\Scaffold\RequestsGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\GenerateCommand;
use Vuongdq\VLAdminTool\Commands\Scaffold\ViewsGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\SeedingCommand;
use Vuongdq\VLAdminTool\Commands\SyncPermissionCommand;
use Vuongdq\VLAdminTool\Commands\UninstallCommand;
use Vuongdq\VLAdminTool\Middleware\VLAdminToolMiddleware;

class VLAdminToolServiceProvider extends ServiceProvider {
    /**
     * Bootstrap the application services.
     *
     * @param Router $router
     * @return void
     */
    public function boot(Router $router) {
        $packagePath = get_templates_package_path('vl-admin-tool');
        $this->loadViewsFrom( $packagePath . '/resources/views', 'vl-admin-tool');
        $this->loadTranslationsFrom($packagePath . '/resources/lang', 'vl-admin-tool-lang');

        # config
        $configPath = $packagePath . '/publish/config/vl_admin_tool.php';
        $relationsConstantsPath = $packagePath . '/publish/config/relations.php';
        $captchaPath = $packagePath . '/publish/config/captcha.php';

        $this->publishes([
            $configPath => config_path('vl_admin_tool.php'),
            $relationsConstantsPath => config_path('relations.php'),
            $captchaPath => config_path('captcha.php'),
        ], "config");

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                UninstallCommand::class,
            ]);
        }

        $router->aliasMiddleware('admin.user', VLAdminToolMiddleware::class);
        $this->app->register('Vuongdq\VLAdminTool\Providers\VLAdminToolRouteServiceProvider');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('vlat.publish', function ($app) {
            return new GeneratorPublishCommand();
        });

        $this->app->singleton('vlat.publish.layout', function ($app) {
            return new LayoutPublishCommand();
        });

        $this->app->singleton('vlat.migrate', function ($app) {
            return new MigrateCommand();
        });

        $this->app->singleton('vlat.seed', function ($app) {
            return new SeedingCommand();
        });

        $this->app->singleton('vlat.sync.db', function ($app) {
            return new DBSyncCommand();
        });

        $this->app->singleton('vlat.generate', function ($app) {
            return new GenerateCommand();
        });

        $this->app->singleton('vlat.generate.menu', function ($app) {
            return new GenerateMenuCommand();
        });

        $this->app->singleton('vlat.generate.model', function ($app) {
            return new GenerateModelCommand();
        });

        $this->app->singleton('vlat.rollback', function ($app) {
            return new RollbackGeneratorCommand();
        });

        $this->commands([
            # should run first time with install command
            'vlat.publish',
            'vlat.migrate',
            'vlat.seed',
            'vlat.sync.db',

            # run specific cases
            'vlat.generate.menu',
            'vlat.publish.layout',

            # generate model with elements
            'vlat.generate',

            # rollback
            'vlat.rollback',
        ]);

        $packagePath = get_templates_package_path('vl-admin-tool');

        $configPath = $packagePath . '/publish/config/vl_admin_tool.php';
        $this->mergeConfigFrom($configPath, 'vl_admin_tool');

        $relationsConstantsPath = $packagePath . '/publish/config/relations.php';
        $this->mergeConfigFrom($relationsConstantsPath, 'relations');

        $captchaPath = $packagePath . '/publish/config/captcha.php';
        $this->mergeConfigFrom($captchaPath, 'captcha');
    }
}
