<?php

namespace Vuongdq\VLAdminTool\Repositories;

use Vuongdq\VLAdminTool\Models\Menu;
use App\Repositories\BaseRepository;

/**
 * Class MenuRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:19 am UTC
*/

class MenuRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Menu::class;
    }

    public function getMenuTypes() {
        $templateType = 'vl-admin-tool';
        $fieldTypesPath = get_templates_package_path($templateType).'/templates/menu';
        $res = [];
        foreach(glob($fieldTypesPath.'/*.stub') as $file) {
            $fileInfo = pathinfo($file);
            $res[] = $fileInfo['filename'];
        }

        return $res;
    }
}



