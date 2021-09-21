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
        return $translationFileDataTable->render('vl-admin-tool::translation_files.index');
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

        return $this->success(__('crud.add_success'));
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
            return redirect(route('translation_files.index'));
        }

        return view('vl-admin-tool::translation_files.show')->with('translationFile', $translationFile);
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
            return $this->error(__('crud.not_found'));
        }

        $translationFile = $this->translationFileRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
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
            return $this->error(__('crud.not_found'));
        }

        $this->translationFileRepository->delete($id);

        return $this->success(__('crud.delete_success'));
    }
}
