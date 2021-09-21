<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class UserRole
 * @package Vuongdq\VLAdminTool\Models
 * @version August 23, 2021, 9:02 am UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\Role $role
 * @property integer $user_id
 * @property integer $role_id
 */
class UserRole extends EloquentModel
{
        public $table = 'user_roles';

    public $fillable = [
        'user_id',
        'role_id'
    ];

    public $timestamps = false;

    protected $primaryKey = 'id';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'role_id' => 'integer'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id', 'id');
    }
}
