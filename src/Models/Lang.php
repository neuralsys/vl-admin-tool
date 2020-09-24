<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Lang
 * @package App\Models
 * @version September 23, 2020, 11:47 am +07
 *
 * @property string $language
 * @property string $locale
 */
class Lang extends Model
{

    public $table = 'lang';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




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
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'language' => 'required|string|max:255',
        'locale' => 'required|string|max:255'
    ];


}
