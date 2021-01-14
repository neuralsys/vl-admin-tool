<?php

namespace Vuongdq\VLAdminTool\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vuongdq\VLAdminTool\Models\CRUDConfig;

class CreateCRUDConfigRequest extends FormRequest
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
            'creatable' => 'required|boolean',
            'editable' => 'required|boolean',
            'rules' => 'sometimes|nullable|string|max:255'
        ];
    }
}
