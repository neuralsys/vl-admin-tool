<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\TranslationFile;
use Vuongdq\VLAdminTool\Repositories\BaseRepository;

/**
 * Class TranslationFileRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:24 am UTC
*/

class TranslationFileRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return TranslationFile::class;
    }
}
