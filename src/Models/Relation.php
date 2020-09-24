<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Relation
 * @package App\Models
 * @version September 18, 2020, 11:19 am +07
 *
 * @property string $type
 * @property integer $first_model_id
 * @property string $first_foreign_key
 * @property integer $second_model_id
 * @property string $second_foreign_key
 * @property string $table_name
 * @property string $first_key
 * @property string $second_key
 */
class Relation extends Model
{

    public $table = 'relations';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'type',
        'first_model_id',
        'first_foreign_key',
        'second_model_id',
        'second_foreign_key',
        'table_name',
        'first_key',
        'second_key'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type' => 'string',
        'first_model_id' => 'integer',
        'first_foreign_key' => 'string',
        'second_model_id' => 'integer',
        'second_foreign_key' => 'string',
        'table_name' => 'string',
        'first_key' => 'string',
        'second_key' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required|string|max:255',
        'first_model_id' => 'required',
        'first_foreign_key' => 'required|string|max:255',
        'second_model_id' => 'required',
        'second_foreign_key' => 'required|string|max:255',
        'table_name' => 'nullable|string|max:255',
        'first_key' => 'nullable|string|max:255',
        'second_key' => 'nullable|string|max:255'
    ];


}
