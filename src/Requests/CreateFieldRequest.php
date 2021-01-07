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
            'created_at' => 'nullable',
            'updated_at' => 'nullable'
        ];
    }
}
