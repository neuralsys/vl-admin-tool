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
    public function crudConfig()
    {
        return $this->hasOne(\Vuongdq\VLAdminTool\Models\CRUDConfig::class, 'field_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function dbConfig()
    {
        return $this->hasOne(\Vuongdq\VLAdminTool\Models\DBConfig::class, 'field_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function dtConfig()
    {
        return $this->hasOne(\Vuongdq\VLAdminTool\Models\DTConfig::class, 'field_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function relations()
    {
        return $this->hasMany(\Vuongdq\VLAdminTool\Models\Relation::class, 'first_field_id');
    }

    public static function boot() {
        parent::boot();

        //while creating/inserting item into db
        static::deleting(function (Field $item) {
            $item->crudConfig->delete();
            $item->dbConfig->delete();
            $item->dtConfig->delete();
            $item->relations()->delete();
        });
    }
}
