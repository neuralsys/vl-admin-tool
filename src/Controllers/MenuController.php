<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Vuongdq\VLAdminTool\DataTables\MenuDataTable;
use Vuongdq\VLAdminTool\Requests\CreateMenuRequest;
use Vuongdq\VLAdminTool\Requests\UpdateMenuRequest;
use Vuongdq\VLAdminTool\Repositories\MenuRepository;
use Illuminate\Support\Facades\Artisan;

class MenuController extends Controller
{
    /** @var  MenuRepository */
    private $menuRepository;

    public function __construct(MenuRepository $menuRepo)
    {
        $this->menuRepository = $menuRepo;
    }

    /**
     * Display a listing of the Menu.
     *
     * @param MenuDataTable $menuDataTable
     * @return Response
     */
    public function index(MenuDataTable $menuDataTable)
    {
        $menuTypes = $this->menuRepository->getMenuTypes();
        $menuTypesSelector = [];
        foreach ($menuTypes as $menuType)
            $menuTypesSelector[$menuType] = $menuType;

        $parent = $this->menuRepository->getToForm('title', [
            ['type', '=', 'has-child']
        ]);

        $parent = [0 => 'Choose Parent'] + $parent;

        return $menuDataTable->render('vl-admin-tool::menus.index', [
            'menuTypes' => $menuTypesSelector,
            'parents' => $parent,
        ]);
    }

    /**
     * Store a newly created Menu in storage.
     *
     * @param CreateMenuRequest $request
     *
     * @return Response
     */
    public function store(CreateMenuRequest $request)
    {
        $input = $request->all();

        $menu = $this->menuRepository->create($input);

        return $this->success(__('crud.add_success'));
    }

    /**
     * Display the specified Menu.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $menu = $this->menuRepository->find($id);

        if (empty($menu)) {
            return redirect(route('menus.index'));
        }

        return view('vl-admin-tool::menus.show')->with('menu', $menu);
    }

    /**
     * Update the specified Menu in storage.
     *
     * @param int $id
     * @param UpdateMenuRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMenuRequest $request)
    {
        $menu = $this->menuRepository->find($id);

        if (empty($menu)) {
            return $this->error(__('crud.not_found'));
        }

        $menu = $this->menuRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
    }

    /**
     * Remove the specified Menu from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $menu = $this->menuRepository->find($id);

        if (empty($menu)) {
            return $this->error(__('crud.not_found'));
        }

        $this->menuRepository->delete($id);

        return $this->success(__('crud.delete_success'));
    }

    public function sync() {
        try {
            $exitCode = Artisan::call("vlat.generate:menu");
            if ($exitCode === 0) {
                return $this->success("Sync menu successfully!");
            } else {
                return $this->error("Sync menu failed, exit code=$exitCode!");
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}

