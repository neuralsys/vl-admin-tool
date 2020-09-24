<?php

namespace Vuongdq\VLAdminTool\Controllers;

use App\Http\Controllers\Controller;
use Vuongdq\VLAdminTool\DataTables\LangDataTable;
use Vuongdq\VLAdminTool\Requests\CreateLangRequest;
use Vuongdq\VLAdminTool\Requests\UpdateLangRequest;
use Vuongdq\VLAdminTool\Repositories\LangRepository;

class LangController extends Controller
{
    /** @var  LangRepository */
    private $langRepository;

    public function __construct(LangRepository $langRepo)
    {
        $this->langRepository = $langRepo;
    }

    /**
     * Display a listing of the Lang.
     *
     * @param LangDataTable $langDataTable
     * @return Response
     */
    public function index(LangDataTable $langDataTable)
    {
        return $langDataTable->render('langs.index');
    }

    /**
     * Show the form for creating a new Lang.
     *
     * @return Response
     */
    public function create()
    {
        return view('langs.create');
    }

    /**
     * Store a newly created Lang in storage.
     *
     * @param CreateLangRequest $request
     *
     * @return Response
     */
    public function store(CreateLangRequest $request)
    {
        $input = $request->all();

        $lang = $this->langRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/langs.singular')]));

        return redirect(route('langs.index'));
    }

    /**
     * Display the specified Lang.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $lang = $this->langRepository->find($id);

        if (empty($lang)) {
            Flash::error(__('models/langs.singular').' '.__('messages.not_found'));

            return redirect(route('langs.index'));
        }

        return view('langs.show')->with('lang', $lang);
    }

    /**
     * Show the form for editing the specified Lang.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $lang = $this->langRepository->find($id);

        if (empty($lang)) {
            Flash::error(__('messages.not_found', ['model' => __('models/langs.singular')]));

            return redirect(route('langs.index'));
        }

        return view('langs.edit')->with('lang', $lang);
    }

    /**
     * Update the specified Lang in storage.
     *
     * @param  int              $id
     * @param UpdateLangRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLangRequest $request)
    {
        $lang = $this->langRepository->find($id);

        if (empty($lang)) {
            Flash::error(__('messages.not_found', ['model' => __('models/langs.singular')]));

            return redirect(route('langs.index'));
        }

        $lang = $this->langRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/langs.singular')]));

        return redirect(route('langs.index'));
    }

    /**
     * Remove the specified Lang from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $lang = $this->langRepository->find($id);

        if (empty($lang)) {
            Flash::error(__('messages.not_found', ['model' => __('models/langs.singular')]));

            return redirect(route('langs.index'));
        }

        $this->langRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/langs.singular')]));

        return redirect(route('langs.index'));
    }
}
