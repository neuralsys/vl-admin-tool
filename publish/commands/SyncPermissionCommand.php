<?php

namespace App\Console\Commands;

use App\Repositories\PermissionRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route as Router;
use Illuminate\Routing\Route;

class SyncPermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync permission from routes automatically';
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        parent::__construct();
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $routeCollection = Router::getRoutes();

        $permissionIds = [];
        /* @var $route Route */
        foreach ($routeCollection as $route) {
            $routeName = getRouteNameFromRoute($route);
            if (strpos($routeName, "ignition") != false) continue;
            $routeCategory = $this->extractCategory($routeName);
            $routeURL = $route->uri();
            $routeMethod = implode("|", $route->methods());

            $permissionByName = $this->permissionRepository
                ->where('name', $routeName)
                ->first();
            $permissionByURL = $this->permissionRepository
                ->where('href', $routeURL)
                ->where('method', $routeMethod)
                ->first();

            $permission = $permissionByName ?? $permissionByURL;
            if (empty($permission)) {
                $permission = $this->permissionRepository->create([
                    'name' => $routeName,
                    'href' => $routeURL,
                    'method' => $routeMethod,
                    'category' => $routeCategory
                ]);
            } else {
                $permission->name = $routeName;
                $permission->href = $routeURL;
                $permission->method = $routeMethod;
                $permission->category = $routeCategory;
                $permission->save();
            }

            array_push($permissionIds, $permission->id);
        }

        $this->permissionRepository->whereNotIn('id', $permissionIds)->delete();
        return 0;
    }

    private function extractCategory($routeName)
    {
        if (strpos($routeName, ".") != false) return explode(".", $routeName)[0];
        return null;
    }
}
