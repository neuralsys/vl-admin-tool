<?php

namespace Vuongdq\VLAdminTool;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Vuongdq\VLAdminTool\Commands\API\APIControllerGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\API\APIRequestsGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\API\TestsGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\APIScaffoldGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\Common\MigrationGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\Common\ModelGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\Common\RepositoryGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\InstallCommand;
use Vuongdq\VLAdminTool\Commands\MigrateCommand;
use Vuongdq\VLAdminTool\Commands\Publish\GeneratorPublishCommand;
use Vuongdq\VLAdminTool\Commands\Publish\LayoutPublishCommand;
use Vuongdq\VLAdminTool\Commands\Publish\PublishTemplateCommand;
use Vuongdq\VLAdminTool\Commands\Publish\PublishUserCommand;
use Vuongdq\VLAdminTool\Commands\RollbackGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\Scaffold\ControllerGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\Scaffold\RequestsGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\Scaffold\ScaffoldGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\Scaffold\ViewsGeneratorCommand;
use Vuongdq\VLAdminTool\Commands\SeedingCommand;
use Vuongdq\VLAdminTool\Commands\UninstallCommand;
use Vuongdq\VLAdminTool\Middleware\VLAdminToolMiddleware;

class VLAdminToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'vl-admin-tool');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'vl-admin-tool-lang');

        # config
        $configPath = __DIR__ . '/../config/vl_admin_tool.php';
        $this->publishes([
            $configPath => config_path('vl_admin_tool.php'),
        ]);

        $this->commands([
            InstallCommand::class,
            UninstallCommand::class,
        ]);

        $router->aliasMiddleware('admin.user', VLAdminToolMiddleware::class);
        $this->app->register('Vuongdq\VLAdminTool\Providers\VLAdminToolRouteServiceProvider');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('vlat.publish', function ($app) {
            return new GeneratorPublishCommand();
        });

        $this->app->singleton('vlat.migrate', function ($app) {
            return new MigrateCommand();
        });

        $this->app->singleton('vlat.seed', function ($app) {
            return new SeedingCommand();
        });

        $this->app->singleton('vlat.scaffold', function ($app) {
            return new ScaffoldGeneratorCommand();
        });

        $this->app->singleton('vlat.publish.layout', function ($app) {
            return new LayoutPublishCommand();
        });

        $this->app->singleton('vlat.publish.templates', function ($app) {
            return new PublishTemplateCommand();
        });

        $this->app->singleton('vlat.api_scaffold', function ($app) {
            return new APIScaffoldGeneratorCommand();
        });

        $this->app->singleton('vlat.migration', function ($app) {
            return new MigrationGeneratorCommand();
        });

        $this->app->singleton('vlat.model', function ($app) {
            return new ModelGeneratorCommand();
        });

        $this->app->singleton('vlat.repository', function ($app) {
            return new RepositoryGeneratorCommand();
        });

        $this->app->singleton('vlat.api.controller', function ($app) {
            return new APIControllerGeneratorCommand();
        });

        $this->app->singleton('vlat.api.requests', function ($app) {
            return new APIRequestsGeneratorCommand();
        });

        $this->app->singleton('vlat.api.tests', function ($app) {
            return new TestsGeneratorCommand();
        });

        $this->app->singleton('vlat.scaffold.controller', function ($app) {
            return new ControllerGeneratorCommand();
        });

        $this->app->singleton('vlat.scaffold.requests', function ($app) {
            return new RequestsGeneratorCommand();
        });

        $this->app->singleton('vlat.scaffold.views', function ($app) {
            return new ViewsGeneratorCommand();
        });

        $this->app->singleton('vlat.rollback', function ($app) {
            return new RollbackGeneratorCommand();
        });

        $this->app->singleton('vlat.publish.user', function ($app) {
            return new PublishUserCommand();
        });

        $this->commands([
            'vlat.publish',
            'vlat.migrate',
            'vlat.seed',
            'vlat.scaffold',
            'vlat.api_scaffold',
            'vlat.publish.layout',
            'vlat.publish.templates',
            'vlat.migration',
            'vlat.model',
            'vlat.repository',
            'vlat.api.controller',
            'vlat.api.requests',
            'vlat.api.tests',
            'vlat.scaffold.controller',
            'vlat.scaffold.requests',
            'vlat.scaffold.views',
            'vlat.rollback',
            'vlat.publish.user',
        ]);

        $configPath = __DIR__ . '/../config/vl_admin_tool.php';
        $this->mergeConfigFrom($configPath, 'vl_admin_tool');
    }
}
