<?php

namespace Vuongdq\VLAdminTool\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vuongdq\VLAdminTool\Models\DTConfig;

class CreateDTConfigRequest extends FormRequest
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
            'field_id' => 'required',
            'showable' => 'required|boolean',
            'searchable' => 'required|boolean',
            'orderable' => 'required|boolean',
            'exportable' => 'required|boolean',
            'printable' => 'required|boolean',
            'class' => 'nullable|string|max:255',
            'has_footer' => 'required|boolean'
        ];
    }
}
