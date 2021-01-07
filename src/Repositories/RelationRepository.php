<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Relation;
use App\Repositories\BaseRepository;

/**
 * Class RelationRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 6, 2021, 7:44 am UTC
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
