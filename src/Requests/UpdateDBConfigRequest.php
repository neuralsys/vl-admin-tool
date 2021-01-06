<?php

namespace Vuongdq\VLAdminTool\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vuongdq\VLAdminTool\Models\DBConfig;

class UpdateDBConfigRequest extends FormRequest
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
            'field_id' => 'required',
                'type' => 'required|string|max:45',
                'length' => 'nullable|integer',
                'nullable' => 'required|boolean',
                'unique' => 'required|boolean',
                'default' => 'nullable|string|max:255'
        ];
        
        return $rules;
    }
}
