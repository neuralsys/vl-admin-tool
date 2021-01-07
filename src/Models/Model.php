<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Model
 * @package Vuongdq\VLAdminTool\Models
 * @version January 7, 2021, 3:18 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $fields
 * @property string $class_name
 * @property string $table_name
 * @property string $singular
 * @property string $plural
 * @property string $description
 * @property boolean $timestamps
 * @property boolean $soft_delete
 */
class Model extends EloquentModel
{
    
    public $table = 'models';

    public $fillable = [
        'class_name',
        'table_name',
        'singular',
        'plural',
        'description',
        'timestamps',
        'soft_delete'
    ];

    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'class_name' => 'string',
        'table_name' => 'string',
        'singular' => 'string',
        'plural' => 'string',
        'description' => 'string',
        'timestamps' => 'boolean',
        'soft_delete' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function fields()
    {
        return $this->hasMany(\Vuongdq\VLAdminTool\Models\Field::class, 'model_id');
    }
}
