<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Translation;
use Vuongdq\VLAdminTool\Repositories\BaseRepository;

/**
 * Class TranslationRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:24 am UTC
*/

class TranslationRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Translation::class;
    }
}
