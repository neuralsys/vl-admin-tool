<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Vuongdq\VLAdminTool\DataTables\FieldDataTable;
use Vuongdq\VLAdminTool\Repositories\CRUDConfigRepository;
use Vuongdq\VLAdminTool\Repositories\DBConfigRepository;
use Vuongdq\VLAdminTool\Repositories\DTConfigRepository;
use Vuongdq\VLAdminTool\Repositories\DBTypeRepository;
use Vuongdq\VLAdminTool\Repositories\ViewTemplateRepository;
use Vuongdq\VLAdminTool\Requests\CreateFieldRequest;
use Vuongdq\VLAdminTool\Requests\UpdateFieldRequest;
use Vuongdq\VLAdminTool\Repositories\FieldRepository;

class FieldController extends Controller
{
    /** @var  FieldRepository */
    private $fieldRepository;
    /**
     * @var ViewTemplateRepository
     */
    private $viewTemplateRepository;

    /**
     * @var DBTypeRepository
     */
    private $dBTypeRepository;
    /**
     * @var DBConfigRepository
     */
    private $dBConfigRepository;
    /**
     * @var DTConfigRepository
     */
    private $dTConfigRepository;
    /**
     * @var CRUDConfigRepository
     */
    private $cRUDConfigRepository;

    public function __construct(
        FieldRepository $fieldRepo,
        ViewTemplateRepository $viewTemplateRepository,
        DBTypeRepository $DBTypeRepository,
        DBConfigRepository $dBConfigRepository,
        DTConfigRepository $dTConfigRepository,
        CRUDConfigRepository $CRUDConfigRepository
    )
    {
        $this->fieldRepository = $fieldRepo;
        $this->viewTemplateRepository = $viewTemplateRepository;
        $this->dBTypeRepository = $DBTypeRepository;
        $this->dBConfigRepository = $dBConfigRepository;
        $this->dTConfigRepository = $dTConfigRepository;
        $this->cRUDConfigRepository = $CRUDConfigRepository;
    }

    /**
     * Display a listing of the Field.
     *
     * @param FieldDataTable $fieldDataTable
     * @return Response
     */
    public function index(FieldDataTable $fieldDataTable, Request $request)
    {
        if (empty($request->input('model_id')))
            return redirect()->route("models.index");

        $fieldTypes = $this->viewTemplateRepository->getFieldTypes();
        $fieldTypesSelector = [];
        foreach ($fieldTypes as $fieldType)
            $fieldTypesSelector[$fieldType] = $fieldType;

        $dbTypes = $this->dBTypeRepository->getDBTypes();
        $dbTypesSelector = [];
        foreach ($dbTypes as $dbType)
            $dbTypesSelector[$dbType] = $dbType;

        return $fieldDataTable->render('vl-admin-tool::fields.index', [
            "model_id" => $request->input("model_id"),
            'fieldTypes' => $fieldTypesSelector,
            "dbTypes" => $dbTypesSelector,
        ]);
    }

    /**
     * Store a newly created Field in storage.
     *
     * @param CreateFieldRequest $request
     *
     * @return Response
     */
    public function store(CreateFieldRequest $request)
    {
        try {
            DB::beginTransaction();
            $fieldData = $request->only($this->fieldRepository->getFillable());
            $field = $this->fieldRepository->create($fieldData);

            $dbConfigData = $request->only($this->dBConfigRepository->getFillable());
            $dbConfigData['field_id'] = $field->id;
            $dbConfigData = $this->dBConfigRepository->create($dbConfigData);

            $dtConfigData = $request->only($this->dTConfigRepository->getFillable());
            $dtConfigData['field_id'] = $field->id;
            $dtConfigData = $this->dTConfigRepository->create($dtConfigData);

            $crudConfigData = $request->only($this->cRUDConfigRepository->getFillable());
            $crudConfigData['field_id'] = $field->id;
            $crudConfigData = $this->cRUDConfigRepository->create($crudConfigData);
            DB::commit();
            return $this->success(__('crud.add_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    /**
     * Display the specified Field.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $field = $this->fieldRepository->find($id);

        if (empty($field)) {
            return redirect(route('fields.index'));
        }

        return view('vl-admin-tool::fields.show')->with('field', $field);
    }

    /**
     * Update the specified Field in storage.
     *
     * @param  int              $id
     * @param UpdateFieldRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFieldRequest $request)
    {
        $field = $this->fieldRepository->find($id);

        if (empty($field)) {
            return $this->error(__('crud.not_found'));
        }

        try {
            DB::beginTransaction();
            $fieldData = $request->only($this->fieldRepository->getFillable());
            $this->fieldRepository->update($fieldData, $id);

            $dbConfigData = $request->only($this->dBConfigRepository->getFillable());
            $this->dBConfigRepository->update($dbConfigData, $field->dbConfig->id);

            $dtConfigData = $request->only($this->dTConfigRepository->getFillable());
            $this->dTConfigRepository->update($dtConfigData, $field->dtConfig->id);

            $crudConfigData = $request->only($this->cRUDConfigRepository->getFillable());
            $this->cRUDConfigRepository->update($crudConfigData, $field->crudConfig->id);
            DB::commit();
            return $this->success(__('crud.update_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }
    }

    /**
     * Remove the specified Field from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $field = $this->fieldRepository->find($id);

        if (empty($field)) {
            return $this->error(__('crud.not_found'));
        }

        $this->fieldRepository->delete($id);

        return $this->success(__('crud.delete_success'));
    }
}
