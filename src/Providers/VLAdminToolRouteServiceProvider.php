<?php

namespace Vuongdq\VLAdminTool\Providers;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

class VLAdminToolRouteServiceProvider extends RouteServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    public function map() {
        parent::map();
        $this->mapVLAdminToolRoutes();
    }

    private function mapVLAdminToolRoutes() {
        Route::middleware('web')
            ->namespace('Vuongdq\VLAdminTool\Controllers')
            ->group(__DIR__.'/../../routes/web.php');
    }
}
