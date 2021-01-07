<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Field
 * @package Vuongdq\VLAdminTool\Models
 * @version January 7, 2021, 3:18 am UTC
 *
 * @property \Vuongdq\VLAdminTool\Models\Model $model
 * @property \Illuminate\Database\Eloquent\Collection $crudConfigs
 * @property \Illuminate\Database\Eloquent\Collection $dbConfigs
 * @property \Illuminate\Database\Eloquent\Collection $dtConfigs
 * @property \Vuongdq\VLAdminTool\Models\Relation $relation
 * @property \Illuminate\Database\Eloquent\Collection $relation1s
 * @property integer $model_id
 * @property string $name
 * @property string $html_type
 */
class Field extends EloquentModel
{
    
    public $table = 'fields';

    public $fillable = [
        'model_id',
        'name',
        'html_type'
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
        'html_type' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function model()
    {
        return $this->belongsTo(\Vuongdq\VLAdminTool\Models\Model::class, 'model_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function crudConfigs()
    {
        return $this->hasMany(\Vuongdq\VLAdminTool\Models\CrudConfig::class, 'field_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function dbConfigs()
    {
        return $this->hasMany(\Vuongdq\VLAdminTool\Models\DbConfig::class, 'field_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function dtConfigs()
    {
        return $this->hasMany(\Vuongdq\VLAdminTool\Models\DtConfig::class, 'field_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function relation()
    {
        return $this->hasOne(\Vuongdq\VLAdminTool\Models\Relation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function relation1s()
    {
        return $this->hasMany(\Vuongdq\VLAdminTool\Models\Relation::class, 'second_field_id');
    }
}
