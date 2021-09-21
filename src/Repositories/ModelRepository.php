<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Model;
use Vuongdq\VLAdminTool\Repositories\BaseRepository;

/**
 * Class ModelRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:18 am UTC
*/

class ModelRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Model::class;
    }
}
