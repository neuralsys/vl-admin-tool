<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\BaseRepository;

/**
 * Class PermissionRepository
 * @package App\Repositories
 * @version August 23, 2021, 8:21 am UTC
*/

class PermissionRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permission::class;
    }
}
