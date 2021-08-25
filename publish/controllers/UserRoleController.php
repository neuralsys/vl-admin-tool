<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\DataTables\UserRoleDataTable;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Requests\CreateUserRoleRequest;
use App\Requests\UpdateUserRoleRequest;
use App\Repositories\UserRoleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class UserRoleController extends Controller
{
    /** @var  UserRoleRepository */
    private $userRoleRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(
        UserRoleRepository $userRoleRepo,
        UserRepository $userRepository,
        RoleRepository $roleRepository
    )
    {
        $this->userRoleRepository = $userRoleRepo;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the UserRole.
     *
     * @param UserRoleDataTable $userRoleDataTable
     * @return View|JsonResponse
     */
    public function index(UserRoleDataTable $userRoleDataTable)
    {
        $userIdOptions = $this->userRepository->getToForm('email');
        $roleIdOptions = $this->roleRepository->getToForm('title');

        return $userRoleDataTable
            ->render('user_roles.index', [
                "userIdOptions" => $userIdOptions,
                "roleIdOptions" => $roleIdOptions
            ]);
    }

    /**
     * Store a newly created UserRole in storage.
     *
     * @param CreateUserRoleRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateUserRoleRequest $request): JsonResponse
    {
        $input = $request->all();

        $userRole = $this->userRoleRepository->create($input);

        return $this->success(__('crud.add_success', ['model' => Str::lower(__('models/userRole.singular'))]));
    }

    /**
     * Display the specified UserRole.
     *
     * @param  int $id
     *
     * @return View
     */
    public function show(int $id): View
    {
        $userRole = $this->userRoleRepository->find($id);

        if (empty($userRole)) {
            return redirect(route('user_roles.index'));
        }

        return view('user_roles.show')->with('userRole', $userRole);
    }

    /**
     * Update the specified UserRole in storage.
     *
     * @param  int $id
     * @param UpdateUserRoleRequest $request
     *
     * @return JsonResponse
     */
    public function update(int $id, UpdateUserRoleRequest $request): JsonResponse
    {
        $userRole = $this->userRoleRepository->find($id);

        if (empty($userRole)) {
            return $this->error(__('crud.not_found'));
        }

        $userRole = $this->userRoleRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
    }

    /**
     * Remove the specified UserRole from storage.
     *
     * @param  int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->userRoleRepository->delete($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error(__('crud.not_found'));
        } catch (\Exception $e) {
            return $this->error(__('crud.delete_failed'));
        }

        return $this->success(__('crud.delete_success'));
    }
}
