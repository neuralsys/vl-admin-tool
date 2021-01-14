<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vuongdq\VLAdminTool\DataTables\DBConfigDataTable;
use Vuongdq\VLAdminTool\Repositories\DBTypeRepository;
use Vuongdq\VLAdminTool\Requests\CreateDBConfigRequest;
use Vuongdq\VLAdminTool\Requests\UpdateDBConfigRequest;
use Vuongdq\VLAdminTool\Repositories\DBConfigRepository;

class DBConfigController extends Controller
{
    /** @var  DBConfigRepository */
    private $dBConfigRepository;
    /**
     * @var DBTypeRepository
     */
    private $DBTypeRepository;

    public function __construct(
        DBConfigRepository $dBConfigRepo,
        DBTypeRepository $DBTypeRepository
    )
    {
        $this->dBConfigRepository = $dBConfigRepo;
        $this->DBTypeRepository = $DBTypeRepository;
    }

    /**
     * Display a listing of the DBConfig.
     *
     * @param DBConfigDataTable $dBConfigDataTable
     * @param Request $request
     * @return Response
     */
    public function index(DBConfigDataTable $dBConfigDataTable, Request $request)
    {
        $dbTypes = $this->DBTypeRepository->getDBTypes();
        $dbTypesSelector = [];
        foreach ($dbTypes as $dbType)
            $dbTypesSelector[$dbType] = $dbType;

        return $dBConfigDataTable->render('vl-admin-tool::d_b_configs.index', [
            "fieldId" => $request->input("field_id"),
            "dbTypes" => $dbTypesSelector
        ]);
    }

    /**
     * Store a newly created DBConfig in storage.
     *
     * @param CreateDBConfigRequest $request
     *
     * @return Response
     */
    public function store(CreateDBConfigRequest $request)
    {
        $input = $request->all();

        $dBConfig = $this->dBConfigRepository->create($input);

        return $this->success(__('crud.add_success'));
    }

    /**
     * Display the specified DBConfig.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $dBConfig = $this->dBConfigRepository->find($id);

        if (empty($dBConfig)) {
            return redirect(route('d_b_configs.index'));
        }

        return view('vl-admin-tool::d_b_configs.show')->with('dBConfig', $dBConfig);
    }

    /**
     * Update the specified DBConfig in storage.
     *
     * @param  int              $id
     * @param UpdateDBConfigRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDBConfigRequest $request)
    {
        $dBConfig = $this->dBConfigRepository->find($id);

        if (empty($dBConfig)) {
            return $this->error(__('crud.not_found'));
        }

        $dBConfig = $this->dBConfigRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
    }

    /**
     * Remove the specified DBConfig from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $dBConfig = $this->dBConfigRepository->find($id);

        if (empty($dBConfig)) {
            return $this->error(__('crud.not_found'));
        }

        $this->dBConfigRepository->delete($id);

        return $this->success(__('crud.delete_success'));
    }
}
