<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class DTConfig
 * @package Vuongdq\VLAdminTool\Models
 * @version January 6, 2021, 7:43 am UTC
 *
 * @property \Vuongdq\VLAdminTool\Models\Field $field
 * @property integer $field_id
 * @property boolean $showable
 * @property boolean $searchable
 * @property boolean $orderable
 * @property boolean $exportable
 * @property boolean $printable
 * @property string $class
 * @property boolean $has_footer
 */
class DTConfig extends EloquentModel
{
    
    public $table = 'dt_configs';

    public $fillable = [
        'field_id',
        'showable',
        'searchable',
        'orderable',
        'exportable',
        'printable',
        'class',
        'has_footer'
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
        'showable' => 'boolean',
        'searchable' => 'boolean',
        'orderable' => 'boolean',
        'exportable' => 'boolean',
        'printable' => 'boolean',
        'class' => 'string',
        'has_footer' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function field()
    {
        return $this->belongsTo(\Vuongdq\VLAdminTool\Models\Field::class, 'field_id');
    }
}
