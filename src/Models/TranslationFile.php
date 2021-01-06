<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class TranslationFile
 * @package Vuongdq\VLAdminTool\Models
 * @version January 6, 2021, 7:46 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $translations
 * @property string $filename
 */
class TranslationFile extends EloquentModel
{
    
    public $table = 'translation_files';

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function translations()
    {
        return $this->hasMany(\Vuongdq\VLAdminTool\Models\Translation::class, 'file_id');
    }
}
