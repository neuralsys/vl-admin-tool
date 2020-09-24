<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Translation
 * @package App\Models
 * @version September 23, 2020, 11:48 am +07
 *
 * @property integer $file_id
 * @property integer $lang_id
 * @property string $key
 * @property string $value
 */
class Translation extends Model
{

    public $table = 'translations';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'file_id',
        'lang_id',
        'key',
        'value'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'file_id' => 'integer',
        'lang_id' => 'integer',
        'key' => 'string',
        'value' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'file_id' => 'required',
        'lang_id' => 'required',
        'key' => 'required|string|max:255',
        'value' => 'required|string|max:255'
    ];


}
