<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataTables\PermissionDataTable;
use App\Requests\CreatePermissionRequest;
use App\Requests\UpdatePermissionRequest;
use App\Repositories\PermissionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /** @var  PermissionRepository */
    private $permissionRepository;

    public function __construct(PermissionRepository $permissionRepo)
    {
        $this->permissionRepository = $permissionRepo;
    }

    /**
     * Display a listing of the Permission.
     *
     * @param PermissionDataTable $permissionDataTable
     * @return View|JsonResponse
     */
    public function index(PermissionDataTable $permissionDataTable)
    {
        return $permissionDataTable
            ->render('permissions.index');
    }

    public function sync() {
        try {
            $exitCode = Artisan::call("sync:permission");
            if ($exitCode === 0) {
                return $this->success("Sync permission successfully!");
            } else {
                return $this->error("Sync permission failed, exit code=$exitCode!");
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
