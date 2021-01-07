<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Field;
use App\Repositories\BaseRepository;

/**
 * Class FieldRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:18 am UTC
*/

class FieldRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Field::class;
    }
}
