<?php

namespace Vuongdq\VLAdminTool\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Vuongdq\VLAdminTool\Models\Menu;

class UpdateMenuRequest extends FormRequest
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
            'type' => 'required|string|max:255',
                'url_pattern' => 'nullable|string|max:255',
                'index_route_name' => 'nullable|string|max:255',
                'title' => 'required|string|max:255',
                'parent_id' => 'required|integer',
                'pos' => 'required|integer',
                'created_at' => 'nullable',
                'updated_at' => 'nullable'
        ];
        
        return $rules;
    }
}
