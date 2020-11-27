<?php

namespace Vuongdq\VLAdminTool\Controllers;

use Vuongdq\VLAdminTool\DataTables\FieldDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateFieldRequest;
use App\Http\Requests\UpdateFieldRequest;
use App\Models\Field;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class FieldController extends AppBaseController
{
    /**
     * Display a listing of the Field.
     *
     * @param FieldDataTable $fieldDataTable
     * @return Response
     */
    public function index(FieldDataTable $fieldDataTable)
    {
        return $fieldDataTable->render('fields.index');
    }

    /**
     * Show the form for creating a new Field.
     *
     * @return Response
     */
    public function create()
    {
        return view('fields.create');
    }

    /**
     * Store a newly created Field in storage.
     *
     * @param CreateFieldRequest $request
     *
     * @return Response
     */
    public function store(CreateFieldRequest $request)
    {
        $input = $request->all();

        /** @var Field $field */
        $field = Field::create($input);

        Flash::success(__('messages.saved', ['model' => __('models/fields.singular')]));

        return redirect(route('fields.index'));
    }

    /**
     * Display the specified Field.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Field $field */
        $field = Field::find($id);

        if (empty($field)) {
            Flash::error(__('models/fields.singular').' '.__('messages.not_found'));

            return redirect(route('fields.index'));
        }

        return view('fields.show')->with('field', $field);
    }

    /**
     * Show the form for editing the specified Field.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Field $field */
        $field = Field::find($id);

        if (empty($field)) {
            Flash::error(__('messages.not_found', ['model' => __('models/fields.singular')]));

            return redirect(route('fields.index'));
        }

        return view('fields.edit')->with('field', $field);
    }

    /**
     * Update the specified Field in storage.
     *
     * @param  int              $id
     * @param UpdateFieldRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFieldRequest $request)
    {
        /** @var Field $field */
        $field = Field::find($id);

        if (empty($field)) {
            Flash::error(__('messages.not_found', ['model' => __('models/fields.singular')]));

            return redirect(route('fields.index'));
        }

        $field->fill($request->all());
        $field->save();

        Flash::success(__('messages.updated', ['model' => __('models/fields.singular')]));

        return redirect(route('fields.index'));
    }

    /**
     * Remove the specified Field from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Field $field */
        $field = Field::find($id);

        if (empty($field)) {
            Flash::error(__('messages.not_found', ['model' => __('models/fields.singular')]));

            return redirect(route('fields.index'));
        }

        $field->delete();

        Flash::success(__('messages.deleted', ['model' => __('models/fields.singular')]));

        return redirect(route('fields.index'));
    }
}
