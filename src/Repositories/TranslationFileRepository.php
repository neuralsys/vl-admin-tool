<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\TranslationFile;
use App\Repositories\BaseRepository;

/**
 * Class TranslationFileRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 6, 2021, 7:46 am UTC
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
