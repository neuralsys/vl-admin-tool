<?php

namespace Vuongdq\VLAdminTool\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vuongdq\VLAdminTool\Models\Field;

class UpdateFieldRequest extends FormRequest
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
        $rules = [
            'model_id' => 'required',
                'name' => 'required|string|max:255',
                'db_type' => 'required|string|max:255',
                'html_type' => 'required|string|max:255',
                'primary' => 'required|boolean',
                'unique' => 'required|boolean',
                'auto_increment' => 'required|boolean',
                'nullable' => 'required|boolean',
                'creatable' => 'required|boolean',
                'editable' => 'required|boolean',
                'created_at' => 'nullable',
                'updated_at' => 'nullable'
        ];
        
        return $rules;
    }
}
