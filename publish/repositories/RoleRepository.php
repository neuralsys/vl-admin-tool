<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\BaseRepository;

/**
 * Class RoleRepository
 * @package App\Repositories
 * @version August 23, 2021, 8:21 am UTC
*/

class RoleRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Role::class;
    }
}
