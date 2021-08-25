<?php

namespace App\Repositories;

use App\Models\UserRole;
use App\Repositories\BaseRepository;

/**
 * Class UserRoleRepository
 * @package App\Repositories
 * @version August 23, 2021, 9:01 am UTC
*/

class UserRoleRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserRole::class;
    }
}
