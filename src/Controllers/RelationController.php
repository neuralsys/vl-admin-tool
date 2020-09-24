<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Vuongdq\VLAdminTool\DataTables\RelationDataTable;
use Vuongdq\VLAdminTool\Requests\CreateRelationRequest;
use Vuongdq\VLAdminTool\Requests\UpdateRelationRequest;
use Vuongdq\VLAdminTool\Repositories\RelationRepository;

class RelationController extends Controller
{
    /** @var  RelationRepository */
    private $relationRepository;

    public function __construct(RelationRepository $relationRepo)
    {
        $this->relationRepository = $relationRepo;
    }

    /**
     * Display a listing of the Relation.
     *
     * @param RelationDataTable $relationDataTable
     * @return Response
     */
    public function index(RelationDataTable $relationDataTable)
    {
        return $relationDataTable->render('relations.index');
    }

    /**
     * Show the form for creating a new Relation.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('relations.create');
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

        Flash::success(__('messages.saved', ['model' => __('models/relations.singular')]));

        return redirect(route('relations.index'));
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
            Flash::error(__('models/relations.singular').' '.__('messages.not_found'));

            return redirect(route('relations.index'));
        }

        return view('relations.show')->with('relation', $relation);
    }

    /**
     * Show the form for editing the specified Relation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $relation = $this->relationRepository->find($id);

        if (empty($relation)) {
            Flash::error(__('messages.not_found', ['model' => __('models/relations.singular')]));

            return redirect(route('relations.index'));
        }

        return view('relations.edit')->with('relation', $relation);
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
            Flash::error(__('messages.not_found', ['model' => __('models/relations.singular')]));

            return redirect(route('relations.index'));
        }

        $relation = $this->relationRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/relations.singular')]));

        return redirect(route('relations.index'));
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
            Flash::error(__('messages.not_found', ['model' => __('models/relations.singular')]));

            return redirect(route('relations.index'));
        }

        $this->relationRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/relations.singular')]));

        return redirect(route('relations.index'));
    }
}
