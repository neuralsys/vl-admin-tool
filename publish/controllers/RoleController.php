<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataTables\RoleDataTable;
use App\Requests\CreateRoleRequest;
use App\Requests\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /** @var  RoleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepository = $roleRepo;
    }

    /**
     * Display a listing of the Role.
     *
     * @param RoleDataTable $roleDataTable
     * @return View|JsonResponse
     */
    public function index(RoleDataTable $roleDataTable)
    {
        return $roleDataTable
            ->render('roles.index');
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param CreateRoleRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateRoleRequest $request): JsonResponse
    {
        $input = $request->all();

        $role = $this->roleRepository->create($input);

        return $this->success(__('crud.add_success', ['model' => Str::lower(__('models/role.singular'))]));
    }

    /**
     * Display the specified Role.
     *
     * @param  int $id
     *
     * @return View
     */
    public function show(int $id): View
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            return redirect(route('roles.index'));
        }

        return view('roles.show')->with('role', $role);
    }

    /**
     * Update the specified Role in storage.
     *
     * @param  int $id
     * @param UpdateRoleRequest $request
     *
     * @return JsonResponse
     */
    public function update(int $id, UpdateRoleRequest $request): JsonResponse
    {
        $role = $this->roleRepository->find($id);

        if (empty($role)) {
            return $this->error(__('crud.not_found'));
        }

        $role = $this->roleRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param  int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->roleRepository->delete($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error(__('crud.not_found'));
        } catch (\Exception $e) {
            return $this->error(__('crud.delete_failed'));
        }

        return $this->success(__('crud.delete_success'));
    }
}
