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
        if (Str::contains($this->existRouteContents, "group(['prefix' => '".$this->commandData->config->mSnakePlural."'], function (\$router) ")) {
            $this->commandData->commandObj->info('Route '.$this->commandData->config->mPlural.' is already exists, Skipping Adjustment.');
            return;
        }

        file_put_contents($this->path, $this->existRouteContents."\n{$this->routeContents}");
        $this->commandData->commandComment("\n".$this->commandData->config->mCamelPlural.' routes added.');
    }

    public function rollback()
    {
        $lines = explode("\n", $this->routeContents);
        for ($nTabs = 0; $nTabs <= 10; $nTabs++) {
            $contentWithTabs = "";
            foreach ($lines as $line) {
                if ($line != "") $contentWithTabs .= infy_tabs($nTabs).$line."\n";
            }
            if (Str::contains($this->existRouteContents, "\n{$contentWithTabs}")) {
                $this->existRouteContents = str_replace("\n{$contentWithTabs}", '', $this->existRouteContents);
                file_put_contents($this->path, $this->existRouteContents);
                $this->commandData->commandComment('Routes deleted');
                break;
            }
        }
    }
}
