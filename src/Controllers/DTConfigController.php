<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Vuongdq\VLAdminTool\DataTables\DTConfigDataTable;
use Vuongdq\VLAdminTool\Requests\CreateDTConfigRequest;
use Vuongdq\VLAdminTool\Requests\UpdateDTConfigRequest;
use Vuongdq\VLAdminTool\Repositories\DTConfigRepository;

class DTConfigController extends Controller
{
    /** @var  DTConfigRepository */
    private $dTConfigRepository;

    public function __construct(DTConfigRepository $dTConfigRepo)
    {
        $this->dTConfigRepository = $dTConfigRepo;
    }

    /**
     * Display a listing of the DTConfig.
     *
     * @param DTConfigDataTable $dTConfigDataTable
     * @return Response
     */
    public function index(DTConfigDataTable $dTConfigDataTable)
    {
        return $dTConfigDataTable->render('d_t_configs.index');
    }

    /**
     * Store a newly created DTConfig in storage.
     *
     * @param CreateDTConfigRequest $request
     *
     * @return Response
     */
    public function store(CreateDTConfigRequest $request)
    {
        $input = $request->all();

        $dTConfig = $this->dTConfigRepository->create($input);

        return $this->success(__('crud.add_success'));
    }

    /**
     * Display the specified DTConfig.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dTConfig = $this->dTConfigRepository->find($id);

        if (empty($dTConfig)) {
            return redirect(route('d_t_configs.index'));
        }

        return view('d_t_configs.show')->with('dTConfig', $dTConfig);
    }

    /**
     * Update the specified DTConfig in storage.
     *
     * @param  int              $id
     * @param UpdateDTConfigRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDTConfigRequest $request)
    {
        $dTConfig = $this->dTConfigRepository->find($id);

        if (empty($dTConfig)) {
            return $this->error(__('crud.not_found'));
        }

        $dTConfig = $this->dTConfigRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
    }

    /**
     * Remove the specified DTConfig from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dTConfig = $this->dTConfigRepository->find($id);

        if (empty($dTConfig)) {
            return $this->error(__('crud.not_found'));
        }

        $this->dTConfigRepository->delete($id);

        return $this->success(__('crud.delete_success'));
    }
}
