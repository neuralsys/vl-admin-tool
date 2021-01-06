<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

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
class Menu extends EloquentModel
{

    public $table = 'menus';

    public $fillable = [
        'url_pattern',
        'type',
        'index_route_name',
        'title',
        'parent_id',
        'pos',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'type' => 'string',
        'url_pattern' => 'string',
        'index_route_name' => 'string',
        'title' => 'string',
        'parent_id' => 'integer',
        'pos' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'url_pattern' => 'required|string|max:255',
        'type' => 'required|string|max:255|in:header,has-child,no-child',
        'index_route_name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'parent_id' => 'required|integer',
        'pos' => 'required|integer'
    ];

    public function parent() {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public static function boot() {
        parent::boot();

        static::creating(function (Menu $item) {
            if ($item->pos === null) {
                if (empty($item->parent))
                    $maxPos = Menu::where('parent_id', 0)->where('pos', '<>', '9999')->get()->max('pos');
                else
                    $maxPos = $item->parent->children->max('pos');
                if ($maxPos === null) $maxPos = 1;
                $item->pos = $maxPos;
            }
        });

        static::deleting(function (Menu $item) {
            $children = $item->children;
            foreach ($children as $child) {
                $child->parent_id = 0;
                $child->save();
            }
        });
    }
}
