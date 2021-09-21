<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class RolePermission
 * @package Vuongdq\VLAdminTool\Models
 * @version August 23, 2021, 8:23 am UTC
 *
 * @property \App\Models\Role $role
 * @property \App\Models\Permission $permission
 * @property integer $role_id
 * @property integer $permission_id
 */
class RolePermission extends EloquentModel
{
        public $table = 'role_permissions';

    public $fillable = [
        'role_id',
        'permission_id'
    ];

    public $timestamps = false;

    protected $primaryKey = 'id';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'role_id' => 'integer',
        'permission_id' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function permission()
    {
        return $this->belongsTo(\App\Models\Permission::class, 'permission_id', 'id');
    }
}
