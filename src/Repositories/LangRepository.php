<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Lang;
use Vuongdq\VLAdminTool\Repositories\BaseRepository;

/**
 * Class LangRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:23 am UTC
*/

class LangRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Lang::class;
    }
}
