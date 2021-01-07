<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Vuongdq\VLAdminTool\DataTables\MenuDataTable;
use Vuongdq\VLAdminTool\Requests\CreateMenuRequest;
use Vuongdq\VLAdminTool\Requests\UpdateMenuRequest;
use Vuongdq\VLAdminTool\Repositories\MenuRepository;

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
        return $menuDataTable->render('vl-admin-tool::menus.index');
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
     * @param  int $id
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
     * @param  int              $id
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
     * @param  int $id
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
}
