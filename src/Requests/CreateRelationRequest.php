<?php

namespace Vuongdq\VLAdminTool\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vuongdq\VLAdminTool\Models\Relation;

class CreateRelationRequest extends FormRequest
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
            'first_field_id' => 'required',
            'second_field_id' => 'required',
            'type' => 'required|string|max:255',
            'table_name' => 'nullable|string|max:255',
            'fk_1' => 'nullable|string|max:255',
            'fk_2' => 'nullable|string|max:255',
        ];
    }
}
