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

        return $this->success(__('crud.add_success'));
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
            return redirect(route('langs.index'));
        }

        return view('langs.show')->with('lang', $lang);
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
            return $this->error(__('crud.not_found'));
        }

        $lang = $this->langRepository->update($request->all(), $id);

        return $this->success(__('crud.update_success'));
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
            return $this->error(__('crud.not_found'));
        }

        $this->langRepository->delete($id);

        return $this->success(__('crud.delete_success'));
    }
}
