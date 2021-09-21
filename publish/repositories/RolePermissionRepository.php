<?php

namespace App\Repositories;

use App\Models\RolePermission;
use App\Repositories\BaseRepository;

/**
 * Class RolePermissionRepository
 * @package App\Repositories
 * @version August 23, 2021, 8:23 am UTC
*/

class RolePermissionRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return RolePermission::class;
    }
}
