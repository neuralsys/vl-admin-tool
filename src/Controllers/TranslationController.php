<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Vuongdq\VLAdminTool\DataTables\TranslationDataTable;
use Vuongdq\VLAdminTool\Requests\CreateTranslationRequest;
use Vuongdq\VLAdminTool\Requests\UpdateTranslationRequest;
use Vuongdq\VLAdminTool\Repositories\TranslationRepository;

class TranslationController extends Controller
{
    /** @var  TranslationRepository */
    private $translationRepository;

    public function __construct(TranslationRepository $translationRepo)
    {
        $this->translationRepository = $translationRepo;
    }

    /**
     * Display a listing of the Translation.
     *
     * @param TranslationDataTable $translationDataTable
     * @return Response
     */
    public function index(TranslationDataTable $translationDataTable)
    {
        return $translationDataTable->render('translations.index');
    }

    /**
     * Store a newly created Translation in storage.
     *
     * @param CreateTranslationRequest $request
     *
     * @return Response
     */
    public function store(CreateTranslationRequest $request)
    {
        $input = $request->all();

        $translation = $this->translationRepository->create($input);

        return $this->success(__('crud.add_success'));
    }

    /**
     * Display the specified Translation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $translation = $this->translationRepository->find($id);

        if (empty($translation)) {
            return redirect(route('translations.index'));
        }

        return view('translations.show')->with('translation', $translation);
    }

    /**
     * Update the specified Translation in storage.
     *
     * @param  int              $id
     * @param UpdateTranslationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTranslationRequest $request)
    {
        $translation = $this->translationRepository->find($id);

        if (empty($translation)) {
            return $this->error(__('crud.not_found'));
        }

        $translation = $this->translationRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
    }

    /**
     * Remove the specified Translation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $translation = $this->translationRepository->find($id);

        if (empty($translation)) {
            return $this->error(__('crud.not_found'));
        }

        $this->translationRepository->delete($id);

        return $this->success(__('crud.delete_success'));
    }
}
