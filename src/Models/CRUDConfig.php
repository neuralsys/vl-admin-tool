<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class CRUDConfig
 * @package Vuongdq\VLAdminTool\Models
 * @version January 6, 2021, 7:43 am UTC
 *
 * @property \Vuongdq\VLAdminTool\Models\Field $field
 * @property integer $field_id
 * @property boolean $creatable
 * @property boolean $editable
 * @property string $rules
 */
class CRUDConfig extends EloquentModel
{
    
    public $table = 'crud_configs';

    public $fillable = [
        'field_id',
        'creatable',
        'editable',
        'rules'
    ];

    
    public $timestamps = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'field_id' => 'integer',
        'creatable' => 'boolean',
        'editable' => 'boolean',
        'rules' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function field()
    {
        return $this->belongsTo(\Vuongdq\VLAdminTool\Models\Field::class, 'field_id');
    }
}
