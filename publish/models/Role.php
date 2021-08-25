<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class Role
 * @package Vuongdq\VLAdminTool\Models
 * @version August 23, 2021, 8:21 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $permissions
 * @property \Illuminate\Database\Eloquent\Collection $users
 * @property id $id
 * @property string $code
 * @property string $title
 */
class Role extends EloquentModel
{
    const SUPER_ADMIN = "super_admin";
    public $table = 'roles';

    public $fillable = [
        'code',
        'title'
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
        'code' => 'string',
        'title' => 'string'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_roles', 'role_id', 'user_id');
    }
}
