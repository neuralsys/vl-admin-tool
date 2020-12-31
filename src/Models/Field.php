<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Field
 * @package Vuongdq\VLAdminTool\Models
 * @version December 31, 2020, 9:19 am UTC
 *
 * @property \Vuongdq\VLAdminTool\Models\Model $model
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
class Field extends EloquentModel
{
    
    public $table = 'fields';

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function model()
    {
        return $this->belongsTo(\Vuongdq\VLAdminTool\Models\Model::class, 'model_id');
    }
}
