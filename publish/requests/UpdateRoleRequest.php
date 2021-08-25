<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Role;

class UpdateRoleRequest extends FormRequest
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
            'code' => 'required|string|max:45',
            'title' => 'required|string|max:45'
        ];
        
        return $rules;
    }
}
