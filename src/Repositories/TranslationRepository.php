<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Translation;
use App\Repositories\BaseRepository;

/**
 * Class TranslationRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 6, 2021, 7:46 am UTC
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
