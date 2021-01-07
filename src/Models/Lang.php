<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Lang
 * @package Vuongdq\VLAdminTool\Models
 * @version January 6, 2021, 7:46 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $translations
 * @property string $language
 * @property string $locale
 */
class Lang extends EloquentModel
{
    
    public $table = 'lang';

    public $fillable = [
        'language',
        'locale'
    ];

    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'language' => 'string',
        'locale' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function translations()
    {
        return $this->hasMany(\Vuongdq\VLAdminTool\Models\Translation::class, 'lang_id');
    }
}
