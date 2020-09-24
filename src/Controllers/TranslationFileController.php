<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Vuongdq\VLAdminTool\DataTables\TranslationFileDataTable;
use Vuongdq\VLAdminTool\Requests\CreateTranslationFileRequest;
use Vuongdq\VLAdminTool\Requests\UpdateTranslationFileRequest;
use Vuongdq\VLAdminTool\Repositories\TranslationFileRepository;

class TranslationFileController extends Controller
{
    /** @var  TranslationFileRepository */
    private $translationFileRepository;

    public function __construct(TranslationFileRepository $translationFileRepo)
    {
        $this->translationFileRepository = $translationFileRepo;
    }

    /**
     * Display a listing of the TranslationFile.
     *
     * @param TranslationFileDataTable $translationFileDataTable
     * @return Response
     */
    public function index(TranslationFileDataTable $translationFileDataTable)
    {
        return $translationFileDataTable->render('translation_files.index');
    }

    /**
     * Show the form for creating a new TranslationFile.
     *
     * @return Response
     */
    public function create()
    {
        return view('translation_files.create');
    }

    /**
     * Store a newly created TranslationFile in storage.
     *
     * @param CreateTranslationFileRequest $request
     *
     * @return Response
     */
    public function store(CreateTranslationFileRequest $request)
    {
        $input = $request->all();

        $translationFile = $this->translationFileRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/translationFiles.singular')]));

        return redirect(route('translationFiles.index'));
    }

    /**
     * Display the specified TranslationFile.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $translationFile = $this->translationFileRepository->find($id);

        if (empty($translationFile)) {
            Flash::error(__('models/translationFiles.singular').' '.__('messages.not_found'));

            return redirect(route('translationFiles.index'));
        }

        return view('translation_files.show')->with('translationFile', $translationFile);
    }

    /**
     * Show the form for editing the specified TranslationFile.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $translationFile = $this->translationFileRepository->find($id);

        if (empty($translationFile)) {
            Flash::error(__('messages.not_found', ['model' => __('models/translationFiles.singular')]));

            return redirect(route('translationFiles.index'));
        }

        return view('translation_files.edit')->with('translationFile', $translationFile);
    }

    /**
     * Update the specified TranslationFile in storage.
     *
     * @param  int              $id
     * @param UpdateTranslationFileRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTranslationFileRequest $request)
    {
        $translationFile = $this->translationFileRepository->find($id);

        if (empty($translationFile)) {
            Flash::error(__('messages.not_found', ['model' => __('models/translationFiles.singular')]));

            return redirect(route('translationFiles.index'));
        }

        $translationFile = $this->translationFileRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/translationFiles.singular')]));

        return redirect(route('translationFiles.index'));
    }

    /**
     * Remove the specified TranslationFile from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $translationFile = $this->translationFileRepository->find($id);

        if (empty($translationFile)) {
            Flash::error(__('messages.not_found', ['model' => __('models/translationFiles.singular')]));

            return redirect(route('translationFiles.index'));
        }

        $this->translationFileRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/translationFiles.singular')]));

        return redirect(route('translationFiles.index'));
    }
}
