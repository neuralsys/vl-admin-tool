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
     * Display a listing of the Model.
     *
     * @param ModelDataTable $modelDataTable
     * @return Response
     */
    public function index(ModelDataTable $modelDataTable)
    {
        return $modelDataTable->render('vl-admin-tool::models.index');
    }

    /**
     * Store a newly created Model in storage.
     *
     * @param CreateModelRequest $request
     *
     * @return Response
     */
    public function store(CreateModelRequest $request)
    {
        $input = $request->all();

        $model = $this->modelRepository->create($input);

        return $this->success(__('crud.add_success'));
    }

    /**
     * Display the specified Model.
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
     * Update the specified Model in storage.
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
            return $this->error(__('crud.not_found'));
        }

        $model = $this->modelRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
    }

    /**
     * Remove the specified Model from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $model = $this->modelRepository->find($id);

        if (empty($model)) {
            return $this->error(__('crud.not_found'));
        }

        $this->modelRepository->delete($id);

        return $this->success(__('crud.delete_success'));
    }
}
