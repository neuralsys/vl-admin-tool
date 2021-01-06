<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\CRUDConfig;
use App\Repositories\BaseRepository;

/**
 * Class CRUDConfigRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 6, 2021, 7:43 am UTC
*/

class CRUDConfigRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return CRUDConfig::class;
    }
}
