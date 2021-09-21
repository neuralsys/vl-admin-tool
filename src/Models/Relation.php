<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Relation
 * @package Vuongdq\VLAdminTool\Models
 * @version January 7, 2021, 3:23 am UTC
 *
 * @property \Vuongdq\VLAdminTool\Models\Field $firstField
 * @property \Vuongdq\VLAdminTool\Models\Field $secondField
 * @property integer $first_field_id
 * @property integer $second_field_id
 * @property string $type
 * @property string $table_name
 * @property string $fk_1
 * @property string $fk_2
 */
class Relation extends EloquentModel
{

    public $table = 'relations';

    public $fillable = [
        'first_field_id',
        'second_field_id',
        'type',
        'table_name',
        'fk_1',
        'fk_2'
    ];


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'first_field_id' => 'integer',
        'second_field_id' => 'integer',
        'type' => 'string',
        'table_name' => 'string',
        'fk_1' => 'string',
        'fk_2' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function firstField()
    {
        return $this->belongsTo(\Vuongdq\VLAdminTool\Models\Field::class, 'first_field_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function secondField()
    {
        return $this->belongsTo(\Vuongdq\VLAdminTool\Models\Field::class, 'second_field_id');
    }
}
