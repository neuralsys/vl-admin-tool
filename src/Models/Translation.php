<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Translation
 * @package Vuongdq\VLAdminTool\Models
 * @version January 7, 2021, 3:24 am UTC
 *
 * @property \Vuongdq\VLAdminTool\Models\TranslationFile $file
 * @property \Vuongdq\VLAdminTool\Models\Lang $lang
 * @property integer $file_id
 * @property integer $lang_id
 * @property string $key
 * @property string $value
 */
class Translation extends EloquentModel
{
    
    public $table = 'translations';

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function file()
    {
        return $this->belongsTo(\Vuongdq\VLAdminTool\Models\TranslationFile::class, 'file_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function lang()
    {
        return $this->belongsTo(\Vuongdq\VLAdminTool\Models\Lang::class, 'lang_id');
    }
}
