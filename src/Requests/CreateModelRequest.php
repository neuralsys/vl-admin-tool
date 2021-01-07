<?php

namespace Vuongdq\VLAdminTool\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vuongdq\VLAdminTool\Models\Model;

class CreateModelRequest extends FormRequest
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
            'class_name' => 'required|string|max:255',
            'table_name' => 'required|string|max:255',
            'singular' => 'required|string|max:255',
            'plural' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timestamps' => 'required|boolean',
            'soft_delete' => 'required|boolean',
            'created_at' => 'nullable',
            'updated_at' => 'nullable'
        ];
    }
}
