<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Vuongdq\VLAdminTool\DataTables\ModelDataTable;
use Vuongdq\VLAdminTool\Requests\CreateModelRequest;
use Vuongdq\VLAdminTool\Requests\UpdateModelRequest;
use Vuongdq\VLAdminTool\Repositories\ModelRepository;

class ModelController extends Controller
{
    /** @var  ModelRepository */
    private $modelRepository;

    public function __construct(ModelRepository $modelRepo)
    {
        $this->modelRepository = $modelRepo;
    }

    /**
     * Display a listing of the Models.
     *
     * @param ModelDataTable $modelDataTable
     * @return Response
     */
    public function index(ModelDataTable $modelDataTable)
    {
        return $modelDataTable->render('vl-admin-tool::models.index');
    }

    /**
     * Store a newly created Models in storage.
     *
     * @param CreateModelRequest $request
     *
     * @return Response
     */
    public function store(CreateModelRequest $request)
    {
        $input = $request->all();
        $model = $this->modelRepository->create($input);

        return $this->success(__('vl-admin-tool-lang::crud.add_success', ['model' => __('vl-admin-tool-lang::models/model.singular')]));
    }

    /**
     * Display the specified Models.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $model = $this->modelRepository->find($id);

        if (empty($model)) {
            return redirect(route('models.index'));
        }

        return view('vl-admin-tool::models.show')->with('model', $model);
    }

    /**
     * Show the form for editing the specified Models.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $model = $this->modelRepository->find($id);

        if (empty($model)) {
            return redirect(route('models.index'));
        }

        return view('vl-admin-tool::models.edit')->with('model', $model);
    }

    /**
     * Update the specified Models in storage.
     *
     * @param  int              $id
     * @param UpdateModelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateModelRequest $request)
    {
        $model = $this->modelRepository->find($id);

        if (empty($model)) {
            return redirect(route('models.index'));
        }

        $model = $this->modelRepository->update($request->all(), $id);

        return redirect(route('models.index'));
    }

    /**
     * Remove the specified Models from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $model = $this->modelRepository->find($id);

        if (empty($model)) {
            return redirect(route('models.index'));
        }

        $this->modelRepository->delete($id);

        return redirect(route('models.index'));
    }
}
