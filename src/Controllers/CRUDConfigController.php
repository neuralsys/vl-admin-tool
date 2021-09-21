<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vuongdq\VLAdminTool\DataTables\CRUDConfigDataTable;
use Vuongdq\VLAdminTool\Requests\CreateCRUDConfigRequest;
use Vuongdq\VLAdminTool\Requests\UpdateCRUDConfigRequest;
use Vuongdq\VLAdminTool\Repositories\CRUDConfigRepository;

class CRUDConfigController extends Controller
{
    /** @var  CRUDConfigRepository */
    private $cRUDConfigRepository;

    public function __construct(CRUDConfigRepository $cRUDConfigRepo)
    {
        $this->cRUDConfigRepository = $cRUDConfigRepo;
    }

    /**
     * Display a listing of the CRUDConfig.
     *
     * @param CRUDConfigDataTable $cRUDConfigDataTable
     * @return Response
     */
    public function index(CRUDConfigDataTable $cRUDConfigDataTable, Request $request)
    {
        return $cRUDConfigDataTable->render('vl-admin-tool::c_r_u_d_configs.index', [
            "field_id" => $request->input("field_id")
        ]);
    }

    /**
     * Store a newly created CRUDConfig in storage.
     *
     * @param CreateCRUDConfigRequest $request
     *
     * @return Response
     */
    public function store(CreateCRUDConfigRequest $request)
    {
        $input = $request->all();

        $cRUDConfig = $this->cRUDConfigRepository->create($input);

        return $this->success(__('crud.add_success'));
    }

    /**
     * Display the specified CRUDConfig.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $cRUDConfig = $this->cRUDConfigRepository->find($id);

        if (empty($cRUDConfig)) {
            return redirect(route('c_r_u_d_configs.index'));
        }

        return view('vl-admin-tool::c_r_u_d_configs.show')->with('cRUDConfig', $cRUDConfig);
    }

    /**
     * Update the specified CRUDConfig in storage.
     *
     * @param  int              $id
     * @param UpdateCRUDConfigRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCRUDConfigRequest $request)
    {
        $cRUDConfig = $this->cRUDConfigRepository->find($id);

        if (empty($cRUDConfig)) {
            return $this->error(__('crud.not_found'));
        }

        $cRUDConfig = $this->cRUDConfigRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
    }

    /**
     * Remove the specified CRUDConfig from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $cRUDConfig = $this->cRUDConfigRepository->find($id);

        if (empty($cRUDConfig)) {
            return $this->error(__('crud.not_found'));
        }

        $this->cRUDConfigRepository->delete($id);

        return $this->success(__('crud.delete_success'));
    }
}
