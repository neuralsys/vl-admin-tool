<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\DTConfig;
use Vuongdq\VLAdminTool\Repositories\BaseRepository;

/**
 * Class DTConfigRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:20 am UTC
*/

class DTConfigRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return DTConfig::class;
    }
}
