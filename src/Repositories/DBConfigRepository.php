<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\DBConfig;
use App\Repositories\BaseRepository;

/**
 * Class DBConfigRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 6, 2021, 7:43 am UTC
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
