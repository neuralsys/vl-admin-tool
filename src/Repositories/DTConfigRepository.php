<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\DTConfig;
use App\Repositories\BaseRepository;

/**
 * Class DTConfigRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 6, 2021, 7:43 am UTC
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
