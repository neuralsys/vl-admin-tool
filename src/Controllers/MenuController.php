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
        return $menuDataTable->render('menus.index');
    }

    /**
     * Show the form for creating a new Menu.
     *
     * @return Response
     */
    public function create()
    {
        return view('menus.create');
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

        Flash::success(__('messages.saved', ['model' => __('models/menus.singular')]));

        return redirect(route('menus.index'));
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
            Flash::error(__('models/menus.singular').' '.__('messages.not_found'));

            return redirect(route('menus.index'));
        }

        return view('menus.show')->with('menu', $menu);
    }

    /**
     * Show the form for editing the specified Menu.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $menu = $this->menuRepository->find($id);

        if (empty($menu)) {
            Flash::error(__('messages.not_found', ['model' => __('models/menus.singular')]));

            return redirect(route('menus.index'));
        }

        return view('menus.edit')->with('menu', $menu);
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
            Flash::error(__('messages.not_found', ['model' => __('models/menus.singular')]));

            return redirect(route('menus.index'));
        }

        $menu = $this->menuRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/menus.singular')]));

        return redirect(route('menus.index'));
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
            Flash::error(__('messages.not_found', ['model' => __('models/menus.singular')]));

            return redirect(route('menus.index'));
        }

        $this->menuRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/menus.singular')]));

        return redirect(route('menus.index'));
    }
}
