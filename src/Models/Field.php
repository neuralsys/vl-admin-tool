<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Field
 * @package App\Models
 * @version November 27, 2020, 9:03 am UTC
 *
 * @property integer $model_id
 * @property string $name
 * @property string $db_type
 * @property string $html_type
 * @property boolean $primary
 * @property boolean $unique
 * @property boolean $auto_increment
 * @property boolean $nullable
 * @property boolean $creatable
 * @property boolean $editable
 */
class Field extends Model
{

    public $table = 'fields';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'model_id',
        'name',
        'db_type',
        'html_type',
        'primary',
        'unique',
        'auto_increment',
        'nullable',
        'creatable',
        'editable'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'model_id' => 'integer',
        'name' => 'string',
        'db_type' => 'string',
        'html_type' => 'string',
        'primary' => 'boolean',
        'unique' => 'boolean',
        'auto_increment' => 'boolean',
        'nullable' => 'boolean',
        'creatable' => 'boolean',
        'editable' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'model_id' => 'required',
        'name' => 'required|string|max:255',
        'db_type' => 'required|string|max:255',
        'html_type' => 'required|string|max:255',
        'primary' => 'required|boolean',
        'unique' => 'required|boolean',
        'auto_increment' => 'required|boolean',
        'nullable' => 'required|boolean',
        'creatable' => 'required|boolean',
        'editable' => 'required|boolean'
    ];


}
