<?php

namespace Vuongdq\VLAdminTool\Generators\Scaffold;

use Illuminate\Support\Str;
use Vuongdq\VLAdminTool\Common\CommandData;

class RoutesGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $existRouteContents;

    /** @var string */
    private $routeContents;

    /** @var string */
    private $routesTemplate;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathRoutes;
        $this->existRouteContents = file_get_contents($this->path);
        $this->routesTemplate = get_template('scaffold.routes.prefix_routes', 'vl-admin-tool');
        $this->routeContents = fill_template($this->commandData->dynamicVars, $this->routesTemplate);
    }

    public function generate()
    {
//        dd($this->routeContents);
//        dd($this->existRouteContents);
        if (Str::contains($this->existRouteContents, "group(['prefix' => '".$this->commandData->config->mSnakePlural."'], function (\$router) ")) {
            $this->commandData->commandObj->info('Route '.$this->commandData->config->mPlural.' is already exists, Skipping Adjustment.');
            return;
        }

        file_put_contents($this->path, $this->existRouteContents."\n\n{$this->routeContents}");
        $this->commandData->commandComment("\n".$this->commandData->config->mCamelPlural.' routes added.');
    }

    public function rollback()
    {
        if (Str::contains($this->routeContents, $this->routesTemplate)) {
            $this->routeContents = str_replace($this->routesTemplate, '', $this->routeContents);
            file_put_contents($this->path, $this->routeContents);
            $this->commandData->commandComment('scaffold routes deleted');
        }
    }
}
