<?php

namespace Vuongdq\VLAdminTool\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vuongdq\VLAdminTool\Models\Field;

class CreateFieldRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'model_id' => 'required',
            'name' => 'required|string|max:255',
            'html_type' => 'required|string|max:255',

            # db
            'type' => 'required|string|max:45',
            'length' => 'sometimes|nullable|integer',
            'nullable' => 'sometimes|nullable|integer|in:0,1',
            'unique' => 'sometimes|nullable|integer|in:0,1',
            'default' => 'sometimes|nullable|string|max:255',

            # dt
            'showable' => 'required|boolean',
            'searchable' => 'required|boolean',
            'orderable' => 'required|boolean',
            'exportable' => 'required|boolean',
            'printable' => 'required|boolean',
            'class' => 'nullable|string|max:255',
            'has_footer' => 'required|boolean',

            # crud
            'creatable' => 'required|boolean',
            'editable' => 'required|boolean',
            'rules' => 'sometimes|nullable|string|max:255'
        ];
    }
}
