<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Permission
 * @package Vuongdq\VLAdminTool\Models
 * @version August 23, 2021, 10:20 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $roles
 * @property id $id
 * @property string $name
 * @property string $href
 * @property string $category
 */
class Permission extends EloquentModel
{
    public $table = 'permissions';

    public $fillable = [
        'name',
        'href',
        'category',
        'method'
    ];

    public $timestamps = false;

    protected $primaryKey = 'id';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'href' => 'string',
        'category' => 'string',
        'method' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'role_permissions', 'permission_id', 'role_id');
    }
}
