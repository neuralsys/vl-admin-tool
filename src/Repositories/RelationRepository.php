<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Relation;
use App\Repositories\BaseRepository;

/**
 * Class RelationRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:23 am UTC
*/

class RelationRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Relation::class;
    }
}
