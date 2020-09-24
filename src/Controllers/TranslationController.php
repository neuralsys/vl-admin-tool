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
     * Show the form for creating a new Translation.
     *
     * @return Response
     */
    public function create()
    {
        return view('translations.create');
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

        Flash::success(__('messages.saved', ['model' => __('models/translations.singular')]));

        return redirect(route('translations.index'));
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
            Flash::error(__('models/translations.singular').' '.__('messages.not_found'));

            return redirect(route('translations.index'));
        }

        return view('translations.show')->with('translation', $translation);
    }

    /**
     * Show the form for editing the specified Translation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $translation = $this->translationRepository->find($id);

        if (empty($translation)) {
            Flash::error(__('messages.not_found', ['model' => __('models/translations.singular')]));

            return redirect(route('translations.index'));
        }

        return view('translations.edit')->with('translation', $translation);
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
            Flash::error(__('messages.not_found', ['model' => __('models/translations.singular')]));

            return redirect(route('translations.index'));
        }

        $translation = $this->translationRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/translations.singular')]));

        return redirect(route('translations.index'));
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
            Flash::error(__('messages.not_found', ['model' => __('models/translations.singular')]));

            return redirect(route('translations.index'));
        }

        $this->translationRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/translations.singular')]));

        return redirect(route('translations.index'));
    }
}
