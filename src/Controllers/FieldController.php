<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Vuongdq\VLAdminTool\DataTables\FieldDataTable;
use Vuongdq\VLAdminTool\Requests\CreateFieldRequest;
use Vuongdq\VLAdminTool\Requests\UpdateFieldRequest;
use Vuongdq\VLAdminTool\Repositories\FieldRepository;

class FieldController extends Controller
{
    /** @var  FieldRepository */
    private $fieldRepository;

    public function __construct(FieldRepository $fieldRepo)
    {
        $this->fieldRepository = $fieldRepo;
    }

    /**
     * Display a listing of the Field.
     *
     * @param FieldDataTable $fieldDataTable
     * @return Response
     */
    public function index(FieldDataTable $fieldDataTable)
    {
        return $fieldDataTable->render('vl-admin-tool::fields.index');
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
        $input = $request->all();

        $field = $this->fieldRepository->create($input);

        return $this->success(__('crud.add_success'));
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

        $field = $this->fieldRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
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
