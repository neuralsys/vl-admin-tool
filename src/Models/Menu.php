<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Menu
 * @package App\Models
 * @version September 18, 2020, 11:31 am +07
 *
 * @property string $url_pattern
 * @property string $index_url
 * @property string $title
 * @property integer $parent_id
 */
class Menu extends Model
{

    public $table = 'menus';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';




    public $fillable = [
        'url_pattern',
        'index_url',
        'title',
        'parent_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'url_pattern' => 'string',
        'index_url' => 'string',
        'title' => 'string',
        'parent_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'url_pattern' => 'required|string|max:255',
        'index_url' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'parent_id' => 'required|integer'
    ];


}
