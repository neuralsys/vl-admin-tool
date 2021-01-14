<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class DBConfig
 * @package Vuongdq\VLAdminTool\Models
 * @version January 7, 2021, 3:19 am UTC
 *
 * @property \Vuongdq\VLAdminTool\Models\Field $field
 * @property integer $field_id
 * @property string $type
 * @property integer $length
 * @property boolean $nullable
 * @property boolean $unique
 * @property string $default
 */
class DBConfig extends EloquentModel
{

    public $table = 'db_configs';

    public $fillable = [
        'field_id',
        'type',
        'length',
        'nullable',
        'unique',
        'default'
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
        'type' => 'string',
        'length' => 'integer',
        'nullable' => 'integer',
        'unique' => 'integer',
        'default' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function field()
    {
        return $this->belongsTo(\Vuongdq\VLAdminTool\Models\Field::class, 'field_id');
    }
}
