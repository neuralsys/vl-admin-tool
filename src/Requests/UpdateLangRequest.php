<?php

namespace Vuongdq\VLAdminTool\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vuongdq\VLAdminTool\Models\Lang;

class UpdateLangRequest extends FormRequest
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
            'language' => 'required|string|max:255',
                'locale' => 'required|string|max:255',
                'created_at' => 'nullable',
                'updated_at' => 'nullable'
        ];
        
        return $rules;
    }
}
