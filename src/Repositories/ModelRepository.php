<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Model;

/**
 * Class ModelRepository
 * @package App\Repositories
 * @version September 18, 2020, 11:16 am +07
*/

class ModelRepository extends BaseRepository
{
    /**
     * Configure the Models
     **/
    public function model()
    {
        return Model::class;
    }
}
