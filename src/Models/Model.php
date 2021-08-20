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
 * @property boolean $use_timestamps
 * @property boolean $use_soft_delete
 * @property boolean $is_authenticate
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
        'use_timestamps',
        'use_soft_delete',
        'is_authenticate'
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
        'use_timestamps' => 'boolean',
        'use_soft_delete' => 'boolean',
        'is_authenticate' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function fields()
    {
        return $this->hasMany(\Vuongdq\VLAdminTool\Models\Field::class, 'model_id');
    }

    public static function boot() {
        parent::boot();

        //while creating/inserting item into db
        static::deleting(function (Model $item) {
            $fields = $item->fields;
            foreach ($fields as $field) {
                $field->delete();
            }
        });
    }
}
