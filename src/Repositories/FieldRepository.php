<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Field;
use App\Repositories\BaseRepository;

/**
 * Class FieldRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version December 31, 2020, 9:19 am UTC
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
