<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataTables\RolePermissionDataTable;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Requests\CreateRolePermissionRequest;
use App\Requests\UpdateRolePermissionRequest;
use App\Repositories\RolePermissionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RolePermissionController extends Controller
{
    /** @var  RolePermissionRepository */
    private $rolePermissionRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var PermissionRepository
     */
    private $permissionRepository;

    public function __construct(
        RolePermissionRepository $rolePermissionRepo,
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository
    )
    {
        $this->rolePermissionRepository = $rolePermissionRepo;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the RolePermission.
     *
     * @param RolePermissionDataTable $rolePermissionDataTable
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Request $request, RolePermissionDataTable $rolePermissionDataTable)
    {
        $roleId = $request->input('role_id');
        if (empty($roleId)) return redirect()->route('roles.index');

        $role = $this->roleRepository->find($roleId);
        if (empty($role)) return redirect()->route('roles.index');

        $permissionOptions = $this->permissionRepository->getToForm('name');
        return $rolePermissionDataTable
            ->render('role_permissions.index', [
                "permissionOptions" => $permissionOptions,
                "roleId" => $roleId,
            ]);
    }

    /**
     * Store a newly created RolePermission in storage.
     *
     * @param CreateRolePermissionRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateRolePermissionRequest $request): JsonResponse
    {
        $input = $request->all();
        $role = $this->roleRepository->find($input['role_id']);
        $permissions = array_filter($input['permission_id'], function ($value) {
            return !empty($value);
        });

        if (empty($role))
            return $this->error(__('crud.add_failed'));


        $role->permissions()->sync($permissions);

        return $this->success(__('crud.add_success', ['model' => Str::lower(__('models/rolePermission.singular'))]));
    }

    /**
     * Remove the specified RolePermission from storage.
     *
     * @param  int $id
     *
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $roleId = $request->input('role_id');
        if (empty($roleId)) return $this->error(__("crud.delete_failed"));

        $role = $this->roleRepository->find($roleId);
        if (empty($role)) return $this->error(__("crud.delete_failed"));

        try {
            $role->permissions()->detach($id);
            return $this->success(__('crud.delete_success'));
        } catch (\Exception $e) {
            return $this->error(__('crud.delete_failed'));
        }
    }
}
