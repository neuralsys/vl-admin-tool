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
        return $modelDataTable->render('models.index');
    }

    /**
     * Show the form for creating a new Models.
     *
     * @return Response
     */
    public function create()
    {
        return view('models.create');
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

        Flash::success(__('messages.saved', ['model' => __('models/models.singular')]));

        return redirect(route('models.index'));
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
            Flash::error(__('models/models.singular').' '.__('messages.not_found'));

            return redirect(route('models.index'));
        }

        return view('models.show')->with('model', $model);
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
            Flash::error(__('messages.not_found', ['model' => __('models/models.singular')]));

            return redirect(route('models.index'));
        }

        return view('models.edit')->with('model', $model);
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
            Flash::error(__('messages.not_found', ['model' => __('models/models.singular')]));

            return redirect(route('models.index'));
        }

        $model = $this->modelRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/models.singular')]));

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
            Flash::error(__('messages.not_found', ['model' => __('models/models.singular')]));

            return redirect(route('models.index'));
        }

        $this->modelRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/models.singular')]));

        return redirect(route('models.index'));
    }
}
