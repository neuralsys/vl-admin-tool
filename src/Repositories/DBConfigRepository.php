<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\DBConfig;
use App\Repositories\BaseRepository;

/**
 * Class DBConfigRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:06 am UTC
*/

class DBConfigRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return DBConfig::class;
    }
}
