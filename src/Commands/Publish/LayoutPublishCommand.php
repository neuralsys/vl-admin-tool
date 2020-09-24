<?php

namespace Vuongdq\VLAdminTool\Commands\Publish;

use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Utils\FileUtil;
use Symfony\Component\Console\Input\InputOption;

class LayoutPublishCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'vlat.publish:layout';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes auth files';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {

    }

    private function copyView()
    {
        $viewsPath = config('admin_generator.path.views', resource_path('views/'));
        $templateType = config('admin_generator.templates', 'adminlte-templates');

        $this->createDirectories($viewsPath);

        $files = $this->getLocaleViews();

        foreach ($files as $stub => $blade) {
            $sourceFile = get_template_file_path('scaffold/'.$stub, $templateType);
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
            'layouts/app_locale'        => 'layouts/app.blade.php',
            'layouts/sidebar_locale'    => 'layouts/sidebar.blade.php',
            'layouts/datatables_css'    => 'layouts/datatables_css.blade.php',
            'layouts/datatables_js'     => 'layouts/datatables_js.blade.php',
            'layouts/menu'              => 'layouts/menu.blade.php',
            'layouts/home'              => 'home.blade.php',
            'auth/login_locale'         => 'auth/login.blade.php',
            'auth/register_locale'      => 'auth/register.blade.php',
            'auth/email_locale'         => 'auth/passwords/email.blade.php',
            'auth/reset_locale'         => 'auth/passwords/reset.blade.php',
            'emails/password_locale'    => 'auth/emails/password.blade.php',
        ];
    }

    private function updateRoutes()
    {
        $path = config('admin_generator.path.routes', base_path('routes/web.php'));

        $prompt = 'Existing routes web.php file detected. Should we add standard auth routes? (y|N) :';
        if (file_exists($path) && !$this->confirmOverwrite($path, $prompt)) {
            return;
        }

        $routeContents = file_get_contents($path);

        $routesTemplate = get_template('routes.auth', 'vl-admin-tool');

        $routeContents .= "\n\n".$routesTemplate;

        file_put_contents($path, $routeContents);
        $this->comment("\nRoutes added");
    }

    private function publishHomeController()
    {
        $templateData = get_template('home_controller', 'vl-admin-tool');

        $templateData = $this->fillTemplate($templateData);

        $controllerPath = config('admin_generator.path.controller', app_path('Http/Controllers/'));

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
    private function fillTemplate($templateData)
    {
        $templateData = str_replace(
            '$NAMESPACE_CONTROLLER$',
            config('admin_generator.namespace.controller'),
            $templateData
        );

        $templateData = str_replace(
            '$NAMESPACE_REQUEST$',
            config('admin_generator.namespace.request'),
            $templateData
        );

        return $templateData;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
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
}
