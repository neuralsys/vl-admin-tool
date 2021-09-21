<?php

namespace Vuongdq\VLAdminTool\Repositories;

/**
 * Class ViewTemplateRepository
 * @package Vuongdq\VLAdminTool\Repositories
 * @version January 7, 2021, 3:19 am UTC
*/

class ViewTemplateRepository
{
    public function getFieldTypes() {
        $templateType = config('vl_admin_tool.templates', 'adminlte-templates');
        $fieldTypesPath = get_templates_package_path($templateType).'/templates/fields';
        $res = [];
        foreach(glob($fieldTypesPath.'/*.stub') as $file) {
            $fileInfo = pathinfo($file);
            $res[] = $fileInfo['filename'];
        }

        return $res;
    }
}
