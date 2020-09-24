<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class TranslationFile
 * @package App\Models
 * @version September 23, 2020, 11:48 am +07
 *
 * @property string $filename
 */
class TranslationFile extends Model
{

    public $table = 'translation_files';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'filename'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'filename' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'filename' => 'required|string|max:255'
    ];


}
