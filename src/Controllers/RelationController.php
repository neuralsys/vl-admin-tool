<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Vuongdq\VLAdminTool\DataTables\RelationDataTable;
use Vuongdq\VLAdminTool\Repositories\FieldRepository;
use Vuongdq\VLAdminTool\Requests\CreateRelationRequest;
use Vuongdq\VLAdminTool\Requests\UpdateRelationRequest;
use Vuongdq\VLAdminTool\Repositories\RelationRepository;

class RelationController extends Controller
{
    /** @var  RelationRepository */
    private $relationRepository;

    /** @var  FieldRepository */
    private $fieldRepository;

    public function __construct(
        RelationRepository $relationRepo,
        FieldRepository $fieldRepository
    )
    {
        $this->relationRepository = $relationRepo;
        $this->fieldRepository = $fieldRepository;
    }

    /**
     * Display a listing of the Relation.
     *
     * @param RelationDataTable $relationDataTable
     * @return Response
     */
    public function index(RelationDataTable $relationDataTable, Request $request)
    {
        if (empty($request->input('field_id')))
            return redirect()->route("fields.index");

        $fields = $this->fieldRepository->getFieldsForRelation($request->input('field_id'));
        $relationTypes = config('relations.relationTypes');

        return $relationDataTable->render('vl-admin-tool::relations.index', [
            "field_id" => $request->input("field_id"),
            "fields" => $fields,
            "relationTypes" => $relationTypes,
        ]);
    }

    /**
     * Store a newly created Relation in storage.
     *
     * @param CreateRelationRequest $request
     *
     * @return Response
     */
    public function store(CreateRelationRequest $request)
    {
        $input = $request->all();

        $relation = $this->relationRepository->create($input);

        return $this->success(__('crud.add_success'));
    }

    /**
     * Display the specified Relation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $relation = $this->relationRepository->find($id);

        if (empty($relation)) {
            return redirect(route('relations.index'));
        }

        return view('vl-admin-tool::relations.show')->with('relation', $relation);
    }

    /**
     * Update the specified Relation in storage.
     *
     * @param  int              $id
     * @param UpdateRelationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRelationRequest $request)
    {
        $relation = $this->relationRepository->find($id);

        if (empty($relation)) {
            return $this->error(__('crud.not_found'));
        }

        $relation = $this->relationRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
    }

    /**
     * Remove the specified Relation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $relation = $this->relationRepository->find($id);

        if (empty($relation)) {
            return $this->error(__('crud.not_found'));
        }

        $this->relationRepository->delete($id);

        return $this->success(__('crud.delete_success'));
    }
}
