<?php

namespace Vuongdq\VLAdminTool\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vuongdq\VLAdminTool\Models\Model;

class UpdateModelRequest extends FormRequest
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
            'class_name' => 'required|string|max:255',
                'table_name' => 'required|string|max:255',
                'singular' => 'required|string|max:255',
                'plural' => 'required|string|max:255',
                'description' => 'nullable|string',
                'use_timestamps' => 'required|boolean',
                'use_soft_delete' => 'required|boolean',
                'is_authenticate' => 'required|boolean',
        ];

        return $rules;
    }
}
