<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Lang;
use App\Repositories\BaseRepository;

/**
 * Class LangRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 6, 2021, 7:46 am UTC
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
