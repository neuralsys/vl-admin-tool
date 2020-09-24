<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as ModelE;

/**
 * Class Models
 * @package App\Models
 * @version September 18, 2020, 11:16 am +07
 *
 * @property \App\Models\Project $project
 * @property integer $project_id
 * @property string $class_name
 * @property string $table_name
 * @property string $description
 * @property boolean $timestamps
 * @property boolean $soft_delete
 * @property boolean $test
 * @property boolean $swagger
 * @property boolean $datatables
 * @property boolean $paginate
 */
class Model extends ModelE
{

    public $table = 'models';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'class_name',
        'table_name',
        'description',
        'timestamps',
        'soft_delete',
        'test',
        'swagger',
        'datatables',
        'paginate'
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
        'description' => 'string',
        'timestamps' => 'boolean',
        'soft_delete' => 'boolean',
        'test' => 'boolean',
        'swagger' => 'boolean',
        'datatables' => 'boolean',
        'paginate' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'class_name' => 'required|string|max:255',
        'table_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'timestamps' => 'required|boolean',
        'soft_delete' => 'required|boolean',
        'test' => 'required|boolean',
        'swagger' => 'required|boolean',
        'datatables' => 'required|boolean',
        'paginate' => 'required|boolean'
    ];
}
