<?php

namespace Vuongdq\VLAdminTool\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Menu
 * @package Vuongdq\VLAdminTool\Models
 * @version January 6, 2021, 7:28 am UTC
 *
 * @property int $id
 * @property string $type
 * @property string $url_pattern
 * @property string $index_route_name
 * @property string $title
 * @property integer $parent_id
 * @property integer $pos
 */
class Menu extends EloquentModel
{

    public $table = 'menus';

    public $fillable = [
        'type',
        'url_pattern',
        'index_route_name',
        'title',
        'parent_id',
        'pos'
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
                else $maxPos += 1;
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
